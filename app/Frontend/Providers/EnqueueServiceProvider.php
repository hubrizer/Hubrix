<?php
namespace App\Frontend\Providers;

use Exception;
use ReflectionClass;

class EnqueueServiceProvider
{
    public function register(): void
    {
        // Ensure that this only runs in the frontend context
        if (!is_admin()) {
            add_action('wp_enqueue_scripts', [$this, 'conditionallyEnqueueAssets'], 10);
        }
    }

    public function conditionallyEnqueueAssets(): void
    {
        if ($this->isPluginPage() || $this->hasPluginShortcode()) {
            error_log('Enqueuing Frontend Global scripts and styles...');

            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-plugins-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/plugins.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-vendors-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/vendors.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-styles-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/styles.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);
            wp_enqueue_script(HUBRIX_PLUGIN_SLUG.'-frontend-main-js', HUBRIX_PLUGIN_URL . 'public/frontend/js/main.bundle.js', [], HUBRIX_PLUGIN_VERSION, true);

            wp_enqueue_style(HUBRIX_PLUGIN_SLUG.'-frontend-vendors-css', HUBRIX_PLUGIN_URL . 'public/frontend/css/vendors.bundle.css', [], HUBRIX_PLUGIN_VERSION, 'all');
            wp_enqueue_style(HUBRIX_PLUGIN_SLUG.'-frontend-main-css', HUBRIX_PLUGIN_URL . 'public/frontend/css/styles.bundle.css', [], HUBRIX_PLUGIN_VERSION, 'all');

            wp_localize_script(HUBRIX_PLUGIN_SLUG.'-frontend-main-js', 'js_frontend_obj', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax_frontend_nonce'),
            ]);

            $this->autoloadEnqueues();
        }
    }

    protected function autoloadEnqueues(): void
    {
        $enqueuePath = __DIR__ . '/../Enqueue';

        foreach (glob($enqueuePath . '/*.php') as $file) {
            $className = 'App\\Frontend\\Enqueue\\' . basename($file, '.php');

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

    private function hasPluginShortcode(): bool
    {
        global $post;

        if (isset($post) && has_shortcode($post->post_content, 'your_shortcode')) {
            return true;
        }

        return false;
    }

    private function isPluginPage(): bool
    {
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));
        return str_contains($current_url, HUBRIX_PLUGIN_SLUG);
    }
}