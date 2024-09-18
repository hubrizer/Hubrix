<?php

namespace App\Backend\Providers;

use Exception;
use ReflectionClass;

class EnqueueServiceProvider
{
    public function register(): void
    {
        /// Load assets only for backend pages
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'enqueueAssets'], 10);
        }

        // Load assets specifically for backend AJAX requests
        if (wp_doing_ajax()) {
            add_action('admin_init', [$this, 'enqueueAjaxAssets'], 10);
        }
    }

    public function enqueueAssets(): void
    {
        if ($this->isPluginPage()) {
            error_log('Enqueuing Backend Global scripts and styles...');

            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-backend-plugins-js', HUBRIX_PLUGIN_URL . 'public/backend/js/plugins.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-backend-main-js', HUBRIX_PLUGIN_URL . 'public/backend/js/main.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);

            wp_enqueue_style(HUBRIX_PLUGIN_SLUG.'-backend-main-css', HUBRIX_PLUGIN_URL . 'public/backend/css/style.bundle.css', [], HUBRIX_PLUGIN_VERSION, 'all');

            wp_localize_script(HUBRIX_PLUGIN_SLUG.'-backend-main-js', 'js_backend_obj', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax_backend_nonce'),
            ]);

            $this->autoloadEnqueues();
        }
    }

    public function enqueueAjaxAssets(): void
    {
        // Enqueue assets needed for backend AJAX requests
    }

    protected function autoloadEnqueues(): void
    {
        $enqueuePath = __DIR__ . '/../Enqueue';

        foreach (glob($enqueuePath . '/*.php') as $file) {
            $className = 'App\\Backend\\Enqueue\\' . basename($file, '.php');

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                try {
                    $className::init();
                } catch (Exception $e) {
                    error_log('Failed to initialize ' . $className . ': ' . $e->getMessage());
                }
            }
        }
    }

    private function isPluginPage(): bool
    {
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        return $screen && str_contains($screen->id, HUBRIX_PLUGIN_SLUG);
    }
}