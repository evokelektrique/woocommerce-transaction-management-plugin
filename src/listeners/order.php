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
    $data = self::generate_order_data($order_id);
    $request = new \wtm_plugin\Publishers\Order($data);
    // $response = json_decode($request->response->getBody(), true);
    // $status = $request->response->getStatusCode();
  }

  public static function generate_order_data($order_id) {
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
        "price" => null,
        "items" => [],
      ],
      "notes" => [],
      "metadata" => null
    ];

    $order = wc_get_order($order_id);

    // Metadata
    $data["metadata"] = self::generate_metadata($order);

    // Order and its items in general
    $data['order']['id'] = $order_id;
    $data['order']['status'] = $order->get_status();
    $data['order']['price'] = $order->get_total();
    $data['order']['items'] = self::get_variations($order);

    // Notes
    $data['notes'][] = [
      'content' => $order->get_customer_note(),
      'type' => "customer",
    ];

    $all_order_notes = self::retrieve_order_notes($order->get_id());
    foreach ($all_order_notes as $note_content) {
      $data['notes'][] = [
        "content" => $note_content,
        "type" => "order",
      ];
    }

    // Customer
    $user = $order->get_user();
    $data['customer']['username'] = $user->user_login ?? "";
    $data['customer']['first_name'] = $order->get_billing_first_name();
    $data['customer']['last_name'] = $order->get_billing_last_name();
    $data['customer']['phone'] = $order->get_billing_phone();
    $data['customer']['email'] = $order->get_billing_email();

    return $data;
  }

  /**
   * Retrieve an array of order items varations.
   *
   * @param \WC_Order $order
   * @return array
   */
  private static function get_variations(\WC_Order $order): array {
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

            $variation_names[urldecode($product_title)]["variations"][] = [
              "key" => urldecode($variation_key),
              "value" => urldecode($value)
            ];
          }
        }
      }
    }

    return $variation_names;
  }

  private static function retrieve_order_notes($order_id, $key = "content") {
    $notes = wc_get_order_notes([
      'order_id' => $order_id,
    ]);
    $order_notes = array_reverse(wp_list_pluck($notes, $key));

    return $order_notes;
  }

  private static function generate_metadata(\WC_Order $order) {
    $whatsapp = get_post_meta($order->get_id(), '_billing_whatsapp', true);
    $telegram = get_post_meta($order->get_id(), '_billing_telegram', true);
    $order_dynamic_fields = [];
    $product_dynamic_fields = [];

    // Order dynamic fields
    $order_dynamic_fields_custom_field = carbon_get_post_meta($order->get_id(), 'order_dynamic_fields');

    if (!empty($order_dynamic_fields_custom_field)) {
      foreach ($order_dynamic_fields_custom_field as $field) {
        $order_dynamic_fields[] = [
          "field_title" => $field["field_title"],
          "field_email" => $field["field_email"],
          "field_username" => $field["field_username"],
          "field_password" => $field["field_password"],
          "field_code" => $field["field_code"],
          "field_date" => $field["field_date"],
          "field_expire_days" => $field["field_expire_days"],
        ];
      }
    }

    foreach ($order->get_items() as $item_key => $item) {
      $product_id = $item["product_id"];

      // Product dynamic fields
      $product_dynamic_fields_custom_field = carbon_get_post_meta($product_id, 'product_dynamic_fields');

      if (empty($product_dynamic_fields_custom_field)) {
        continue;
      } else { // No need for an else statement but yeah whatever
        foreach ($product_dynamic_fields_custom_field as $field) {
          $name = str_replace(" ", "_", $field["name_en"]);
          $product_dynamic_fields[] = [
            "type" => $field["type"],
            "name_fa" => $field["name_fa"],
            "name_en" => $field["name_en"],
            "data" => get_post_meta($order->get_id(), '_billing_' . $name, true)
          ];
        }
      }
    }

    $data = [
      "product_dynamic_fields" => $product_dynamic_fields,
      "order_dynamic_fields" => $order_dynamic_fields,
      "telegram" => $telegram,
      "whatsapp" => $whatsapp
    ];

    return $data;
  }
}
