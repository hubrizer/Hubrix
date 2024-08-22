<?php

namespace App\Backend\Providers;


class ShortcodeServiceProvider {
    /**
     * Register the shortcode
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Registering backend shortcodes ...');
        add_shortcode('my_backend_shortcode', [$this, 'myShortcode']);
    }

    /**
     * Handle the shortcode
     *
     * @return string
     */
    public function myShortcode(): string
    {
        // Handle the shortcode
        return 'Hello, World!';
    }
}