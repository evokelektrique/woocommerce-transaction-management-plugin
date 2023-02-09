<?php

namespace wtm_plugin\Listeners;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Listens to order events
 */
class Order {

   public function __construct() {
      add_action('woocommerce_new_order', [$this, "listen_new_status"]);
      add_action('woocommerce_order_status_changed', [$this, "listen_change_status"], 10, 3);
   }

   public function listen_new_status($order_id) {
      error_log(print_r(["CALLED woocommerce_new_order", "NEW ORDER", "ORDER_ID" => $order_id], true));
   }

   /**
    * Fires once when an order status has been changed
    *
    * @param int $order_id
    * @param string $old_status
    * @param string $new_status
    * @return void
    */
   public function listen_change_status($order_id, $old_status, $new_status) {
      error_log(print_r(["CALLED woocommerce_order_status_changed", "NEW ORDER - STATUS CHANGED FROM [$old_status] TO [$new_status]", "ORDER_ID" => $order_id], true));

      // $response = new \wtm_plugin\Publishers\Post(
      //    $parsed_post,
      //    $node,
      //    $is_update,
      //    $is_delete
      // );
   }
}
