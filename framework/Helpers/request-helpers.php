<?php

use Hubrix\Core\Helpers\RequestHelpers;

if (!function_exists('get_user_ip_address')) {
    function get_user_ip_address()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check for shared internet IP
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check for proxy user IP
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get the remote IP address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return sanitize_text_field($ip);
    }
}