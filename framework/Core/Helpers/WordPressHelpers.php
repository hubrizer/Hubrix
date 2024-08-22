<?php
namespace Hubrix\Core\Helpers;


class WordPressHelpers
{
    /**
     * Check if the current request is for an administrative interface page.
     *
     * @return bool
     */
    public static function is_admin(): bool
    {
        return \is_admin();
    }

    /**
     * Check if the current request is an AJAX request.
     *
     * @return bool
     */
    public static function is_ajax(): bool
    {
        return defined('DOING_AJAX') && DOING_AJAX;
    }

    /**
     * Get an option from the WordPress options table.
     *
     * @param string $option The name of the option to retrieve.
     * @param mixed $default The default value to return if the option does not exist.
     * @return mixed
     */
    public static function get_option(string $option, $default = false)
    {
        return \get_option($option, $default);
    }

    /**
     * Sanitize a string.
     *
     * @param string $str The string to sanitize.
     * @return string
     */
    public static function sanitize_text_field(string $str): string
    {
        return \sanitize_text_field($str);
    }

    // Add more WordPress wrapper methods as needed.
}

