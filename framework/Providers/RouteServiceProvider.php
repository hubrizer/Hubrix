<?php
namespace Hubrix\Providers;

class RouteServiceProvider {
    protected static $routesLoaded = false;

    /**
     * Register the BladeOne service
     * Description: This method is used to register the BladeOne service within the plugin.
     *
     * @throws Exception
     * @return void
     */
    public function register(): void
    {
        error_log("RouteServiceProvider::register() method is being called.");
        $this->boot();
    }

    public static function boot() {
        // Load routes if not already loaded
        if (!self::$routesLoaded) {
            self::loadRoutes();
            self::$routesLoaded = true;
        }
    }

    protected static function loadRoutes() {
        // Load web routes for both frontend and admin area
        if (file_exists(HUBRIX_ROOT_DIR . 'routes/web.php')) {
            error_log('Loading web routes');
            require_once HUBRIX_ROOT_DIR . 'routes/web.php';
        } else {
            error_log('Web routes file not found: ' . HUBRIX_ROOT_DIR . 'routes/web.php');
        }

        // Load API routes if it's an API request
        if (file_exists(HUBRIX_ROOT_DIR . 'routes/api.php')) {
            error_log('Loading API routes');
            require_once HUBRIX_ROOT_DIR . 'routes/api.php';
        } else {
            error_log('API routes file not found: ' . HUBRIX_ROOT_DIR . 'routes/api.php');
        }
    }
}