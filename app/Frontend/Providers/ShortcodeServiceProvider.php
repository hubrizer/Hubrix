<?php

namespace App\Frontend\Providers;


class ShortcodeServiceProvider {
    /**
     * Register the shortcode
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Registering frontend shortcodes ...');
        add_shortcode('my_frontend_shortcode', [$this, 'myShortcode']);
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