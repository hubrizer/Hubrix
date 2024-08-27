<?php
namespace App\Plugin\Hooks;

use Exception;
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
    public static function start(): void {
        error_log('Initializing activate hook');

        self::schedule_cron_jobs();
        self::run_migrations();
        self::clear_rewrite_rules();

        error_log('Plugin activation completed');
    }

    /**
     * Schedule cron jobs
     */
    private static function schedule_cron_jobs(): void {
        Cron::instance()->init();
        if (!wp_next_scheduled('my_cron_event')) {
            error_log('Failed to schedule cron job.');
        }
    }

    /**
     * Clear rewrite rules
     */
    private static function clear_rewrite_rules(): void {
        flush_rewrite_rules();
    }

    /**
     * Run database migrations using Eloquent.
     *
     * @return void
     */
    private static function run_migrations(): void {
        try {
            Migration::run();
        } catch (Exception $e) {
            error_log('Migration error: ' . $e->getMessage());
        }
    }
}