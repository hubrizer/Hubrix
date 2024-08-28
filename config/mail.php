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
    'host' => 'sandbox.smtp.mailtrap.io',
    'smtp_auth' => true,
    'port' => 2525,
    'from' => ['address' => 'xxxx+1@inbox.mailtrap.io', 'name' => 'Product Battle v2.0'],
    'encryption' => 'tls',
    'username' => 'xxx',
    'password' => 'xxx',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];