<?php

namespace App\Backend\Providers;

use App\Core\ServiceProviderRegistry;
use Exception;
use ReflectionClass;

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

    public function register(): void
    {
        if (is_admin() && !wp_doing_ajax()) {
            return;
        }

        $this->autoloadHandlers();
    }

    public static function create()
    {
        return new self();
    }

    protected function autoloadHandlers(): void
    {
        error_log('Autoloading backend handlers...');

        $handlerPath = HUBRIX_BACKEND_DIR . 'Handlers';

        foreach (glob($handlerPath . '/**/*.php') as $file) {
            try {
                $className = $this->getClassNameFromFile($file);

                if (class_exists($className)) {
                    $reflection = new ReflectionClass($className);

                    if ($reflection->hasMethod('register')) {
                        $instance = new $className();
                        $instance->register();
                    } else {
                        error_log('Backend class does not have register method: ' . $className);
                    }
                } else {
                    error_log('Class not found: ' . $className);
                }
            } catch (Exception $e) {
                error_log('Error loading backend handler: ' . $e->getMessage());
            }
        }
    }

    private function getClassNameFromFile(string $file): string
    {
        $relativePath = str_replace(HUBRIX_BACKEND_DIR, '', $file);
        $relativePath = str_replace(['/', '\\'], '\\', $relativePath);
        $relativePath = str_replace('.php', '', $relativePath);

        return 'App\\Backend\\' . $relativePath;
    }

    private function __clone() {}
    public function __wakeup() {}
}