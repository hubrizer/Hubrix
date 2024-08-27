<?php
namespace Hubrix\Core\Helpers;

use Exception;
use Hubrix\Core\Logger as Log;
use Hubrix\Core\NonceManager;
use Hubrix\Core\Plugin\Config;
use Hubrix\Providers\BladeOneServiceProvider as BladeOne;

class CoreHelpers
{
    /**
     * Render a Blade view.
     *
     * @param string $view The view name.
     * @param array $data Data to pass to the view.
     * @return string The rendered view content.
     */
    public static function view(string $view, array $data = []): string
    {
        try {
            return BladeOne::render($view, $data);
        } catch (Exception $e) {
            self::log('error', 'View Rendering Error', $e->getMessage());
            return self::fallbackView($e->getMessage());
        }
    }

    /**
     * Check if the current request is an AJAX request.
     *
     * @return bool True if the request is an AJAX request, false otherwise.
     */
    public static function isAjax(): bool
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }

    /**
     * Log messages with different levels.
     *
     * @param string $level Log level (e.g., 'error', 'info').
     * @param string $title The title of the log message.
     * @param string $description The description of the log message.
     * @param int|null $errorNumber Optional error number.
     */
    public static function my_log(string $level, string $title, string $description, int $errorNumber = null): void
    {
        $message = $title . ': ' . $description;
        $context = [];

        if ($errorNumber !== null) {
            $context['error_number'] = $errorNumber;
        }

        Log::log($level, $message, $context);
    }

    /**
     * Retrieve a WordPress option.
     *
     * @param string $option Option name.
     * @param mixed $default Default value if the option doesn't exist.
     * @return mixed Option value.
     */
    public static function option(string $option, $default = false)
    {
        return get_option($option, $default);
    }

    /**
     * Get a configuration value.
     *
     * @param string $key Configuration key.
     * @param string|null $section Optional configuration section.
     * @return mixed Configuration value.
     */
    public static function config(string $key, string $section = null): mixed
    {
        return Config::get($key, $section);
    }

    /**
     * Display an error message with instructions.
     *
     * @param int $code Error code.
     * @param string $title Error title.
     * @param string $message Error message.
     * @param array $stackTrace Optional stack trace for debugging.
     * @return void
     * @throws Exception
     */
    public static function displayError(int $code, string $title, string $message, array $stackTrace = []): void
    {
        echo self::view('errors.debug', [
            'error_code' => $code,
            'error_title' => $title,
            'error_message' => $message,
            'error_stack' => $stackTrace
        ]);
    }

    /**
     * Fallback view to display when an error occurs during rendering.
     *
     * @param string $errorMessage The error message to display.
     * @return string The fallback view content.
     */
    protected static function fallbackView(string $errorMessage): string
    {
        return "<h1>Error Rendering View</h1><p>{$errorMessage}</p>";
    }

    /**
     * Return a JSON response.
     *
     * @param array $data Data to include in the JSON response.
     * @param int $statusCode HTTP status code (default: 200).
     * @return string JSON-encoded response.
     */
    public static function jsonResponse(array $data, int $statusCode = 200): string
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }

    /**
     * Create a nonce for a specific action.
     *
     * @return string The generated nonce.
     */
    public static function create_nonce($nonce_action): string  {
        return NonceManager::create_nonce($nonce_action);
    }

    /**
     * Get all shortcodes registered by this provider.
     *
     * @return array
     */
    public static function get_registered_shortcodes(): array
    {
        global $registered_shortcodes;
        return $registered_shortcodes ?? [];
    }
}
