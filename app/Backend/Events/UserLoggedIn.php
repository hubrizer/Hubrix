<?php
namespace App\Backend\Events;

class UserLoggedIn
{
    public $userLogin;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param string $userLogin
     * @param \WP_User $user
     */
    public function __construct(string $userLogin, \WP_User $user)
    {
        $this->userLogin = $userLogin;
        $this->user = $user;
    }
}
