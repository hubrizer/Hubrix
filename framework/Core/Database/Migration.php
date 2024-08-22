<?php
namespace Hubrix\Core\Database;

class Migration
{
    /**
     * Run all the migrations.
     *
     * @return void
     */
    public static function run(): void
    {
        // Run the migrations in the migrations directory
        $migrationPath = HUBRIX_PLUGIN_DIR . '/database/migrations';

        if (file_exists($migrationPath)) {
            foreach (glob($migrationPath . '/*.php') as $migration) {
                require_once $migration;
                $className = pathinfo($migration, PATHINFO_FILENAME);
                if (class_exists($className)) {
                    (new $className)->up();
                }
            }
        }
    }
}