<?php
namespace App\Backend\Enqueue;

class DashboardEnqueue
{
    /**
     * Initialize the enqueues for the War Room page.
     *
     * @return void
     */
    public static function init(): void
    {
        if (self::isDashboardPage()) {

            // Hook into the enqueue process to localize the script and enqueue styles/scripts
            add_action('admin_enqueue_scripts', [self::class, 'enqueueScripts'], 11);
            add_action('admin_enqueue_scripts', [self::class, 'enqueueStyles'], 11);

        }
    }

    /**
     * Enqueue scripts and styles specific to the War Room page.
     *
     * @return void
     */
    public static function enqueueScripts(): void
    {
        // Enqueue the script (with jQuery as a dependency)
        wp_enqueue_script(
            HUBRIX_PLUGIN_SLUG.'-backend-dashboard-js',
            HUBRIX_PLUGIN_URL . 'public/backend/js/dashboardScript.bundle.js',
            ['jquery'],
            HUBRIX_PLUGIN_VERSION,
            true
        );

        self::localizeScript();

    }

    public static function localizeScript(): void
    {
        // Localize script to pass AJAX URL and user login status
        wp_localize_script(
            HUBRIX_PLUGIN_SLUG.'-backend-dashboard-js',
            'js_dashboard_obj',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'placeholder_image_url' => HUBRIX_PLUGIN_URL . 'public/background/assets/images/product-placeholder.png',
                'date_format' => get_option('date_format'),
                'time_format' => get_option('time_format'),
                'nonces' => [
                    'get_data' => create_nonce('get_data'),
                ],
            ]
        );
    }

    /**
     * Enqueue styles specific to the War Room page.
     *
     * @return void
     */
    public static function enqueueStyles(): void
    {

       wp_enqueue_style(
            HUBRIX_PLUGIN_SLUG.'-backend-dashboard-css',
            HUBRIX_PLUGIN_URL . 'public/backend/css/dashboardStyle.bundle.css',
            [],
            HUBRIX_PLUGIN_VERSION,
            'all'
        );

    }

    /**
     * Check if the current admin page is the War Room page.
     *
     * @return bool
     */
    private static function isDashboardPage(): bool
    {

        return isset($_GET['page']) && $_GET['page'] === HUBRIX_PLUGIN_SLUG . '-dashboard';

    }
}