<?php

namespace wtm_plugin\Listeners;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Listens to order events
 */
class Order {

   public function __construct() {
      add_action('woocommerce_order_status_changed', [$this, "listen_change_status"], 10, 3);
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
      $data = [
         "customer" => [
            "username" => null,
            "email" => null,
            "phone" => null,
            "first_name" => null,
            "last_name" => null,
         ],
         "order" => [
            "id" => null,
            "status" => null,
            "old_status" => null,
            "new_status" => null,
            "price" => null,
            "items" => [],
         ],
         "note" => [
            "type" => null,
            "content" => null,
         ],
      ];

      $order = wc_get_order($order_id);

      // Order and its items in general
      $data['order']['id'] = $order_id;
      $data['order']['status'] = $order->get_status();
      $data['order']['old_status'] = $old_status;
      $data['order']['new_status'] = $new_status;
      $data['order']['price'] = $order->get_total();
      $data['order']['items'] = $this->get_variations($order);

      // Notes
      $data['note']['content'] = $order->get_customer_note();
      $data['note']['type'] = "customer";

      // Customer
      $user = $order->get_user();
      $data['customer']['username'] = $user->user_login;
      $data['customer']['first_name'] = $order->get_billing_first_name();
      $data['customer']['last_name'] = $order->get_billing_last_name();
      $data['customer']['phone'] = $order->get_billing_phone();
      $data['customer']['email'] = $order->get_billing_email();

      $request = new \wtm_plugin\Publishers\Order($data);
      $response = json_decode($request->response->getBody(), true);

      error_log(print_r($response, true));
   }


   /**
    * Retrieve an array of order items varations.
    *
    * @param \WC_Order $order
    * @return array
    */
   private function get_variations(\WC_Order $order): array {
      $variation_names = [];

      foreach ($order->get_items() as $item_id => $item) {

         // Get the WC_Product Object
         $product = $item->get_product();
         $product_title = $product->get_title();
         $variation_names[$product_title] = [];
         $variation_names[$product_title]["quantity"] = $item->get_quantity();

         if ($product->is_type('variation')) {
            $variation_id = $item->get_variation_id();
            $variation = new \WC_Product_Variation($variation_id);
            $attributes = $variation->get_attributes();

            if ($attributes) {
               foreach ($attributes as $key => $value) {
                  $variation_key = str_replace('-', ' ', $key);

                  $variation_names[$product_title]["variations"][] = [
                     "key" => urldecode($variation_key),
                     "value" => urldecode($value)
                  ];
               }
            }
         }
      }

      return $variation_names;
   }
}
