<?php
namespace App\Backend\Handlers;

abstract class BaseAjaxHandler
{
    protected function verify_nonce($nonce_field = 'security', $nonce_action = 'default')
    {
        error_log('BaseAjaxHandler verify_nonce executed : Field '. $nonce_field .' Action '. $nonce_action);

        if (!isset($_POST[$nonce_field])) {
            error_log('Nonce field not found in request: ' . $nonce_field);
        } else {
            error_log('Nonce field value: ' . $_POST[$nonce_field]);
        }

        $verification_result = check_ajax_referer($nonce_action, $nonce_field, false);
        error_log('check_ajax_referer result: ' . print_r($verification_result, true));

        if (!$verification_result) {
            error_log('Nonce verification failed for action ' . $nonce_action . ' with field ' . $nonce_field);
            wp_send_json_error(['message' => __('Nonce verification failed', 'text-domain')], 403);
            wp_die(); // Optional: For additional safety
        } else {
            error_log('Nonce verification passed for action ' . $nonce_action);
        }
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