<?php

namespace App\Plugin\Hooks;

defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Deactivate Class
 *
 * @package Hubrix\Core
 */
class Deactivate {

    /**
     * Run deactivation code
     */
    public static function start(): void {
        self::unschedule_cron_jobs();
        self::clear_scheduled_events();
        self::remove_temp_data();
        error_log('Plugin deactivation completed.');
    }

    /**
     * Unschedule all cron jobs
     *
     * @return void
     */
    private static function unschedule_cron_jobs(): void {
        Cron::unschedule_all_jobs();
        error_log('Cron jobs unscheduled.');
    }

    /**
     * Clear scheduled events
     *
     * @return void
     */
    private static function clear_scheduled_events(): void {
        wp_clear_scheduled_hook('pb_cron_event');
        error_log('Cleared scheduled event: pb_cron_event.');
    }


    /**
     * Remove temporary data
     *
     * @return void
     */
    private static function remove_temp_data(): void {
        delete_transient('pb_temp_data');
        error_log('Deleted transient: pb_temp_data.');
    }

    /**
     * Flush rewrite rules
     *
     * @return void
     */
    private static function flush_rewrite_rules(): void {
        flush_rewrite_rules();
        error_log('Flushed rewrite rules.');
    }
}
