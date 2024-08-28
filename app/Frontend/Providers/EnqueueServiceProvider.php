<?php
namespace App\Frontend\Providers;

use Exception;
use ReflectionClass;

class EnqueueServiceProvider
{
    public function register(): void
    {
        // Ensure this only runs in the frontend context
        if (!is_admin()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueueAssets'], 10);
        }

        // Load assets specifically for frontend AJAX requests
        if (wp_doing_ajax()) {
            add_action('wp_init', [$this, 'enqueueAjaxAssets'], 10);
        }
    }

    public function enqueueAssets(): void
    {
        error_log('Enqueuing Frontend Global scripts and styles...');

        // Enqueue global frontend scripts and styles
        wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-plugins-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/plugins.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
        wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-vendors-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/vendors.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
        wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-main-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/main.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);

        wp_enqueue_style(HUBRIX_PLUGIN_SLUG.'-frontend-vendors-css', HUBRIX_PLUGIN_URL . 'public/frontend/css/vendors.bundle.css', [], HUBRIX_PLUGIN_VERSION, 'all');
        wp_enqueue_style(HUBRIX_PLUGIN_SLUG.'-frontend-main-css', HUBRIX_PLUGIN_URL . 'public/frontend/css/style.bundle.css', [], HUBRIX_PLUGIN_VERSION, 'all');

        // Localize the main global script
        wp_localize_script(HUBRIX_PLUGIN_SLUG.'-frontend-main-js', 'js_frontend_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ajax_frontend_nonce'),
        ]);

        $this->autoloadEnqueues();
    }

    public function enqueueAjaxAssets(): void
    {
        // Enqueue assets needed for frontend AJAX requests
    }

    protected function autoloadEnqueues(): void
    {
        error_log('Autoloading Frontend Enqueues...');

        $enqueuePath = __DIR__ . '/../Enqueue';

        foreach (glob($enqueuePath . '/*.php') as $file) {
            $className = 'App\\Frontend\\Enqueue\\' . basename($file, '.php');

            error_log('Autoloading ' . $className);

            if (class_exists($className)) {
                try {
                    $className::init();
                } catch (Exception $e) {
                    error_log('Failed to initialize ' . $className . ': ' . $e->getMessage());
                }
            }
        }
    }
}