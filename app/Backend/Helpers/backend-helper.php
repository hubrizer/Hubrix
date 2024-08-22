<?php

// Backend-specific helper functions

use Hubrix\Core\Plugin\Config;

if (!function_exists('backend_helper_function')) {
    /**
     * Example backend helper function
     *
     * @return string
     */
    function backend_helper_function(): string
    {
        return 'This is a backend helper function.';
    }

    /**
     * Retrieve any asset from the public folder
     */

    function get_public_asset($asset): string
    {
        return HUBRIX_PLUGIN_URL . 'public/' . $asset;
    }

}
