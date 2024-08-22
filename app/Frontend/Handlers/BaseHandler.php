<?php
namespace App\Frontend\Handlers;

use Hubrix\Core\NonceManager;

abstract class BaseHandler
{
    public function __construct()
    {

    }

    protected function verify_nonce($nonce_field = 'security', $nonce_action = 'default')
    {
        NonceManager::verify_nonce_from_request($nonce_field, $nonce_action);
    }

    protected function check_capabilities($capability = 'manage_options')
    {
        if (!current_user_can($capability)) {
            wp_send_json_error(['message' => __('You do not have permission to perform this action', 'text-domain')]);
            wp_die();
        }
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