<?php
namespace Hubrix\Core;

class NonceManager {
    protected static $nonces = [];

    /**
     * Generate and store a nonce for the given action.
     *
     * @param string $action The action name associated with the nonce.
     * @return string The generated nonce.
     */
    public static function create_nonce($action) {
        // Check if a nonce for this action already exists
        if (!isset(self::$nonces[$action])) {
            // Create and store the nonce
            self::$nonces[$action] = wp_create_nonce($action);
        }

        // Return the nonce
        return self::$nonces[$action];
    }

    /**
     * Verify a nonce for a given action.
     *
     * @param string $nonce The nonce to verify.
     * @param string $action The action name associated with the nonce.
     * @return bool True if the nonce is valid, false otherwise.
     */
    public static function verify_nonce($nonce, $action) {
        error_log('NonceManager::verify_nonce() started.');
        error_log('Nonce: ' . $nonce);
        error_log('Action: ' . $action);
        return wp_verify_nonce($nonce, $action);
    }

    /**
     * Verify a nonce from a request.
     *
     * @param string $nonce_field The name of the nonce field in the request (e.g., 'security').
     * @param string $action The action name associated with the nonce.
     * @return void Terminates execution if nonce verification fails.
     */
    public static function verify_nonce_from_request($nonce_field, $action) {
        error_log('NonceManager::verify_nonce_from_request() started.');
        error_log('Nonce field: ' . $nonce_field);
        error_log('Action: ' . $action);


        // Check if the nonce field is present in the request
        if (!isset($_POST[$nonce_field])) {
            $error_message = __('Nonce Manager: Nonce field not found in the request.', 'text-domain');

            if (wp_doing_ajax()) {
                wp_send_json_error(['message' => $error_message, 'error_code' => 'nonce_field_missing'], 403);
            } else {
                wp_die($error_message, __('Error'), 403);
            }
        }

        // Verify the nonce value
        if (!self::verify_nonce($_POST[$nonce_field], $action)) {
            $error_message = __('Nonce Manager: Nonce verification failed.', 'text-domain');

            if (wp_doing_ajax()) {
                wp_send_json_error([
                    'message' => $error_message,
                    'error_code' => 'nonce_verification_failed',
                    'nonce' => $_POST[$nonce_field],
                    'action' => $action
                ], 403);
            } else {
                wp_die($error_message, __('Error'), 403);
            }
        }
    }

    /**
     * Get the nonce for a given action, if it exists.
     *
     * @param string $action The action name.
     * @return string|null The nonce, or null if it doesn't exist.
     */
    public static function get_nonce($action) {
        return self::$nonces[$action] ?? null;
    }
}