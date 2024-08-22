<?php

if (!function_exists('url_build_query')) {
    /**
     * Build a URL-encoded query string
     *
     * @param array $params The array of query parameters.
     * @return string The URL-encoded query string.
     */
    function url_build_query($params) {
        return http_build_query($params, '', '&', PHP_QUERY_RFC3986);
    }
}

if (!function_exists('url_add_query_params')) {
    /**
     * Add query parameters to a URL
     *
     * @param string $url The original URL.
     * @param array $params The query parameters to add.
     * @return string The modified URL with the new query parameters.
     */
    function url_add_query_params($url, array $params) {
        $url_parts = parse_url($url);
        $query = [];

        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $query);
        }

        $query = array_merge($query, $params);
        $url_parts['query'] = url_build_query($query);

        return url_unparse($url_parts);
    }
}

if (!function_exists('url_unparse')) {
    /**
     * Construct a URL from an array of components
     *
     * @param array $parsed_url The array of URL components.
     * @return string The constructed URL.
     */
    function url_unparse($parsed_url) {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}

if (!function_exists('url_current')) {
    /**
     * Get the current URL
     *
     * @return string The current URL.
     */
    function url_current() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }
}

if (!function_exists('url_is_secure')) {
    /**
     * Check if the current URL is HTTPS
     *
     * @return bool True if HTTPS, false otherwise.
     */
    function url_is_secure() {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
}

if (!function_exists('url_path')) {
    /**
     * Get the path of a URL
     *
     * @param string $url The URL to extract the path from.
     * @return string The path of the URL.
     */
    function url_path($url) {
        return parse_url($url, PHP_URL_PATH);
    }
}

if (!function_exists('url_query')) {
    /**
     * Get the query string of a URL as an associative array
     *
     * @param string $url The URL to extract the query string from.
     * @return array The query string as an associative array.
     */
    function url_query($url) {
        $query_string = parse_url($url, PHP_URL_QUERY);
        parse_str($query_string, $query_params);
        return $query_params;
    }
}
