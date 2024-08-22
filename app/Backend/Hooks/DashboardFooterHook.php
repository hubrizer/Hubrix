<?php
namespace App\Backend\Hooks;

use Exception;
use Hubrix\Core\NonceManager;

class DashboardFooterHook
{
    /**
     * Initialize the hook.
     */
    public static function init()
    {
        // Register the admin_footer hook to handle the War Room page
        add_action('admin_footer', [self::class, 'handle']);
    }

    /**
     * Handle the admin footer hook for the War Room page.
     *
     * @return void
     * @throws Exception
     */
    public static function handle(): void
    {
        error_log('Dashboard footer hook triggered');
        if(isset($_GET['page'])) {
            self::renderModals();
        }
    }

    public static function renderModals(){
        if ($_GET['page'] === HUBRIX_PLUGIN_SLUG . '-dashboard') {
            echo view('pages.backend.dashboard.modals.add');
            echo view('pages.backend.dashboard.modals.edit');
        }
    }
}