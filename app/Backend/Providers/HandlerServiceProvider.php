<?php

namespace App\Backend\Providers;

use Exception;
use ReflectionClass;

/**
 * Service provider to autoload backend handlers.
 * This class is responsible for autoloading backend handlers. It scans the Handlers directory
 *
 * @package App\Backend\Providers
 */
class HandlerServiceProvider
{
    /**
     * Register the service provider.
     * Description: This method is used to register the service. It's currently empty but is required by the Kernel.
     *
     * @return void
     */
    public function register(): void
    {
        if (!is_admin()) return;
        $this->autoloadHandlers();
    }

    /**
     * Autoload backend handlers.
     * Description: This method is used to autoload backend handlers. It scans the Handlers directory
     *
     * @return void
     */
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
                error_log('Error loading handler: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get the class name from the file path.
     * Description: This method is used to get the class name from the file path.
     *
     * @param string $file
     * @return string
     */
    private function getClassNameFromFile(string $file): string
    {
        $relativePath = str_replace(HUBRIX_BACKEND_DIR, '', $file);
        $relativePath = str_replace(['/', '\\'], '\\', $relativePath);
        $relativePath = str_replace('.php', '', $relativePath);

        return 'App\\Backend\\' . $relativePath;
    }
}
