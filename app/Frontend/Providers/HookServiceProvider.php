<?php

namespace App\Frontend\Providers;

use ReflectionClass;

class HookServiceProvider
{
    /**
     * Register the hooks by autoloading them.
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Autoloading frontend hooks...');
        $this->autoloadHooks();
    }

    /**
     * Autoload all hook classes from the Hooks directory.
     *
     * @return void
     */
    protected function autoloadHooks(): void
    {
        $hookPath = __DIR__ . '/../Hooks';

        foreach (glob($hookPath . '/*.php') as $file) {
            $className = 'App\\Frontend\\Hooks\\' . basename($file, '.php');

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                if ($reflection->hasMethod('init')) {
                    $className::init();
                }
            }
        }
    }
}

