<?php

namespace App\Hooks;

use App\Models\ProductBattle;
use App\Models\ProductBattleVote;
use App\Models\Contact;
use App\Models\ProductBattleShare;

class Uninstall {

    public static function start(): void
    {
        // Security check
        if (!defined('WP_UNINSTALL_PLUGIN')) {
            exit;
        }

        // Handle the uninstall logic here
        self::uninstall();
    }

    private static function uninstall(): void
    {
        // Delete custom tables using Eloquent models
        Contact::truncate();

        // Delete options
        delete_option('my_plugin_version');
        delete_option('my_plugin_name');
        delete_option('my_plugin_domain');
    }
}

