<?php

namespace App\Frontend\Providers;

use App\Frontend\Controllers\ShortcodeController;

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
        add_shortcode('product_battle', [ShortcodeController::class, 'renderProductBattleShortcode']);
    }

    /**
     * Render the modal in the footer.
     *
     * @return void
     */
    public function renderModalInFooter(): void
    {
        ShortcodeController::renderModals();
    }
}