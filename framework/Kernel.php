<?php

namespace Hubrix;

use App\Backend\Providers\AjaxServiceProvider as BackendAjaxProvider;
use App\Backend\Providers\EnqueueServiceProvider as BackendEnqueueProvider;
use App\Backend\Providers\HookServiceProvider as BackendHookProvider;
use Hubrix\Core\Helpers\WordPressHelpers;
use Hubrix\Core\Http\Route;
use Hubrix\Core\Plugin\Helpers;
use App\Frontend\Providers\AjaxServiceProvider as FrontendAjaxProvider;
use App\Frontend\Providers\EnqueueServiceProvider as FrontendEnqueueProvider;
use App\Frontend\Providers\HookServiceProvider as FrontendHookProvider;
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
        // Initialize Eloquent provider
        EloquentServiceProvider::boot();

        // Register Backend Providers
        if (WordPressHelpers::is_admin()) {
            $this->register_providers([
                BackendEnqueueProvider::class,
                BackendHookProvider::class,
                BackendAjaxProvider::class,
            ]);
        }

        // Register Frontend Providers
        $this->register_providers([
            FrontendEnqueueProvider::class,
            FrontendHookProvider::class,
            FrontendAjaxProvider::class,
        ]);
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
                $providerInstance->register();
            } else {
                error_log("Provider class {$provider} not found.");
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
        RouteServiceProvider::boot(); // Ensure routes are registered first
        Route::dispatch(); // Dispatch routes after WordPress is initialized
    }
}