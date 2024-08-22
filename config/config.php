<?php
/*
 * app config file
 * This file contains the configuration for the plugin.
 * Define the plugin's constants here.
 *
 */

return [
    'constants' => [
        'plugin_version'   => 'v1.0.0',
        'plugin_name'      => 'Hubrix Plugin',
        'plugin_menu_name' => 'Hubrix',
        'plugin_uri'       => 'https://wordpress.org/plugins/my-plugin/',
        'plugin_desc'      => 'A plugin built with the Hubrix Framework.',
        'plugin_author'    => 'Your Name',
        'plugin_text'      => 'my-plugin',
        'plugin_slug'      => 'my_plugin',
        'plugin_namespace' => 'Hubrix',
        'plugin_domain'    => 'en_US',
        'plugin_file'      => 'my-plugin.php',
        'plugin_dir'       => plugin_dir_path(__FILE__),
        'plugin_url'       => plugin_dir_url(__DIR__),
        'plugin_app_backend_dir' => dirname(plugin_dir_path(__FILE__)) . '/app/Backend/',
        'plugin_app_backend_url' => plugin_dir_url(__FILE__) . 'app/Backend/',
        'plugin_app_frontend_dir' => dirname(plugin_dir_path(__FILE__)) . '/app/Frontend/',
        'plugin_app_frontend_url' => plugin_dir_url(__DIR__) . 'app/Frontend/',
    ],
];
