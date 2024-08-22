<?php

namespace Hubrix\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentServiceProvider {

    public static function boot(): void
    {
        global $wpdb;

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => DB_HOST,         // WordPress constant
            'database'  => DB_NAME,         // WordPress constant
            'username'  => DB_USER,         // WordPress constant
            'password'  => DB_PASSWORD,     // WordPress constant
            'charset'   => $wpdb->charset,  // Using WordPress charset
            'collation' => $wpdb->collate,  // Using WordPress collation
            'prefix'    => $wpdb->prefix,   // Using WordPress table prefix
        ]);

        // Make this Capsule instance available globally.
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM.
        $capsule->bootEloquent();
    }
}