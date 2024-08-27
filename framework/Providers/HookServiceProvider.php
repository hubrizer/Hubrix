<?php

namespace Hubrix\Providers;

use App\Plugin\Hooks\Activate;
use App\Plugin\Hooks\AdminInitialize;
use App\Plugin\Hooks\Deactivate;
use App\Plugin\Hooks\EnqueueAdminScripts;
use App\Plugin\Hooks\EnqueueFrontendScripts;
use App\Plugin\Hooks\Initialize;
use App\Plugin\Hooks\OnPluginsLoaded;
use App\Plugin\Hooks\Shutdown;
use App\Plugin\Hooks\Uninstall;
use Exception;

/**
 * Hook Service Provider
 *
 * This class is responsible for registering the activation, deactivation, and uninstall hooks for the plugin.
 *
 */
class HookServiceProvider
{
    /**
     * Register the hooks
     *
     * @return void
     */
    public function register(): void
    {
        // Register activation, deactivation, and uninstall hooks
        register_activation_hook(HUBRIX_PLUGIN_FILE, [$this, 'activate']);
        register_deactivation_hook(HUBRIX_PLUGIN_FILE, [$this, 'deactivate']);
        register_uninstall_hook(HUBRIX_PLUGIN_FILE, [$this, 'uninstall']);

        // Add additional hooks
        add_action('init', [$this, 'initialize']);
        add_action('admin_init', [$this, 'adminInitialize']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
        register_shutdown_function([$this, 'shutdown']);
    }

    public static function activate(): void
    {
        try {
            Activate::start();
        } catch (Exception $e) {
            error_log('Error during plugin activation: ' . $e->getMessage());
        }
    }

    public static function deactivate(): void
    {
        try {
            Deactivate::start();
        } catch (Exception $e) {
            error_log('Error during plugin deactivation: ' . $e->getMessage());
        }
    }

    public static function uninstall(): void
    {
        try {
            Uninstall::start();
        } catch (Exception $e) {
            error_log('Error during plugin uninstallation: ' . $e->getMessage());
        }
    }

    public function initialize(): void
    {
        // Code to run on WordPress initialization
        try {
            Initialize::start();
        } catch (Exception $e) {
            error_log('Error during plugin initialization: ' . $e->getMessage());
        }
    }

    public function adminInitialize(): void
    {
        // Code to run during admin initialization
        try {
            AdminInitialize::start();
        } catch (Exception $e) {
            error_log('Error during plugin admin initialization: ' . $e->getMessage());
        }
    }

    public function enqueueFrontendScripts(): void
    {
        // Enqueue frontend styles and scripts
        try {
            EnqueueFrontendScripts::start();
        } catch (Exception $e) {
            error_log('Error during plugin frontend script initialization: ' . $e->getMessage());
        }
    }

    public function enqueueAdminScripts(): void
    {
        // Enqueue admin styles and scripts
        try {
            EnqueueAdminScripts::start();
        } catch (Exception $e) {
            error_log('Error during plugin admin script initialization: ' . $e->getMessage());
        }
    }

    public function onPluginsLoaded(): void
    {
        // Code to run after all plugins are loaded
        try {
            OnPluginsLoaded::start();
        } catch (Exception $e) {
            error_log('Error during plugin on load initialization: ' . $e->getMessage());
        }
    }

    public function shutdown(): void
    {
        // Handle final cleanup tasks or logging
        try {
            Shutdown::start();
        } catch (Exception $e) {
            error_log('Error during plugin on shutdown initialization: ' . $e->getMessage());
        }
    }
}
