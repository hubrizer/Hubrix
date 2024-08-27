<?php

namespace Hubrix\Core\Plugin;

use Hubrix\Core\Exception;
use Hubrix\Core\Exceptions\ControllerNotFoundException;
use Hubrix\Core\Exceptions\MethodNotFoundException;

/**
 * Class Menu
 * Description: This class is used to handle the plugin's menu.
 * It registers the plugin's menu and submenus, and routes the request to the appropriate controller method.
 * */

class Menu {
    /**
     * Initialize the plugin's menu.
     * Description: This method is used to initialize the plugin's menu.
     * It registers the plugin's menu and submenus.
     *
     * @return void
     */
    public static function init() {
        add_action('admin_menu', [self::class, 'registerMenu'], 4);
    }

    /**
     * Register the plugin's menu.
     * Description: This method is used to register the plugin's menu and submenus.
     *
     * @return void
     */
    public static function registerMenu() {
        $admin_menu = Config::get('admin_menu', 'menus');

        if ($admin_menu) {
            add_menu_page(
                esc_html__($admin_menu['plugin_menu_name'], $admin_menu['plugin_domain']),
                esc_html__($admin_menu['plugin_menu_name'], $admin_menu['plugin_domain']),
                $admin_menu['capability'],
                $admin_menu['slug'],
                [self::class, 'handleRequest'],
                $admin_menu['icon'],
                $admin_menu['position']
            );

            self::addSubMenus($admin_menu['menu_items'], $admin_menu['slug']);
            self::removeDuplicateSubmenuItem($admin_menu['slug']);
        }
    }

    /**
     * Add the plugin's submenus.
     * Description: This method is used to add the plugin's submenus.
     *
     * @param array $sub_menu_items
     * @param string $main_menu_slug
     * @return void
     */
    private static function addSubMenus(array $sub_menu_items, string $main_menu_slug) {
        foreach ($sub_menu_items as $sub_menu_item) {
            add_submenu_page(
                $main_menu_slug,
                esc_html__($sub_menu_item['title'], 'en_US'),
                esc_html__($sub_menu_item['title'], 'en_US'),
                $sub_menu_item['capability'],
                $sub_menu_item['slug'],
                [self::class, 'handleRequest']
            );
        }
    }

    /**
     * Remove the duplicate submenu item.
     * Description: This method is used to remove the duplicate submenu item.
     *
     * @param string $main_menu_slug
     * @return void
     */
    private static function removeDuplicateSubmenuItem(string $main_menu_slug) {
        global $submenu;

        if (isset($submenu[$main_menu_slug])) {
            if ($submenu[$main_menu_slug][0][2] === $main_menu_slug) {
                unset($submenu[$main_menu_slug][0]);
            }
            $submenu[$main_menu_slug] = array_values($submenu[$main_menu_slug]);
        }
    }

    /**
     * Handle the request.
     * Description: This method is used to handle the request and route it to the appropriate controller method.
     *
     * @return void
     */
    public static function handleRequest() {
        $admin_menu = Config::get('admin_menu', 'menus');
        $page_slug = $_GET['page'] ?? '';

        if ($admin_menu) {
            self::routeRequest($admin_menu, $page_slug);
        } else {
            display_error('Page not found.');
        }
    }

    /**
     * Route the request.
     * Description: This method is used to route the request to the appropriate controller method.
     *
     * @param array $admin_menu
     * @param string $page_slug
     * @return void
     */
    private static function routeRequest(array $admin_menu, string $page_slug) {
        $main_menu_slug = $admin_menu['slug'];
        $sub_menu_items = $admin_menu['menu_items'];

        if ($page_slug === $main_menu_slug) {
            self::callControllerMethod($admin_menu['controller'], $admin_menu['callback'], 'admin_page');
            return;
        }

        foreach ($sub_menu_items as $sub_menu_item) {
            if ($page_slug === $sub_menu_item['slug']) {
                self::callControllerMethod($sub_menu_item['controller'], $sub_menu_item['callback'], $sub_menu_item['slug']);
                return;
            }
        }

        display_error('Page not found.');
    }

    /**
     * Call the controller method.
     * Description: This method is used to call the controller method.
     *
     * @param string $controller
     * @param string $method
     * @return void
     */
    private static function callControllerMethod(string $controller, string $method): void {
        try {
            if (!class_exists($controller)) {
                throw new ControllerNotFoundException($controller);
            }

            $instance = new $controller;

            if (!method_exists($instance, $method)) {
                throw new MethodNotFoundException($method);
            }

            $instance->$method();
        } catch (ControllerNotFoundException $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "No Controller Found", $e->getMessage(), $stackTrace);
        } catch (MethodNotFoundException $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "No Method Found", $e->getMessage(), $stackTrace);
        } catch (Exception $e) {
            $stackTrace = explode("\n", $e->getTraceAsString());
            display_error("500", "An Unexpected Error Occurred", $e->getMessage(), $stackTrace);
        }
    }
}