<?php

namespace App\Plugin\Hooks;

use App\Models\ProductBattle;
use App\Models\ProductBattleContact;
use App\Models\ProductBattleShare;
use App\Models\ProductBattleVote;
use App\Plugin\Capsule;
use function App\Plugin\delete_option;

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
        ProductBattle::truncate();
        ProductBattleVote::truncate();
        ProductBattleContact::truncate();
        ProductBattleShare::truncate();

        // Optionally, delete the tables themselves if required
        Capsule::schema()->dropIfExists('pb_product_battles');
        Capsule::schema()->dropIfExists('pb_product_battle_votes');
        Capsule::schema()->dropIfExists('pb_product_battle_leads');
        Capsule::schema()->dropIfExists('pb_product_battle_shares');

        // Delete options
        delete_option('product_battle_plugin_version');
        delete_option('product_battle_plugin_name');
        delete_option('product_battle_plugin_domain');
    }
}

