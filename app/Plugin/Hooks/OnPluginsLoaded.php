<?php
namespace App\Plugin\Hooks;


defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Activate Class
 *
 * @package Hubrix\Core
 */
class OnPluginsLoaded {

    /**
     * Run activation code
     */
    public static function start(): void {
        error_log('Initializing OnPluginsLoaded hook');

    }

}