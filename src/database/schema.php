<?php

namespace wtm_plugin\Database;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Generates pre defined specific SQL Queries
 */
class Schema {

   /**
    * Wordpress Database Object Instance
    * @var class
    */
   private static $wpdb;

   /**
    * Sets $wpdb class variable
    */
   public function __construct() {
      global $wpdb;
      self::$wpdb = $wpdb;
   }

   /**
    * Generates schema of "wtm-plugin_settings" table
    * @return string Create table SQL query
    */
   public static function settings() {
      $table_name = \wtm_plugin\Config::$TABLES["settings"];

      $charset_collate = self::$wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
         `id` INT unsigned NOT NULL AUTO_INCREMENT,
         `option` VARCHAR(255) NOT NULL,
         `value` TEXT NOT NULL,
         PRIMARY KEY  (`id`)
      ) $charset_collate;";
      return $sql;
   }
}
