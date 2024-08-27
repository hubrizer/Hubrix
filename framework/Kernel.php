<?php

namespace Hubrix;

use App\Backend\Providers\HandlerServiceProvider as BackendHandlerServiceProvider;
use App\Frontend\Providers\HandlerServiceProvider as FrontendHandlerServiceProvider;

use Hubrix\Core\Helpers\WordPressHelpers;
use Hubrix\Core\Http\Route;
use Hubrix\Core\Plugin\Helpers;

use Hubrix\Providers\EloquentServiceProvider;
use Hubrix\Providers\RouteServiceProvider;

defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Kernel class to manage core plugin functionalities.
 *
 * This class is responsible for loading dependencies, setting up hooks, and initializing
 * services. It acts as the core of the plugin, handling both backend and frontend functionalities.
 *
 * @package Hubrix
 */
class Kernel
{
    /**
     * Instance of the plugin
     *
     * @var Kernel|null
     */
    protected static ?Kernel $instance = null;

    /**
     * Get the instance of the plugin
     *
     * @return Kernel|null
     */
    public static function instance(): ?Kernel
    {
        error_log("-- Initializing Core Kernel...");

        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }

        return self::$instance;
    }

    /**
     * Private constructor to enforce Singleton pattern.
     */
    private function __construct()
    {
        // Prevent direct instantiation
    }

    /**
     * Initialize the plugin
     *
     * This method sets up constants, includes necessary files, and initializes hooks
     * and providers.
     *
     * @return void
     */
    private function init(): void
    {
        // Setup plugin constants or other initial configurations
        $this->load_helpers();
        $this->init_providers();
        $this->dispatch_routes();
    }

    /**
     * Load helper files using the Helpers class
     *
     * @return void
     */
    private function load_helpers(): void
    {
        error_log("-- Loading Helpers...");
        Helpers::load_helpers();
    }

    /**
     * Initialize service providers
     *
     * This method initializes all service providers needed by the plugin.
     *
     * @return void
     */
    private function init_providers(): void
    {
        error_log('Initializing Service Providers...');
        $providers = config('providers','app') ?? [];

        // Initialize Eloquent provider
        EloquentServiceProvider::boot();

        // Register providers based on context (AJAX, backend, frontend)
        if (wp_doing_ajax()) {
            error_log("\033[36m Registering Backend and Frontend AJAX Providers... \033[0m");
            $this->register_providers([
                BackendHandlerServiceProvider::class,
                FrontendHandlerServiceProvider::class,
            ]);
        } elseif (WordPressHelpers::is_admin()) {
            error_log("\033[36m Registering Backend Providers...\033[0m");
            $this->register_providers($providers);
        } else {
            error_log("\033[31m Registering Frontend Providers...\033[0m");
            $this->register_providers($providers);
        }
    }

    /**
     * Helper method to register service providers
     *
     * @param array $providers
     * @return void
     */
    private function register_providers(array $providers): void
    {
        foreach ($providers as $provider) {
            if (class_exists($provider)) {
                $providerInstance = new $provider();
                try {
                    $providerInstance->register();
                } catch (\Exception $e) {
                    error_log("-- Failed to register provider: {$provider} with error: " . $e->getMessage());
                }
            } else {
                error_log("-- Provider class {$provider} not found.");
            }
        }
    }

    /**
     * Dispatch the routes
     *
     * This method ensures that routes are properly dispatched during the WordPress init phase.
     *
     * @return void
     */
    private function dispatch_routes(): void
    {
        if (!is_admin()) {
            error_log('-- Dispatching Routes...');
            RouteServiceProvider::boot();
            Route::dispatch();
        }
    }

}