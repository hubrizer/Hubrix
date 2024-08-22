<?php

if (!function_exists('str_contains')) {
    /**
     * Check if a string contains a given substring
     *
     * @param string $haystack The string to search in.
     * @param string $needle The substring to search for.
     * @return bool
     */
    function str_contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('str_limit')) {
    /**
     * Truncate a string to a specified length and append a suffix
     *
     * @param string $value The string to truncate.
     * @param int $limit The maximum length of the truncated string.
     * @param string $end The string to append to the truncated string.
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...') {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return mb_substr($value, 0, $limit) . $end;
    }
}

if (!function_exists('str_slug')) {
    /**
     * Generate a URL-friendly "slug" from a given string
     *
     * @param string $title The string to convert.
     * @param string $separator The separator to use (e.g., '-' or '_').
     * @return string
     */
    function str_slug($title, $separator = '-') {
        $title = strip_tags($title);
        $title = preg_replace('/[\s]+/u', $separator, trim($title));
        $title = strtolower($title);

        return preg_replace('/[^A-Za-z0-9'.$separator.']+/u', '', $title);
    }
}

if (!function_exists('str_random')) {
    /**
     * Generate a random string of the given length
     *
     * @param int $length The length of the random string.
     * @return string
     */
    function str_random($length = 16) {
        return bin2hex(random_bytes($length / 2));
    }
}

if (!function_exists('str_title')) {
    /**
     * Convert a string to title case
     *
     * @param string $value The string to convert.
     * @return string
     */
    function str_title($value) {
        return ucwords(strtolower($value));
    }
}

if (!function_exists('str_camel')) {
    /**
     * Convert a string to camel case
     *
     * @param string $value The string to convert.
     * @return string
     */
    function str_camel($value) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
    }
}

if (!function_exists('str_snake')) {
    /**
     * Convert a string to snake case
     *
     * @param string $value The string to convert.
     * @param string $delimiter The delimiter to use (default: '_').
     * @return string
     */
    function str_snake($value, $delimiter = '_') {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value);
            $value = mb_strtolower($value);
        }

        return $value;
    }
}
