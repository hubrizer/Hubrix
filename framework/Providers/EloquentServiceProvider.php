<?php

namespace Hubrix\Providers;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentServiceProvider {

    /**
     * Indicates if the provider has been booted.
     *
     * @var bool
     */
    private static $booted = false;

    /**
     * Register the service provider.
     * Description: This method is used to register the service. It's currently empty but is required by the Kernel.
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Registering Eloquent service provider...');
    }

    /**
     * Boot the Eloquent service.
     *
     * @return void
     */
    public static function boot(): void {
        if (!self::$booted) {
            self::initializeEloquent();
            self::$booted = true;
        }
    }

    public static function initializeEloquent(): void
    {
        try {
            global $wpdb;

            $capsule = new Capsule;

            $capsule->addConnection([
                'driver'    => defined('DB_DRIVER') ? DB_DRIVER : 'mysql',
                'host'      => DB_HOST,         // WordPress constant
                'database'  => DB_NAME,         // WordPress constant
                'username'  => DB_USER,         // WordPress constant
                'password'  => DB_PASSWORD,     // WordPress constant
                'charset'   => $wpdb->charset,  // Using WordPress charset
                'collation' => $wpdb->collate,  // Using WordPress collation
                'prefix'    => $wpdb->prefix,   // Using WordPress table prefix
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        } catch (Exception $e) {
            error_log('Failed to boot Eloquent: ' . $e->getMessage());
            // Handle gracefully if needed
        }
    }
}