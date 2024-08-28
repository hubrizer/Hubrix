<?php

/*
 * menus configuration
 * This file contains the configuration for the plugin's admin menus.
 * The configuration is used to create the admin menus and submenus.
 */

use Hubrix\Core\Plugin\Config;

return [
    'admin_menu' => [
        'plugin_menu_name' => 'Hubrix Plugin',
        'plugin_domain'    => 'en_US',
        'capability'       => 'manage_options',
        'slug'             => HUBRIX_PLUGIN_SLUG,
        'callback'         => 'handle',
        'controller'       => 'App\Backend\Controllers\DashboardController',
        'icon'             => 'dashicons-admin-site',
        'position'         => 57,
        'menu_items'       => [
            'dashboard' => [
                'name'        => 'Dashboard',
                'title'       => 'Dashboard',
                'capability'  => 'manage_options',
                'parent_slug' => HUBRIX_PLUGIN_SLUG,
                'slug'       => HUBRIX_PLUGIN_SLUG.'-dashboard',
                'callback'   => 'handle',
                'controller' => 'App\Backend\Controllers\DashboardController',
                'position'   => 58
            ],
            'contacts' => [
                'name'       => 'Contacts',
                'title'      => 'Contacts',
                'capability' => 'manage_options',
                'parent_slug' => HUBRIX_PLUGIN_SLUG,
                'slug'       => HUBRIX_PLUGIN_SLUG.'-contacts',
                'callback'   => 'handle',
                'controller' => 'App\Backend\Controllers\ContactsController',
                'icon'       => 'dashicons-admin-users',
                'position'   => 60
            ],
            'settings' => [
                'name'       => 'Settings',
                'title'      => 'Settings',
                'capability' => 'manage_options',
                'parent_slug' => HUBRIX_PLUGIN_SLUG,
                'slug'       => HUBRIX_PLUGIN_SLUG.'-settings',
                'callback'   => 'handle',
                'controller' => 'App\Backend\Controllers\SettingsController',
                'icon'       => 'dashicons-admin-tools',
                'position'   => 61
            ],
            'tools' => [
                'name'       => 'Tools',
                'title'      => 'Tools',
                'capability' => 'manage_options',
                'parent_slug' => HUBRIX_PLUGIN_SLUG,
                'slug'       => HUBRIX_PLUGIN_SLUG.'-tools',
                'callback'   => 'handle',
                'controller' => 'App\Backend\Controllers\ToolsController',
                'icon'       => 'dashicons-admin-tools',
                'position'   => 62
            ]
        ],
    ],
    'admin_settings_menu' => [
        //to be defined
    ],
    'admin_navbar_menu' => [
        'logo_url' => HUBRIX_PLUGIN_URL . '/wp-admin/admin.php?page='.HUBRIX_PLUGIN_SLUG.'-dashboard',
        'menu_items' => [
            'dashboard' => [
                'name' => 'Dashboard',
                'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-dashboard',
                'icon' => 'dashicons-admin-site'
            ],
            'contacts' => [
                'name' => 'Contacts',
                'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-contacts',
                'icon' => 'dashicons-admin-users'
            ],
            'options' => [
                'name' => 'Settings',
                'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-settings',
                'icon' => 'dashicons-admin-tools',
                'sub_menu_items' => [
                    'settings' => [
                        'name' => 'Settings',
                        'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-settings',
                        'icon' => 'dashicons-admin-tools'
                    ],
                    'tools' => [
                        'name' => 'Tools',
                        'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-tools',
                        'icon' => 'dashicons-admin-tools'
                    ],
                    'help' => [
                        'name' => 'Need Help?',
                        'url'  => 'admin.php?page='.HUBRIX_PLUGIN_SLUG.'-help',
                        'icon' => 'dashicons-admin-tools'
                    ]
                ]
            ],
        ],

    ]
];