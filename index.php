<?php
/* Index.php
 * The post-entry file for the plugin
 * defining the plugin's root directory and loading the environment variables
 * firing the bootstrap / kernel class to initialize the plugin
 */

// Exit if accessed directly
defined('ABSPATH') || exit; // Exit if accessed directly

// Prevent multiple inclusions of this file
if (defined('HUBRIX_PLUGIN_INITIALIZED')) {
    return;
}

define('HUBRIX_PLUGIN_INITIALIZED', true);

// Define the plugin's root directory
define('HUBRIX_ROOT_DIR', plugin_dir_path(__FILE__));

// Load the environment variables from the .env file if autoload exists
$autoload_path = HUBRIX_ROOT_DIR . 'vendor/autoload.php';

if (!file_exists($autoload_path)) {
    error_log('Autoload file missing. Please run `composer install`.');
    exit('Autoload file missing. Please run `composer install`.');
}else{
    require_once $autoload_path;
}

// Hook the initialization to plugins_loaded action
add_action('plugins_loaded', ['Hubrix\Bootstrap', 'init']);