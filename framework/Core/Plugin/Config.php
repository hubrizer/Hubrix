<?php

namespace Hubrix\Core\Plugin;

/**
 * Config class to manage plugin constants and settings.
 */
class Config {
    /**
     * Get a configuration setting.
     *
     * @param string $key The configuration key to retrieve, supports dot notation for nested arrays.
     * @param string $filename The configuration filename without the .php extension.
     * @param mixed|null $default The default value to return if the key is not found.
     * @return mixed The configuration value or the default value.
     */
    public static function get(string $key, string $filename = 'config', mixed $default = null) {
        // Sanitize filename to prevent directory traversal
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '', $filename);
        $file_path = HUBRIX_ROOT_DIR . 'config/' . $filename . '.php';

        if (!file_exists($file_path)) {
            // Log an error if the file is missing
            error_log("Configuration file not found: $file_path");
            return $default;
        }

        $config = include $file_path;

        // Handle dot notation to retrieve nested values
        $keys = explode('.', $key);
        foreach ($keys as $key) {
            if (is_array($config) && isset($config[$key])) {
                $config = $config[$key];
            } else {
                return $default;
            }
        }

        return $config;
    }
}
