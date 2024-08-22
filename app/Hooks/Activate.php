<?php
namespace App\Hooks;

use Hubrix\Core\Database\Migration;

defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Activate Class
 *
 * @package Hubrix\Core
 */
class Activate {

    /**
     * Run activation code
     */
    public static function activate() {
        my_log('DEBUG', 'Activate::activate', 'Initializing activate hook', '-');

        // Ensure cron jobs are scheduled on activation
        Cron::instance()->init();

        // Run database migrations
        self::run_migrations();

        // Clear rewrite rules
        flush_rewrite_rules();

        error_log('Plugin activation completed'); // Log activation completion
    }

    /**
     * Run database migrations using Eloquent.
     *
     * @return void
     */
    private static function run_migrations(): void {
        try {
            Migration::run();
        } catch (\Exception $e) {
            error_log('Migration error: ' . $e->getMessage());
        }
    }
}