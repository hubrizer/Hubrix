<?php
/*
 * Description: This file is used to autoload all the classes in the plugin.
 */

// Check if the autoload file exists
$autoload_path = __DIR__ . '/vendor/autoload.php';

// If the autoload file does not exist, display an error message
if (!file_exists($autoload_path)) {
    die("The autoload file does not exist. Please run 'composer dump-autoload' or 'composer install'.");
}

// Require the autoload file
require_once $autoload_path;