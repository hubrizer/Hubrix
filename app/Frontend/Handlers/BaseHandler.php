<?php
namespace App\Frontend\Handlers;

use Hubrix\Core\NonceManager;

abstract class BaseHandler
{
    protected function verify_nonce($nonce_field = 'security', $nonce_action = 'default')
    {
        error_log('Verifying nonce with field: ' . $nonce_field . ' and action: ' . $nonce_action);
        NonceManager::verify_nonce_from_request($nonce_field, $nonce_action);
    }

    protected function check_capabilities($capability = 'manage_options')
    {
        error_log('Checking capability: ' . $capability);

        // Skip capability check for non-logged-in users
        if (!is_user_logged_in()) {
            error_log('No capability check required for non-logged-in users.');
            return;
        }

        // Check capabilities for logged-in users
        if (!current_user_can($capability)) {
            error_log('Capability check failed for: ' . $capability);
            wp_send_json_error(['message' => __('You do not have permission to perform this action', 'text-domain')]);
            wp_die();
        }

        error_log('Capability check passed for: ' . $capability);
    }

    protected function send_success($data = [])
    {
        wp_send_json_success($data);
    }

    protected function send_error($data = [])
    {
        wp_send_json_error($data);
    }

}