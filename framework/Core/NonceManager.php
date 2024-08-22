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
        if (!isset($_POST[$nonce_field]) || !self::verify_nonce($_POST[$nonce_field], $action)) {
            wp_die(__('Nonce Manager : Nonce verification failed.', 'text-domain'), 403);
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