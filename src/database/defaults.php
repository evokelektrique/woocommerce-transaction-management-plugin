<?php

namespace wtm_plugin\Database;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Insert Default Values Into Database
 */
class Defaults {

   /**
    * @access private
    * @static class $wpdb Wordpress Database Object Instance
    */
   private static $wpdb;

   /**
    * Set $wpdb class variable
    *
    * @access public
    * @static
    */
   public function __construct() {
      global $wpdb;
      self::$wpdb = $wpdb;
   }
}
