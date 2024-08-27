<?php

use Hubrix\Core\Helpers\CoreHelpers;
use Hubrix\Core\Helpers\RequestHelpers;

if (!function_exists('view')) {
    /**
     * @throws Exception
     */
    function view($view, $data = []): string
    {
        return CoreHelpers::view($view, $data);
    }
}

if (!function_exists('is_ajax')) {
    function is_ajax(): bool
    {
        return CoreHelpers::is_ajax();
    }
}

if (!function_exists('my_log')) {
    function my_log($level, $title, $description, $errorNumber = null)
    {
        return CoreHelpers::my_log($level, $title, $description, $errorNumber);
    }
}

if (!function_exists('create_nonce')) {
    function create_nonce($nonce_action)
    {
        return CoreHelpers::create_nonce($nonce_action);
    }
}

if (!function_exists('get_registered_shortcodes')) {
    function get_registered_shortcodes()
    {
        return CoreHelpers::get_registered_shortcodes();
    }
}

if (!function_exists('option')) {
    function option($option, $default = false)
    {
        return CoreHelpers::option($option, $default);
    }
}

if (!function_exists('config')) {
    function config($key, $section = null)
    {
        return CoreHelpers::config($key, $section);
    }
}

if (!function_exists('display_error')) {
    function display_error($code, $title, $message, $stackTrace = []): void
    {
        CoreHelpers::displayError($code, $title, $message, $stackTrace);
    }
}

if (!function_exists('request')) {
    /**
     * Get the request instance.
     *
     * @return requestHelpers
     */
    function request(): requestHelpers
    {
        return new requestHelpers();
    }
}