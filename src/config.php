<?php

namespace wtm_plugin;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Handle configuration
 */
class Config {

   public static $TABLES_PREFIX = "wtm_plugin_";
   public static $ROOT_DIR;
   public static $ROOT_URL;
   public static $TABLES;

   public function __construct() {
      self::$ROOT_DIR = plugin_dir_path(__FILE__) . "../";
      self::$ROOT_URL = plugins_url("/", __FILE__);

      $this->set_tables();
      $this->set_env();
   }

   /**
    * Setup table names
    *
    * @global wpdb $wpdb WordPress database abstraction object.
    */
   private function set_tables() {
      global $wpdb;

      $tables = [
         "settings" => $wpdb->prefix . self::$TABLES_PREFIX . "settings",
      ];

      self::$TABLES = $tables;
   }

   /**
    * Setup environment variables
    *
    * @return void
    */
   private function set_env() {
      $dotenv = \Dotenv\Dotenv::createImmutable(self::$ROOT_DIR);
      $dotenv->load();
   }
}
