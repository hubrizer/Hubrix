<?php
namespace Hubrix\Core\Http;

class Route {

    protected static array $routes = [];
    protected static array $groupAttributes = [];
    protected static array $middlewareCache = [];

    public static function get($uri, $action, $middleware = []): void
    {
        self::addRoute('GET', $uri, $action, $middleware);
    }

    public static function post($uri, $action, $middleware = []): void
    {
        self::addRoute('POST', $uri, $action, $middleware);
    }

    public static function group(array $attributes, \Closure $callback): void
    {
        $previousGroupAttributes = self::$groupAttributes;
        self::$groupAttributes = array_merge(self::$groupAttributes, $attributes);
        call_user_func($callback);
        self::$groupAttributes = $previousGroupAttributes;
    }

    protected static function addRoute($method, $uri, $action, $middleware = []): void {
        $uri = self::applyPrefix($uri);

        // Convert dynamic segments (e.g., {id}) to regex patterns
        $uriPattern = self::convertUriToPattern($uri);

        $route = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware,
            'uriPattern' => $uriPattern
        ];

        self::$routes[] = $route;
        // Optional: Log route registration in debug mode
    }

    protected static function applyPrefix($uri): string
    {
        if (!empty(self::$groupAttributes['prefix'])) {
            $uri = '/' . trim(self::$groupAttributes['prefix'], '/') . '/' . ltrim($uri, '/');
        }

        return '/' . trim(HUBRIX_PLUGIN_SLUG, '/') . '/' . trim($uri, '/');
    }

    protected static function convertUriToPattern($uri): string
    {
        return preg_replace('/\{[^}]+}/', '([^\/]+)', $uri);
    }

    public static function dispatch() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (!str_starts_with($requestUri, '/' . HUBRIX_PLUGIN_SLUG)) {
            return; // Let WordPress handle it
        }

        foreach (self::filterRoutesByMethod($requestMethod) as $route) {
            if (self::matchRoute($route, $requestUri, $matches)) {
                self::handleRoute($route, $matches);
                return;
            }
        }

        self::handle404($requestUri);
    }

    protected static function filterRoutesByMethod($method): array
    {
        return array_filter(self::$routes, fn($route) => $route['method'] === $method);
    }

    protected static function matchRoute($route, $requestUri, &$matches): bool
    {
        $pattern = '@^' . $route['uriPattern'] . '$@';
        return preg_match($pattern, $requestUri, $matches);
    }

    protected static function handleRoute($route, $matches): void
    {
        array_shift($matches); // Remove the full match from $matches

        // Run the route's middleware
        self::runMiddleware($route['middleware']);

        $response = null;

        // Call the action and capture the response
        if (is_callable($route['action'])) {
            $response = call_user_func_array($route['action'], $matches);
        } elseif (is_string($route['action'])) {
            list($controller, $method) = explode('@', $route['action']);
            $controllerInstance = new $controller();
            $response = call_user_func_array([$controllerInstance, $method], $matches);
        }

        // If the action returns a response, output it
        if (is_string($response)) {
            echo $response;
        } elseif (is_array($response) || is_object($response)) {
            // Optionally handle JSON responses, if needed
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    protected static function runMiddleware($middlewareList): void
    {
        foreach ($middlewareList as $middleware) {
            if (!isset(self::$middlewareCache[$middleware])) {
                self::$middlewareCache[$middleware] = new $middleware();
            }
            self::$middlewareCache[$middleware]->handle();
        }
    }

    protected static function handle404($uri = null): void {
        status_header(404);

        if (!$uri) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        echo view('errors.404', ['uri' => $uri, 'error' => '404 Not Found', 'message' => "The route for the requested URI <strong>" . esc_html($uri) . "</strong> could not be found."]);
        exit;
    }
}