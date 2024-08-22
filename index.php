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

// Load the vendor autoload file if it exists
if (file_exists($autoload_path)) {
    require_once $autoload_path;
} else {
    // Log an error if the vendor autoload file is not found
    error_log('No vendor autoload file found');
    echo "No vendor autoload file found in " . HUBRIX_ROOT_DIR . 'vendor';
    exit;
}

// Hook the initialization to plugins_loaded action
add_action('plugins_loaded', ['Hubrix\Bootstrap', 'init']);