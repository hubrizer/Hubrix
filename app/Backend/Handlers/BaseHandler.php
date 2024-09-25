<?php
namespace App\Backend\Handlers;

use Hubrix\Core\NonceManager;

abstract class BaseHandler
{
    protected function verify_nonce($nonce_field = 'security', $nonce_action = 'default')
    {
        NonceManager::verify_nonce_from_request($nonce_field, $nonce_action);
    }

    protected function check_capabilities($capabilities = 'manage_options')
    {
        // Check if capabilities are provided as an array
        if (is_array($capabilities)) {
            foreach ($capabilities as $capability) {
                // If the user has any of the capabilities, allow access
                if (current_user_can($capability)) {
                    return true;
                }
            }
            // Log an error if the user doesn't have any of the required capabilities
            error_log('User does not have any of the required capabilities: ' . implode(', ', $capabilities));
        } else {
            // Check a single capability
            if (current_user_can($capabilities)) {
                return true;
            }
            // Log an error if the user doesn't have the required capability
            error_log('User does not have the required capability: ' . $capabilities);
        }

        // Deny access if no capabilities matched
        wp_die(__('You do not have permission to perform this action', 'text-domain'), __('Error'), 403);
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