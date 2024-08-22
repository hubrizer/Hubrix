<?php

namespace App\Plugin\Hooks;

use function App\Plugin\delete_transient;
use function App\Plugin\flush_rewrite_rules;
use function App\Plugin\wp_clear_scheduled_hook;

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
    public static function deactivate() {
        error_log('Deactivating plugin'); // Add this to confirm the method is being called

        Cron::unschedule_all_jobs(); // Unschedule jobs on deactivation

        // Clear scheduled events
        wp_clear_scheduled_hook('pb_cron_event');

        // Optionally, you can also deactivate other features
        // For example: remove temporary options or transient data
        delete_transient('pb_temp_data');

        flush_rewrite_rules();
    }
}
