<?php

namespace Hubrix\Core\Plugin;

use Exception;

/**
 * Menu Class
 *
 * @package Hubrix\Backend
 */
class Menu {

    /**
     * Instance of the Menu class
     *
     * @var Menu
     */
    private static $instance = null;

    /**
     * Get the instance of the Menu class
     *
     * @return Menu
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        add_action('admin_menu', [$this, 'registerMenu'], 4);
    }

    /**
     * Register the main menu and submenus
     */
    public function registerMenu() {
        $admin_menu = Config::get('admin_menu', 'menus');

        if ($admin_menu) {
            // Add the main menu item
            add_menu_page(
                esc_html__($admin_menu['plugin_menu_name'], $admin_menu['plugin_domain']),
                esc_html__($admin_menu['plugin_menu_name'], $admin_menu['plugin_domain']),
                $admin_menu['capability'],
                $admin_menu['slug'],
                [$this, 'handleRequest'],
                $admin_menu['icon'],
                $admin_menu['position']
            );

            // Dynamically add the submenu items
            $this->addSubMenus($admin_menu['menu_items'], $admin_menu['slug']);

            // Remove the duplicate first submenu item
            $this->removeDuplicateSubmenuItem($admin_menu['slug']);
        }
    }

    /**
     * Add submenu pages.
     *
     * @param array $sub_menu_items
     * @param string $main_menu_slug
     */
    private function addSubMenus(array $sub_menu_items, string $main_menu_slug) {
        foreach ($sub_menu_items as $sub_menu_item) {
            add_submenu_page(
                $main_menu_slug, // Parent slug
                esc_html__($sub_menu_item['title'], 'en_US'),
                esc_html__($sub_menu_item['title'], 'en_US'),
                $sub_menu_item['capability'],
                $sub_menu_item['slug'],
                [$this, 'handleRequest']
            );
        }
    }

    /**
     * Remove the first submenu item that duplicates the main menu.
     *
     * @param string $main_menu_slug
     */
    private function removeDuplicateSubmenuItem(string $main_menu_slug) {
        global $submenu;

        if (isset($submenu[$main_menu_slug])) {
            // Remove the first submenu item if it duplicates the main menu item
            if ($submenu[$main_menu_slug][0][2] === $main_menu_slug) {
                unset($submenu[$main_menu_slug][0]);
            }

            // Reindex the submenu array to ensure proper ordering
            $submenu[$main_menu_slug] = array_values($submenu[$main_menu_slug]);
        }
    }

    /**
     * Handle the request and call the appropriate controller method
     */
    public function handleRequest() {
        $admin_menu = Config::get('admin_menu', 'menus');
        $page_slug = $_GET['page'] ?? '';

        if ($admin_menu) {
            $this->routeRequest($admin_menu, $page_slug);
        } else {
            display_error('Page not found.');
        }
    }

    /**
     * Route the request to the appropriate controller method.
     *
     * @param array $admin_menu
     * @param string $page_slug
     */
    private function routeRequest(array $admin_menu, string $page_slug) {
        $main_menu_slug = $admin_menu['slug'];
        $sub_menu_items = $admin_menu['menu_items'];

        if ($page_slug === $main_menu_slug) {
            $this->callControllerMethod($admin_menu['controller'], $admin_menu['callback'], 'admin_page');
            return;
        }

        foreach ($sub_menu_items as $sub_menu_item) {
            if ($page_slug === $sub_menu_item['slug']) {
                $this->callControllerMethod($sub_menu_item['controller'], $sub_menu_item['callback'], $sub_menu_item['slug']);
                return;
            }
        }

        display_error('Page not found.');
    }

    /**
     * Call the controller method
     *
     * @param string $controller
     * @param string $method
     * @param string $view
     */
    private function callControllerMethod($controller, $method, $view) {
        try {
            if (!class_exists($controller)) {
                throw new \Hubrix\Core\Exceptions\ControllerNotFoundException($controller);
            }

            $instance = new $controller;

            if (!method_exists($instance, $method)) {
                throw new \Hubrix\Core\Exceptions\MethodNotFoundException($method);
            }

            $instance->$method();
        } catch (\Hubrix\Core\Exceptions\ControllerNotFoundException $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "No Controller Found", $e->getMessage(), $stackTrace);
        } catch (\Hubrix\Core\Exceptions\MethodNotFoundException $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "No Method Found", $e->getMessage(), $stackTrace);
        } catch (\Exception $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "An Unexpected Error Occurred", $e->getMessage(), $stackTrace);
        }
    }



}
