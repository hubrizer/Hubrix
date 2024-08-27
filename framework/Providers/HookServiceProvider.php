<?php

namespace Hubrix\Providers;

use App\Plugin\Hooks\Activate;
use App\Plugin\Hooks\Deactivate;
use App\Plugin\Hooks\Uninstall;

class HookServiceProvider
{
    /**
     * Register the hooks
     *
     * @return void
     */
    public function register(): void
    {
        // Register the activation hook
        register_activation_hook(HUBRIX_PLUGIN_FILE, [$this, 'activate']);

        // Register the deactivation hook
        register_deactivation_hook(HUBRIX_PLUGIN_FILE, [$this, 'deactivate']);

        // Register the uninstall hook
        register_uninstall_hook(HUBRIX_PLUGIN_FILE, [$this, 'uninstall']);
    }

    /**
     * Handle the activation hook
     *
     * @return void
     */
    public function activate(): void
    {
        // Handle the activation logic here
        Activate::activate();
    }

    /**
     * Handle the deactivation hook
     *
     * @return void
     */
    public function deactivate(): void
    {
        // Handle the deactivation logic here
        Deactivate::deactivate();
    }

    /**
     * Handle the uninstall hook
     *
     * @return void
     */
    public function uninstall(): void
    {
        // Handle the uninstall logic here
        Uninstall::start();
    }
}
