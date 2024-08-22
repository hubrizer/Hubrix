<?php

namespace App\Frontend\Providers;

use ReflectionClass;

class AjaxServiceProvider
{
    public function register()
    {
        $this->autoloadHandlers();
    }

    protected function autoloadHandlers()
    {
        error_log('Autoloading frontend ajax handlers...');

        $handlerPath = HUBRIX_FRONTEND_DIR . 'Handlers';
        $paths = [];

        foreach (glob($handlerPath . '/**/*.php') as $file) {
            $paths[] = $file;
            $className = $this->getClassNameFromFile($file);

            // Debugging: print or log the class names
            //error_log('Attempting to load frontend class: ' . $className);

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                if ($reflection->hasMethod('register')) {
                    $instance = new $className();
                    $instance->register();
                    error_log('Registered frontend class: ' . $className);
                } else {
                    error_log('Frontend class does not have register method: ' . $className);
                }
            } else {
                error_log('Class not found: ' . $className);
            }
        }
    }

    private function getClassNameFromFile($file): string
    {
        $relativePath = str_replace(HUBRIX_FRONTEND_DIR, '', $file); // Replace the base path
        $relativePath = str_replace('/', '\\', $relativePath); // Convert directory separators to namespace separators
        $relativePath = str_replace('.php', '', $relativePath); // Remove the .php extension

        return 'App\\Frontend\\' . $relativePath;
    }
}
