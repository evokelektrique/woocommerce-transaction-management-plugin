<?php

namespace wtm_plugin;

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

class Helper {

   /**
    * Print custom notice
    *
    * @param  string $status  Status given from $_GET arguments ("error" or "success")
    * @param  string $message Message given from $_GET arguments
    * @return string          Custom html notice output with $status class
    */
   public static function print_notice($status, $message) {
      if($message):
      ?>

      <div class="wtm-plugin-notice wtm-plugin-notice-<?php echo esc_html($status) ?>">
         <?php echo esc_html(htmlspecialchars($message)) ?>
      </div>

      <?php
      endif;
   }

   /**
    * Print custom badge
    *
    * @param  boolean $status Current status
    * @return string          Custom HTML badge
    */
   public static function print_badge($status) {
      ?>

      <span class="wtm-plugin-badge wtm-plugin-badge-<?php echo $status ? "success" : "error" ?>">
         <?php echo $status ? esc_html__('Yes', 'wtm-plugin') : esc_html__('No', 'wtm-plugin'); ?>
      </span>

      <?php
   }

   /**
    * Check if WooCommerce is activated in theme
    *
    * @return bool Activation status
    */
   public static function is_woocommerce_active() {
      return class_exists("WooCommerce");
   }

   /**
    * Validate JSON format
    *
    * @param  $json JSON String
    * @return boolean       Validation status
    */
   public static function is_json($json): bool {
      if(empty($json)) {
         return false;
      }

      json_decode($json);
      return json_last_error() === JSON_ERROR_NONE;
   }

}
