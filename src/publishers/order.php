<?php

namespace wtm_plugin\Publishers;

use GuzzleHttp\Client;
use wtm_plugin\Helper;

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

/**
 * Handle publishing orders
 */
class Order {

   private $route;

   public function __construct(array $body, object $target_node, bool $is_update, bool $is_delete) {
      // $get_target_node = \wtm_plugin\Tables\Nodes\Functions::get_by("hash", $target_node->hash);
      // $parsed_target_node_url = Helper::generate_url_from_node($target_node);
      // $response = $this->perform($body, $parsed_target_node_url, $is_update, $is_delete);
      // if(Helper::is_json($response)) {
      //    $response = json_decode($response, true);
      //    \wtm_plugin\Log::write(
      //       sprintf(__("%s", "wtm-plugin"), $response["message"]),
      //       $get_target_node->id,
      //       1 // Info
      //    );
      // } else {
      //    $response = ["status" => false, "message" => "unknown"];
      // }
      // return $response;
   }

   public function perform(array $body, array $parsed_target_node_url, bool $is_update, bool $is_delete) {
      // $controller      = new \wtm_plugin\Controllers\Publish();
      // $route           = $controller->get_route();
      // $target_node_url = $parsed_target_node_url["formed"] . $route;

      // $client = new \GuzzleHttp\Client();

      // $method = "POST";
      // if($is_delete) {
      //    $method = "DELETE";
      // }

      // try {
      //    $request = $client->request($method, $parsed_target_node_url["parsed"]["scheme"] . $target_node_url, [
      //       'json' => $body
      //    ]);
      //    return (string) $request->getBody();
      // } catch(\GuzzleHttp\Exception\ServerException $e) {
      //    return new \WP_Error('request-server-error',
      //       __(
      //          "Couldn't establish a connection to the server or an error happened on the target server.",
      //          'wtm-plugin'
      //       )
      //    );
      // } catch(\GuzzleHttp\Exception\ClientException $e) {
      //    $error = $e->getResponse()->getBody()->getContents();
      //    if(Helper::is_json($error)) {
      //       $error_array   = json_decode($error, true);
      //       $error_code    = $error_array["code"];
      //       $error_message = $error_array["message"];
      //       return new \WP_Error($error_code, $error_message);
      //    }

      //    return new \WP_Error('request-client-error',
      //       __(
      //          "Couldn't establish a connection to the server or an error happened on the target server.",
      //          'wtm-plugin'
      //       )
      //    );
      // }
   }

}
