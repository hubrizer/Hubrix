<?php

namespace App\Frontend\Providers;

use Exception;
use ReflectionClass;

/**
 * Class HandlerServiceProvider
 * Description: This class is used to autoload frontend handlers.
 *
 * @package App\Frontend\Providers
 */
class HandlerServiceProvider
{
    private static $instance = null;

    private function __construct()
    {
        // Your constructor logic here
    }

    /**
     * Get the singleton instance of the HandlerServiceProvider.
     *
     * @return HandlerServiceProvider
     */
    public static function getInstance(): HandlerServiceProvider
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function create()
    {
        return new self();
    }

    /**
     * Register the service provider.
     * Description: This method is used to register the service. It's currently empty but is required by the Kernel.
     *
     * @return void
     */
    public function register()
    {
        if (is_admin() && !wp_doing_ajax()) {
            return;
        }

        $this->autoloadHandlers();
    }

    /**
     * Autoload frontend handlers.
     * Description: This method is used to autoload frontend handlers.
     *
     * @return void
     */
    protected function autoloadHandlers(): void
    {
        error_log('Autoloading frontend handlers...');

        $handlerPath = HUBRIX_FRONTEND_DIR . 'Handlers';

        foreach (glob($handlerPath . '/**/*.php') as $file) {
            try {
                $className = $this->getClassNameFromFile($file);

                if (class_exists($className)) {
                    $reflection = new ReflectionClass($className);

                    if ($reflection->hasMethod('register')) {
                        $instance = new $className();
                        $instance->register();
                    } else {
                        error_log('Frontend class does not have register method: ' . $className);
                    }
                } else {
                    error_log('Class not found: ' . $className);
                }
            } catch (Exception $e) {
                error_log('Error loading frontend handler: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get class name from file.
     * Description: This method is used to get the class name from a file.
     *
     * @param string $file
     * @return string
     */
    private function getClassNameFromFile(string $file): string
    {
        $relativePath = str_replace(HUBRIX_FRONTEND_DIR, '', $file);
        $relativePath = str_replace(['/', '\\'], '\\', $relativePath);
        $relativePath = str_replace('.php', '', $relativePath);

        return 'App\\Frontend\\' . $relativePath;
    }

    private function __clone() {}
    public function __wakeup() {}
}
