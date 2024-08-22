<?php
return [
    /**
     * --------------------------------------------------------------------------
     *  Mail Driver
     * --------------------------------------------------------------------------
     *
     * Hubrix supports both SMTP and PHP's "mail" function as drivers for the
     * sending of e-mail. You may specify which one you're using throughout
     *
     *
     */

    'driver' => 'smtp',
    'host' => 'smtp.mailtrap.io',
    'port' => 2525,
    'from' => ['address' => 'hello@example.com', 'name' => 'Example'],
    'encryption' => 'tls',
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];