<?php
/*
 * App configuration
 * This file contains the configuration for the plugin.
 * Define Provider, Locale, Debug and other configurations here.
 *
 */

return [
    'debug' => true,
    'locale' => 'en_US',
    'providers' => [
        /*
         * Hubrix Framework Specific Providers
         * Only disable or change if you are sure of what you are doing
         */

        // Core Providers
        Hubrix\Providers\BladeOneServiceProvider::class, //bladeOne provider - disabled will affect your views if using blade
        Hubrix\Providers\EloquentServiceProvider::class, //eloquent provider - disabled will affect your models if using eloquent
        Hubrix\Providers\MailServiceProvider::class, //mail service provider - disabled will affect your emails if using mail

        // Backend Providers
        App\Backend\Providers\HookServiceProvider::class, //hook service provider - disabled will affect your hooks if using hooks
        App\Backend\Providers\EnqueueServiceProvider::class, //enqueue service provider - disabled will affect your scripts if using enqueue
        App\Backend\Providers\ShortcodeServiceProvider::class, //shortcode service provider - disabled will affect your shortcodes if using shortcodes
        App\Backend\Providers\AjaxServiceProvider::class, //ajax service provider - disabled will affect your ajax if using ajax

        // Frontend Providers
        App\Frontend\Providers\HookServiceProvider::class, //hook service provider - disabled will affect your hooks if using hooks
        App\Frontend\Providers\EnqueueServiceProvider::class, //enqueue service provider - disabled will affect your scripts if using enqueue
        App\Frontend\Providers\ShortcodeServiceProvider::class, //shortcode service provider - disabled will affect your shortcodes if using shortcodes
        App\Frontend\Providers\AjaxServiceProvider::class, //ajax service provider - disabled will affect your ajax if using ajax

        /*
         * Add your custom providers here
         */
    ],
];