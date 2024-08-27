<?php

namespace App\Plugin\Hooks;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class Uninstall {

    public static function start(): void
    {
        // Security check
        if (!defined('WP_UNINSTALL_PLUGIN')) {
            exit;
        }

        // Handle the uninstall logic here
        self::uninstall();
    }

    private static function uninstall(): void
    {
        try {
            error_log('Uninstalling plugin and deleting data...');

            // Delete all plugin data
            // Retrieve all table names from migrations
            $tableNames = self::getTableNamesFromMigrations();

            // Truncate tables
            foreach ($tableNames as $tableName) {
                Capsule::table($tableName)->truncate();
                error_log("Truncated table: $tableName");
            }

            // Optionally, drop tables
            foreach ($tableNames as $tableName) {
                Capsule::schema()->dropIfExists($tableName);
                error_log("Dropped table: $tableName");
            }

            // Delete options at the end
            delete_option(HUBRIX_PLUGIN_SLUG.'_plugin_version');
            delete_option(HUBRIX_PLUGIN_SLUG.'_plugin_name');
            delete_option(HUBRIX_PLUGIN_SLUG.'_plugin_domain');

            error_log('Deleted plugin options.');

        } catch (Exception $e) {
            error_log('Error during plugin uninstallation: ' . $e->getMessage());
        }
    }

    private static function getTableNamesFromMigrations(): array
    {
        $tableNames = [];
        $migrationPath = __DIR__ . '/../database/migrations';

        foreach (glob($migrationPath . '/*.php') as $file) {
            require_once $file;

            $className = self::getClassNameFromFile($file);

            if (class_exists($className)) {
                $migration = new $className();

                if (method_exists($migration, 'getTableName')) {
                    $tableNames[] = $migration->getTableName();
                }
            }
        }

        return $tableNames;
    }

    private static function getClassNameFromFile($file): string
    {
        // Assuming your migration classes follow the PSR-4 naming convention and namespace
        $baseNamespace = 'App\\Database\\Migrations\\';  // Adjust this according to your namespace
        $relativePath = str_replace([__DIR__ . '/../database/migrations/', '.php'], '', $file);

        return $baseNamespace . $relativePath;
    }
}

