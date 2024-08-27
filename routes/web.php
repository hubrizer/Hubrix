<?php
/*
 * web routes file
 * This file contains the routes for the plugin.
 * Define the routes here.  All routes are loaded in the RouteServiceProvider and dispatched in the Kernel.
 * routes are defined using the Route class. The Route class is a facade for the RouteRegistrar class.
 * Routes are also always prefixed with the plugin_slug defined in the config.php config file.
 *
 * @package Hubrix
 * @subpackage Routes
 * @version 1.0.0
 * @since 1.0.0
 *
 */

use Hubrix\Core\Http\Route;

// Define routes
Route::group(['prefix' => ''], function() {
    Route::get('test', function() {
        print_r('Hello World');
        exit;
    });

    Route::get('test/{id}', function($id) {
        print_r('returning test with ID ' . $id);
        exit;
    });
});