<?php
/**
 * Plugin Name: My Hubrix Plugin v1.0.0
 * Description: A plugin built with the Hubrix framework.
 * Version: v1.0.0
 * Author: HUBRIZER. Team with the Hubrix Framework
 * Text Domain: my-plugin
 * Domain Path: /languages
 *
 * @package MyHubrixPlugin
 * @version 1.0.0
 * @since 1.0.0
 * @link https://my-domain.com
 * @license GPL-2.0+
 * @license URI https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
defined('ABSPATH') || exit; // Exit if accessed directly

// Load the actual plugin initializer
require_once plugin_dir_path(__FILE__) . 'index.php';