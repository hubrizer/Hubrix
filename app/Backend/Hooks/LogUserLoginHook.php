<?php
namespace App\Backend\Hooks;

use App\Backend\Listeners\LogUserLogin;

class LogUserLoginHook
{
    /**
     * Initialize the hook.
     */
    public static function init(): void
    {
        // Register the wp_login hook to log user login events
        add_action('wp_login', [self::class, 'handle'], 10, 2);
    }

    /**
     * Handle the wp_login hook.
     *
     * @param string $user_login
     * @param \WP_User $user
     * @return void
     */
    public static function handle(string $user_login, \WP_User $user): void
    {
        // Handle the user login event
        LogUserLogin::handle($user_login, $user);
    }
}