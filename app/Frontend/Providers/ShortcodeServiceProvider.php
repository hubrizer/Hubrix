<?php

namespace App\Frontend\Providers;

use App\Frontend\Controllers\ShortcodeController;
use Exception;

class ShortcodeServiceProvider
{
    /**
     * Register the shortcode and hooks.
     *
     * @return void
     */
    public function register(): void
    {
        error_log('Registering frontend shortcodes ...');

        // Register shortcodes during WordPress init
        add_action('init', [$this, 'registerShortcodes']);

        // Render the modal in the footer
        add_action('wp_footer', [$this, 'renderModalInFooter']);
    }

    /**
     * Register the shortcodes.
     *
     * @return void
     */
    public function registerShortcodes(): void
    {
        $this->add_shortcode('product_battle', [ShortcodeController::class, 'renderProductBattleShortcode']);
        // Register additional shortcodes here using $this->add_shortcode() method

    }

    /**
     * Register a shortcode and track it.
     *
     * @param string $tag
     * @param callable $callback
     */
    protected function add_shortcode(string $tag, callable $callback): void
    {
        add_shortcode($tag, $callback);



        // Store the shortcode in a global variable
        global $registered_shortcodes;

        if (!isset($registered_shortcodes)) {
            $registered_shortcodes = [];
        }

        $registered_shortcodes[] = $tag;

    }


    /**
     * Render the modal in the footer.
     *
     * @return void
     * @throws Exception
     */
    public function renderModalInFooter(): void
    {
        ShortcodeController::renderModals();
    }
}