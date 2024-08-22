<?php

namespace Hubrix\Providers;

use Illuminate\Container\Container;
use Illuminate\Mail\MailServiceProvider as IlluminateMailServiceProvider;

class MailServiceProvider
{
    /**
     * Register the mail service provider.
     *
     * @return void
     */
    public function register()
    {
        $container = new Container();

        // Set up configuration for the mail service
        $container['config'] = [
            'mail.driver' => 'smtp',
            'mail.host' => 'smtp.example.com',
            'mail.port' => 587,
            'mail.username' => 'your-username',
            'mail.password' => 'your-password',
            'mail.encryption' => 'tls',
            'mail.from.address' => 'no-reply@example.com',
            'mail.from.name' => 'Your Plugin Name',
        ];

        // Register the mail service provider from Illuminate
        $mailServiceProvider = new IlluminateMailServiceProvider($container);
        $mailServiceProvider->register();

        // Now $container['mailer'] can be used to send emails
    }
}
