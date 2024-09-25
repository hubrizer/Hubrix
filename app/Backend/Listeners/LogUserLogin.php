<?php
namespace App\Backend\Listeners;

class LogUserLogin
{
    /**
     * Handle the event.
     *
     * @param string $user_login
     * @param \WP_User $user
     * @return void
     */
    public static function handle(string $user_login, \WP_User $user): void
    {
        if ($user instanceof \WP_User) {
            $user_id = $user->ID;
            $username = $user->user_login;
            $user_ip  = $_SERVER['REMOTE_ADDR'];

            //error_log("User logged in: $username, User ID: $user_id"); //log to php error log
            my_log('INFO','LogUserLogin Listener: LogUserLogin Event',"User logged in: $username, User ID: $user_id, User IP: $user_ip");
        } else {
            //error_log('User login event triggered, but no user object was passed.'); //log to php error log
            my_log('INFO','LogUserLogin Listener: LogUserLogin Event','User login event triggered, but no user object was passed.');
        }
    }
}
