<?php

// Hubrix/Admin/Controllers/AdminPageController.php
namespace App\Backend\Controllers;

class DashboardController extends BaseController {
    public function handle() {

        $title = __('Dashboard', HUBRIX_PLUGIN_SLUG.'-dashboard');
        $dataset = $this->getDataset();

        echo  view('pages.backend.dashboard.view', compact('title','dataset'));
    }

    private function getDataset() {
        return [
            ['ID' => 1, 'Name' => 'Product 1', 'Price' => '$10.00'],
            ['ID' => 2, 'Name' => 'Product 2', 'Price' => '$20.00'],
            ['ID' => 3, 'Name' => 'Product 3', 'Price' => '$30.00']
        ];
    }

    public function index() {
        $this->handle();
    }
}
