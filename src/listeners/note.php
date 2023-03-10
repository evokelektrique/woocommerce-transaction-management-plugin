<?php

namespace wtm_plugin\Listeners;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Listens to order events
 */
class Note {

  public function __construct() {
    add_action('woocommerce_order_note_added', [$this, "listen_add_notes"], 10, 2);
  }

  public static function listen_add_notes($order_note_id, $order) {
    $data = [
      "order" => [
        "id" => null,
      ],
      "notes" => [],
    ];
    $order_id = $order->get_id();
    $all_order_notes = self::retrieve_order_notes($order_id);
    $data['order']['id'] = $order_id;

    foreach($all_order_notes as $note_content) {
      $data['notes'][] = [
        "content" => $note_content,
        "type" => "order",
      ];
    }

    $request = new \wtm_plugin\Publishers\Note($data);
    $status = $request->response->getStatusCode();

    if($status == 404) {
      $new_order_data = \wtm_plugin\Listeners\Order::generate_order_data($order_id);
      $new_order_request = new \wtm_plugin\Publishers\Order($new_order_data);
    }
  }

  private static function retrieve_order_notes($order_id, $key = "content") {
    $notes = wc_get_order_notes([
      'order_id' => $order_id,
    ]);
    $order_notes = array_reverse(wp_list_pluck($notes, $key));

    return $order_notes;
  }
}
