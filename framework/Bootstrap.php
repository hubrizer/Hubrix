<?php

namespace Hubrix;

use Illuminate\Events\Dispatcher;
use Hubrix\Core\Events\EventRegistrar;

use Hubrix\Core\Plugin\Config;
use Hubrix\Core\Plugin\Menu;

defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Bootstrap class to initialize the plugin.
 *
 * This class is responsible for loading the necessary dependencies and defining
 * the hooks for the admin and frontend functionality. It acts as the entry point
 * for the plugin and delegates core responsibilities to the Kernel.
 *
 * @package Hubrix
 */
class Bootstrap {
    /**
     * Indicates whether the plugin has been initialized.
     *
     * @var bool
     */
    private static bool $initialized = false;
    protected static dispatcher $dispatcher;

    /**
     * Initialize the plugin by setting up hooks and loading dependencies.
     *
     * This method prevents multiple initializations by checking the `$initialized`
     * flag. It loads necessary dependencies, defines constants, and initializes
     * the kernel and other essential components.
     *
     * @return void
     */
    public static function init() {

        if (self::$initialized) {
            error_log('[!] Core bootstrap already initialized');
            return; // Prevent multiple initializations
        }

        error_log('* Initializing Core Bootstrap...');
        self::$initialized = true;

        self::check_compatibility();
        self::setup_error_handling();
        self::check_dependencies();
        self::load_dependencies();
        self::define_constants();

        // Delay the initialization of menus and events
        if (wp_doing_ajax()) {
            self::initialize_for_ajax();
        } elseif (is_admin()) {
            self::initialize_for_admin();
        } else {
            self::initialize_for_frontend();
        }

        self::load_textdomain();
        self::initialize_kernel();
    }

    private static function initialize_event_dispatcher() {
        error_log('- Initializing Event Dispatcher and Registering Events...');
        $dispatcher     = new Dispatcher();
        $eventRegistrar = new EventRegistrar($dispatcher);
        $eventRegistrar->registerEventsAndListeners([
            HUBRIX_PLUGIN_DIR . 'app/Backend',
            HUBRIX_PLUGIN_DIR . 'app/Frontend',
        ]);
    }

    private static function initialize_for_admin() {
        self::initialize_menus();
        self::initialize_event_dispatcher();
    }

    private static function initialize_for_ajax() {
        // AJAX-specific initialization
    }

    private static function initialize_for_frontend() {
        // Frontend-specific initialization
    }

    /**
     * Check the compatibility of the plugin with the server environment.
     *
     * This method checks the compatibility of the plugin with the server environment
     * by verifying the PHP and WordPress versions.
     *
     * @return void
     */
    private static function check_dependencies() {
        /*if (!is_plugin_active('required-plugin/required-plugin.php')) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die('This plugin requires "Required Plugin" to be active.');
        }*/
    }

    /**
     * Load the required dependencies for the plugin.
     *
     * This method can be extended to include additional dependencies as needed.
     * This method loads the necessary dependencies for the plugin.
     *
     * @return void
     */
    private static function load_dependencies() {
        // Load additional custom dependencies here if necessary.
        // Example: require_once PLUGIN_DIR . 'includes/class-example.php';
        //error_log('Loading Dependencies...');
    }

    /**
     * Check the compatibility of the plugin with the server environment.
     *
     * This method checks the compatibility of the plugin with the server environment
     * by verifying the PHP and WordPress versions.
     *
     * @return void
     */
    private static function check_compatibility() {
        /*if (version_compare(PHP_VERSION, '7.4', '<')) {
            wp_die('This plugin requires PHP version 7.4 or higher.');
        }

        global $wp_version;
        if (version_compare($wp_version, '5.8', '<')) {
            wp_die('This plugin requires WordPress version 5.8 or higher.');
        }*/
    }

    /**
     * Set up error handling for the plugin.
     *
     * This method sets up error handling for the plugin by registering a custom
     * error handler. The custom error handler is only registered if the plugin
     * is in debug mode.
     *
     * @return void
     */
    private static function setup_error_handling(): void
    {
        if (Config::get('debug') || (defined('WP_DEBUG') && WP_DEBUG)) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            error_log('Debug mode is enabled');
        } else {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
    }

    /**
     * Define the plugin constants from the configuration file.
     *
     * This method uses the Config class to retrieve plugin settings and defines
     * them as constants. Constants are used throughout the plugin for consistency.
     *
     * @return void
     */
    private static function define_constants(): void
    {
        error_log('* Defining Plugin Constants...');

        // Use the Config class to retrieve and define plugin-related constants.
        // Define plugin framework constants
        define('HUBRIX_PLUGIN_VERSION', Config::get('constants.plugin_version'));
        define('HUBRIX_PLUGIN_NAME', Config::get('constants.plugin_name'));
        define('HUBRIX_PLUGIN_DESCRIPTION', sanitize_text_field(Config::get('constants.plugin_desc')));
        define('HUBRIX_PLUGIN_AUTHOR', sanitize_text_field(Config::get('constants.plugin_author')));
        define('HUBRIX_PLUGIN_MENU_NAME', Config::get('constants.plugin_menu_name'));
        define('HUBRIX_PLUGIN_URI', esc_url_raw(Config::get('constants.plugin_uri')));
        define('HUBRIX_PLUGIN_TEXT', Config::get('constants.plugin_text'));
        define('HUBRIX_PLUGIN_SLUG', Config::get('constants.plugin_slug'));
        define('HUBRIX_PLUGIN_NAMESPACE', Config::get('constants.plugin_namespace'));
        define('HUBRIX_PLUGIN_DOMAIN', Config::get('constants.plugin_domain'));
        define('HUBRIX_PLUGIN_FILE', Config::get('constants.plugin_file'));
        define('HUBRIX_BACKEND_DIR', Config::get('constants.plugin_app_backend_dir'));
        define('HUBRIX_BACKEND_URL', esc_url_raw(Config::get('constants.plugin_app_backend_url')));
        define('HUBRIX_FRONTEND_DIR', Config::get('constants.plugin_app_frontend_dir'));
        define('HUBRIX_FRONTEND_URL', esc_url_raw(Config::get('constants.plugin_app_frontend_url')));
        define('HUBRIX_PLUGIN_DIR', sanitize_text_field(Config::get('constants.plugin_dir')));
        define('HUBRIX_PLUGIN_URL', esc_url_raw(Config::get('constants.plugin_url')));
    }

    /**
     * Initialize the Kernel to set up core functionalities.
     *
     * The Kernel is responsible for initializing core functionalities such as
     * loading services, registering hooks, etc.
     *
     * @return void
     */
    private static function initialize_kernel(): void
    {
        error_log('* Initializing Kernel...');
        Kernel::instance();
    }

    /**
     * Initialize the menus for the plugin.
     *
     * This method initializes the menu structure for the plugin's admin pages
     * by invoking the Menu class's instance method.
     *
     * @return void
     */
    private static function initialize_menus(): void
    {
        error_log('* Initializing Menus...');
        Menu::init();
    }

    /**
     * Load the plugin text domain for localization.
     *
     * This method ensures that the plugin is ready for translation.
     *
     * @return void
     */
    private static function load_textdomain(): void
    {
        error_log('* Loading Plugin Text Domain...');

        load_plugin_textdomain(HUBRIX_PLUGIN_DOMAIN, false, HUBRIX_PLUGIN_DIR . '/languages');
    }

}
