<?php
/*
 * api routes file
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
use Hubrix\Middleware\FilterRequests;

// Define routes
Route::group(['prefix' => 'api'], function() {
    Route::get('test', function() {
        $response = [
            'message' => 'Hello world!',
            'status' => 'success',
            'data' => null,  // You can include additional data here if needed
        ];

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Output the JSON-encoded response
        echo json_encode($response);
        exit;
    }, [FilterRequests::class]);
    Route::get('test/{id}', function($id) {
        $response = [
            'message' => 'Hello world!',
            'status' => 'success',
            'data' => $id,  // You can include additional data here if needed
        ];

        // Set the content type to JSON
        header('Content-Type: application/json');

        // Output the JSON-encoded response
        echo json_encode($response);
        exit;
    }, [FilterRequests::class]);
});