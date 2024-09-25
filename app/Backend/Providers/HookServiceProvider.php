<?php

namespace App\Backend\Providers;

use ReflectionClass;

/**
 * @method static void register()
 */
class HookServiceProvider
{
    /**
     * Register the hooks by autoloading them.
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Autoloading backend hooks...');
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
            $className = 'App\\Backend\\Hooks\\' . basename($file, '.php');

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                if ($reflection->hasMethod('init')) {
                    $className::init();
                }
            }
        }

    }
}