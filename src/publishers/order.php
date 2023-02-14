<?php

namespace wtm_plugin\Publishers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Handle publishing orders
 */
class Order {

   private $route;
   private $api_key;
   public $response;

   public function __construct(array $data) {
      $this->route = $this->get_route();
      $this->api_key = $this->get_api_key();

      $client = new Client();
      $response = $client->post($this->route, [
         'headers' => [
            'Authorization' => 'Bearer ' . $this->api_key
         ],
         RequestOptions::JSON => $data
      ]);

      $this->response = $response;
   }

   public function perform(array $data) {

   }

   private function get_route() {
      $value = "192.168.1.105:8000/api/order/create";

      return $value;
   }

   private function get_api_key() {
      $value = "1|8I75ZEWGtr73G7YWpVJLFlmFso39iKpR3TJNzLuI";

      return $value;
   }
}
