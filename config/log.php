<?php
/*
 * Log configuration
 * This file contains the configuration for the plugin's log.
 * Configure the log settings here.
 */

return [
    'log_is_enabled' => true,
    'log_file' => 'plugin.log', // Only the base filename
    'log_level' => 'DEBUG',
    'log_format' => '%datetime% [%level_name%] %message%',
    'log_rotate' => true, // Enable or disable log rotation
];