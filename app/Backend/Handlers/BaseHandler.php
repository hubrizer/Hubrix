<?php
namespace App\Backend\Handlers;

use Hubrix\Core\NonceManager;

abstract class BaseHandler
{
    protected function verify_nonce($nonce_field = 'security', $nonce_action = 'default')
    {
        NonceManager::verify_nonce_from_request($nonce_field, $nonce_action);
    }

    protected function check_capabilities($capability = 'manage_options')
    {
        if (!current_user_can($capability)) {
            wp_send_json_error(['message' => __('You do not have permission to perform this action', 'text-domain')]);
            wp_die();
        }
    }

    protected function send_success($data = [])
    {
        wp_send_json_success($data);
    }

    protected function send_error($data = [])
    {
        wp_send_json_error($data);
    }

    /*
     * Determine a battle exists or not
     *
     * @param string $start_date
     * @param string $end_date
     * @param int $battle_id
     *
     */
    public static function battle_exists($start_date, $end_date, $battle_id = 0) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'pb_product_battles';
        $query = "
        SELECT COUNT(*)
        FROM $table_name
        WHERE (
            (start_date <= %s AND end_date >= %s)
            OR (start_date <= %s AND end_date >= %s)
            OR (start_date >= %s AND end_date <= %s)
        )
        AND id != %d
        AND status != 'Ended'
    ";
        $exists = $wpdb->get_var($wpdb->prepare(
            $query,
            $start_date, $start_date,
            $end_date, $end_date,
            $start_date, $end_date,
            $battle_id
        ));

        return $exists > 0;
    }

    /*
     * Apply discount to a product based on the discount percentage.
     *
     * @param int $product_id The ID of the product to apply the discount to.
     * @param int $discount_percentage The percentage of discount to apply.
     *
     */
    public static function apply_discount_to_product($product_id, $discount_percentage) {
        // Fetch the product object
        $product = wc_get_product($product_id);

        // Validate product and discount percentage
        if (!$product || $discount_percentage <= 0) {
            error_log("Invalid product or discount percentage. Product ID: $product_id, Discount: $discount_percentage%");
            return false;
        }

        // Calculate the discount factor
        $discount_factor = 1 - ($discount_percentage / 100);

        // Apply discount to simple product
        if ($product->is_type('simple')) {
            $regular_price = $product->get_regular_price();
            $discounted_price = $regular_price * $discount_factor;
            $product->set_sale_price($discounted_price);
            $product->save();
            error_log("Discount applied to simple product. Product ID: $product_id, Regular Price: $regular_price, Discounted Price: $discounted_price");
        }

        // Apply discount to product variations
        if ($product->is_type('variable')) {
            $variations = $product->get_children();
            foreach ($variations as $variation_id) {
                $variation = wc_get_product($variation_id);
                if ($variation) {
                    $regular_price = $variation->get_regular_price();
                    $discounted_price = $regular_price * $discount_factor;
                    $variation->set_sale_price($discounted_price);
                    $variation->save();
                    error_log("Discount applied to variation. Variation ID: $variation_id, Regular Price: $regular_price, Discounted Price: $discounted_price");
                } else {
                    error_log("Failed to fetch variation. Variation ID: $variation_id");
                }
            }
        }

        return true;
    }

    /**
     * Determine the status of a battle based on the start and end dates.
     *
     * @param string $start_date The start date of the battle.
     * @param string $end_date The end date of the battle.
     */
    public static function determine_battle_status(string $start_date, string $end_date) {
        $current_time = current_time('timestamp'); // Get current timestamp

        $start_timestamp = strtotime($start_date);
        $end_timestamp   = strtotime($end_date);

        // Log current time and battle times
        error_log("Current time: $current_time, Start time: $start_timestamp, End time: $end_timestamp");

        if ($current_time < $start_timestamp) {
            error_log("Status: Scheduled");
            return 'Scheduled';
        } elseif ($current_time >= $start_timestamp && $current_time <= $end_timestamp) {
            error_log("Status: Active");
            return 'Active';
        } elseif ($current_time > $end_timestamp) {
            error_log("Status: Ended");
            return 'Ended';
        }

        error_log("Status: Draft");
        return 'Draft'; // Default to draft if none of the above conditions are met
    }

    /*
     * Get the regular price of a product.
     * This method handles both simple and variable products.
     *
     * @param int $product_id The ID of the product to fetch the regular price for.
     * @return float The regular price of the product.
     *
     */
    public static function get_product_regular_price($product_id) {
        $product = wc_get_product($product_id);
        if (!$product) {
            error_log('Failed to fetch product with ID: ' . $product_id);
            return 0;
        }

        if ($product->is_type('simple')) {
            return $product->get_regular_price();
        }

        if ($product->is_type('variable')) {
            $variations = $product->get_children();
            $prices = array_map(function($variation_id) {
                $variation = wc_get_product($variation_id);
                return $variation ? $variation->get_regular_price() : 0;
            }, $variations);
            return min($prices);
        }

        return 0;
    }

    /*
     * Revert the price of a product to its original price
     *
     * @param int $product_id
     * @param string $original_price
     *
     */
    public static function revert_product_price($product_id, $original_price) {
        $product = wc_get_product($product_id);
        if (!$product) {
            return false;
        }

        // Revert price for simple product
        if ($product->is_type('simple')) {
            $product->set_sale_price('');
            $product->set_regular_price($original_price);
            $product->save();
        }

        // Revert price for product variations
        if ($product->is_type('variable')) {
            $variations = $product->get_children();
            foreach ($variations as $variation_id) {
                $variation = wc_get_product($variation_id);
                if ($variation) {
                    $variation->set_sale_price('');
                    $variation->set_regular_price($original_price);
                    $variation->save();
                }
            }
        }

        return true;
    }

    /*
     * Apply discount to a product based on the discount percentage.
     *
     * @param int $product_id The ID of the product to apply the discount to.
     * @param int $discount_percentage The percentage of discount to apply.
     *
     */
    public static function revert_discount($battle_id) {
        global $wpdb;
        $battle = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}pb_product_battles WHERE id = %d", $battle_id), ARRAY_A);

        if ($battle) {
            self::remove_discount_from_product($battle['product_1'], $battle['original_price_product_1']);
            self::remove_discount_from_product($battle['product_2'], $battle['original_price_product_2']);
        }
    }

    /*
     * Remove discount from a product
     * This method removes any applied discount from a product.
     *
     * @param int $product_id The ID of the product to remove the discount from.
     * @param float $original_price The original price of the product.
     */
    public static function remove_discount_from_product($product_id, $original_price) {
        $product = wc_get_product($product_id);
        if ($product) {
            if ($product->is_type('simple')) {
                $product->set_sale_price('');
                $product->set_regular_price($original_price);
                $product->save();
            }

            if ($product->is_type('variable')) {
                $variations = $product->get_children();
                foreach ($variations as $variation_id) {
                    $variation = wc_get_product($variation_id);
                    if ($variation) {
                        $variation->set_sale_price('');
                        $variation->set_regular_price($original_price);
                        $variation->save();
                    }
                }
            }
        }
    }
}