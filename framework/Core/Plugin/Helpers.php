<?php

namespace Hubrix\Core\Plugin;

defined('ABSPATH') || exit; // Exit if accessed directly

/**
 * Helpers Class
 *
 * This class is responsible for loading and managing helper functions or classes
 * that are used throughout the plugin. It acts as a central point for including
 * various helper files.
 *
 * @package Hubrix\Helpers
 */
class Helpers {

    /**
     * Load all the helper files.
     *
     * This method loads all the necessary helper files. You can extend it to include
     * more files as needed.
     *
     * @return void
     */
    public static function load_helpers(): void
    {
        // Load core helper files
        self::include_core_helper_file('core-helpers.php');
        self::include_core_helper_file('array-helpers.php');
        self::include_core_helper_file('string-helpers.php');
        self::include_core_helper_file('url-helpers.php');
        self::include_core_helper_file('request-helpers.php');

        // Load external helper files
        self::include_external_helper_files(HUBRIX_PLUGIN_DIR . 'helpers/');
        self::include_external_helper_files(HUBRIX_BACKEND_DIR . 'Helpers/');
        self::include_external_helper_files(HUBRIX_FRONTEND_DIR . 'Helpers/');
    }

    /**
     * Include a specific helper file.
     *
     * This method includes a helper file located in the Helpers directory.
     *
     * @param string $filename The name of the helper file to include.
     * @return void
     */
    private static function include_core_helper_file(string $filename): void
    {
        $file = HUBRIX_ROOT_DIR . 'framework/Helpers/' . $filename;

        if (file_exists($file)) {
            require_once $file;
        } else {
            error_log('Helper file not found: ' . $file);
        }
    }

    /**
     * Include all helper files from a given directory.
     *
     * This method securely includes helper files from a specified directory.
     * It only includes files with a `.php` extension and performs a basic integrity
     * check to ensure the files are safe to include.
     *
     * @param string $directory The directory to include helper files from.
     * @return void
     */
    private static function include_external_helper_files(string $directory): void
    {
        // Ensure the directory exists
        if (!is_dir($directory)) {
            return;
        }

        // Iterate over all PHP files in the directory
        foreach (glob($directory . '*.php') as $file) {
            // Perform a basic integrity check on the file
            if (self::is_safe_helper_file($file)) {
                require_once $file;
            } else {
                error_log('Potentially unsafe helper file detected: ' . $file);
            }
        }
    }

    /**
     * Check if a helper file is safe to include.
     *
     * This method performs basic checks to determine if a helper file is safe
     * to include. It checks for a valid PHP opening tag and optionally verifies
     * the first few lines for a known safe comment.
     *
     * @param string $file The path to the helper file.
     * @return bool True if the file is safe, false otherwise.
     */
    private static function is_safe_helper_file(string $file): bool
    {
        // Open the file and read the first few lines
        $handle = fopen($file, 'r');
        if ($handle === false) {
            return false;
        }

        $first_line = fgets($handle);
        fclose($handle);

        // Check if the file starts with a valid PHP opening tag
        if (!str_starts_with(trim($first_line), '<?php')) {
            return false;
        }

        // Optionally, perform additional checks, such as verifying a known comment
        // $second_line = fgets($handle);
        // if (strpos(trim($second_line), '/* Safe Plugin Helper */') !== 0) {
        //     return false;
        // }

        return true;
    }

    /**
     * Initialize specific helper functions or classes.
     *
     * This method can be used to initialize or register any helper functions that
     * need to be globally available.
     *
     * @return void
     */
    public static function init() {
        // Initialize or register any global helper functions or classes here.
    }
}
