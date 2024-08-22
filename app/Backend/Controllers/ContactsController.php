<?php

namespace App\Backend\Controllers;

use App\Models\Contact;

class ContactsController extends BaseController {

    public function handle() {
        $title = __('Contacts', 'contacts');
        $dataset = $this->getDataset();

        // Use the render method from BaseController to output the view
        $this->render('pages.backend.contacts.view', compact('title', 'dataset'));
    }

    private function getDataset() {
        $page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
        $items_per_page = 10;

        // Fetch contacts with pagination
        $contacts = Contact::whereNull('deleted_at')
            ->skip(($page - 1) * $items_per_page)
            ->take($items_per_page)
            ->get();

        // Get total count for pagination
        $total_items = Contact::whereNull('deleted_at')->count();
        $total_pages = ceil($total_items / $items_per_page);

        // Format dataset for view
        return $contacts->map(function ($contact) {
            return [
                'id' => $contact->id,
                'email' => $contact->email,
                'created_at' => $contact->created_at, // Assuming you have this field in your database
                // Add other necessary fields
            ];
        })->toArray();
    }
}
