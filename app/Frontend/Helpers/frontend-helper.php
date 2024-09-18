<?php

// Frontend-specific helper functions

use Carbon\Carbon;

if (!function_exists('frontend_helper_function')) {
    /**
     * Example frontend helper function
     *
     * @return string
     */
    function frontend_helper_function() {
        return 'This is a frontend helper function.';
    }
}



if (!function_exists('wc_get_order_count_by_product_id')) {
    function wc_get_order_count_by_product_id($productId)
    {
        global $wpdb;

        $purchases = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}woocommerce_order_items oi
             JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id
             WHERE oi.order_item_type = 'line_item'
             AND oim.meta_key = '_product_id'
             AND oim.meta_value = %d",
            $productId
        ));

        return $purchases ?: 0;  // Return 0 if no purchases are found
    }
}