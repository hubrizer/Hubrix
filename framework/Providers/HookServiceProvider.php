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
 */
class HookServiceProvider
{
    private static $hooksRegistered = false;
    /**
     * Register the hooks
     *
     * @return void
     */
    public function register(): void
    {
        if (self::$hooksRegistered) {
            return;
        }
        self::$hooksRegistered = true;

        error_log('****************************************Registering Plugin Hooks');
        error_log('Plugin File: ' . HUBRIX_PLUGIN_FILE);

        // Register activation, deactivation, and uninstall hooks
        register_activation_hook(HUBRIX_PLUGIN_FILE, [self::class, 'activate']);
        register_deactivation_hook(HUBRIX_PLUGIN_FILE, [self::class, 'deactivate']);
        register_uninstall_hook(HUBRIX_PLUGIN_FILE, [self::class, 'uninstall']);

        // Add additional hooks conditionally
        if (is_admin()) {
            add_action('admin_init', [$this, 'adminInitialize']);
            add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
        }

        // Only run on frontend pages
        if (!is_admin()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendScripts']);
        }

        add_action('init', [$this, 'initialize']);
        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
        register_shutdown_function([$this, 'shutdown']);
    }

    /**
     * Plugin activation hook
     */
    public static function activate(): void
    {
        try {
            error_log('** Plugin Activation Hook Triggered **');
            Activate::start();
        } catch (Exception $e) {
            error_log('Error during plugin activation: ' . $e->getMessage());
        }
    }

    /**
     * Plugin deactivation hook
     */
    public static function deactivate(): void
    {
        try {
            error_log('** Plugin Deactivation Hook Triggered **');
            Deactivate::start();
        } catch (Exception $e) {
            error_log('Error during plugin deactivation: ' . $e->getMessage());
        }
    }

    /**
     * Plugin uninstall hook
     */
    public static function uninstall(): void
    {
        try {
            error_log('** Plugin Uninstall Hook Triggered **');
            Uninstall::start();
        } catch (Exception $e) {
            error_log('Error during plugin uninstallation: ' . $e->getMessage());
        }
    }

    /**
     * Initialization code to run on every page load
     */
    public function initialize(): void
    {
        try {
            error_log('** Plugin Initialization Hook Triggered **');
            Initialize::start();
        } catch (Exception $e) {
            error_log('Error during plugin initialization: ' . $e->getMessage());
        }
    }

    /**
     * Code to run during admin initialization on every page load
     */
    public function adminInitialize(): void
    {
        try {
            error_log('** Plugin AdminInitialize Hook Triggered **');
            AdminInitialize::start();
        } catch (Exception $e) {
            error_log('Error during plugin admin initialization: ' . $e->getMessage());
        }
    }

    /**
     * Enqueue frontend styles and scripts on every page load
     */
    public function enqueueFrontendScripts(): void
    {
        try {
            error_log('** Plugin Enqueue Frontend Scripts Hook Triggered **');
            EnqueueFrontendScripts::start();
        } catch (Exception $e) {
            error_log('Error during plugin frontend script initialization: ' . $e->getMessage());
        }
    }

    /**
     * Enqueue admin styles and scripts on every page load
     */
    public function enqueueAdminScripts(): void
    {
        try {
            error_log('** Plugin Enqueue Admin Scripts Hook Triggered **');
            EnqueueAdminScripts::start();
        } catch (Exception $e) {
            error_log('Error during plugin admin script initialization: ' . $e->getMessage());
        }
    }

    /**
     * Code to run after all plugins are loaded on every page load
     */
    public function onPluginsLoaded(): void
    {
        try {
            error_log('** Plugin On Plugins Loaded Hook Triggered **');
            OnPluginsLoaded::start();
        } catch (Exception $e) {
            error_log('Error during plugin on load initialization: ' . $e->getMessage());
        }
    }

    /**
     * Handle final cleanup tasks or logging on every page load
     */
    public function shutdown(): void
    {
        try {
            error_log('** Plugin Shutdown Hook Triggered **');
            Shutdown::start();
        } catch (Exception $e) {
            error_log('Error during plugin on shutdown initialization: ' . $e->getMessage());
        }
    }
}

