<?php

namespace App\Backend\Controllers;

use Exception;

/**
 * Base Controller Class
 *
 * @package Hubrix\Backend\Controllers
 */
class BaseController {

    /**
     * Constructor
     *
     * Initializes the controller.
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Initialization method
     *
     * This method can be overridden in child classes to set up any necessary actions or filters.
     */
    protected function init() {
        // Initialize your base controller here, such as adding actions or filters
    }

    /**
     * Render a view file
     *
     * @param string $view The view file to render.
     * @param array $data Data to pass to the view.
     * @return void
     * @throws Exception
     */
    protected function render(string $view, array $data = []): void
    {
        echo view($view, $data);
    }

    /**
     * Enqueue a script or style
     *
     * @param string $handle The script or style handle.
     * @param string $src The source URL of the script or style.
     * @param array  $deps An array of dependencies.
     * @param string $ver The version number.
     * @param bool   $in_footer Whether to enqueue the script in the footer.
     * @return void
     */
    protected function enqueue($handle, $src, $deps = [], $ver = '1.0.0', $in_footer = false) {
        if (strpos($src, '.js') !== false) {
            wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
        } elseif (strpos($src, '.css') !== false) {
            wp_enqueue_style($handle, $src, $deps, $ver);
        }
    }

    /**
     * Handle a POST request
     *
     * @param array $callbacks An associative array of callbacks for different actions.
     * @return void
     */
    protected function handle_post_request($callbacks = []) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = isset($_POST['action']) ? sanitize_text_field($_POST['action']) : '';

            if (isset($callbacks[$action]) && is_callable($callbacks[$action])) {
                call_user_func($callbacks[$action], $_POST);
            }
        }
    }

    /**
     * Add an admin notice
     *
     * @param string $message The notice message.
     * @param string $type The type of notice (success, error, warning, info).
     * @return void
     */
    protected function add_admin_notice($message, $type = 'info') {
        add_action('admin_notices', function() use ($message, $type) {
            printf(
                '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
                esc_attr($type),
                esc_html($message)
            );
        });
    }
}
