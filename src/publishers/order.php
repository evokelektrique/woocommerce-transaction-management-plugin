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

   /**
    * API Base url
    *
    * @var string
    */
   private $route;

   /**
    * Authentication bearer token
    *
    * @var string
    */
   private $api_key;
   
   /**
    * Retrieved response from requests
    *
    * @var array
    */
   public $response;

   /**
    * Perform a POST request to the base url with having the bearer token and save the response.
    *
    * @param array $data
    */
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

   /**
    * Fetch the base url from envinorment variables
    *
    * @return string
    */
   private function get_route() {
      $value = $_ENV["WEBSITE_URL"] . "/api/order/create";

      return $value;
   }

   /**
    * Fetch the authentication token from environment variables
    *
    * @return string
    */
   private function get_api_key() {
      $value = $_ENV["API_KEY"];

      return $value;
   }
}
