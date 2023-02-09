<?php

namespace wtm_plugin;

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

class Plugin {

   /**
    * @access public
    * @static string $version Current version of plugin
    */
   public static $version = "0.1";

   /**
    * @access public
    * @static class $default_db Database Default Values Class Instance
    */
   public static $default_db;

   /**
    * Config class instance
    * @var class
    */
   public static $config;

   /**
    * @access private
    * @static class $isntance Singleton class instance
    */
   private static $instance;

   /**
    * Current database migration version
    * And will be saved in 'wp_options' table
    *
    * @static float $db_version Migration version
    */
   private static $db_version = 0.1;

   /**
    * Load Files And Initialize Classes In Order
    */
   private function __construct() {
      self::$config = new Config();

      // Initialize Database
      //
      // Check if current database version stored on `wp_options`
      // table is set or lower than the plugin's version($db_version)
      // and if so, then upgrade current database.
      $option_db_version = get_option("wtm-plugin_db_version");
      if($option_db_version === false || $option_db_version < self::$db_version) {
         $this->init_db();
      }

      // Initialize Hooks
      $this->init_hooks();

      // Insert Default Values Into Database
      self::$default_db = new Database\Defaults();

      // Display menus on dashboard and other pages
      new Dashboard();

      // Initialize Listeners
      new Listeners\Order();
   }

   /**
    * Retrieve singleton class instance
    */
   public static function get_instance() {
      if(!isset(self::$instance)) {
         self::$instance = new Plugin();
      }

      return self::$instance;
   }

   /**
    * Initializes Database Tables
    */
   private function init_db() {
      // Require wordpress database files
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

      update_option( "wtm-plugin_db_version", self::$db_version );

      // Initialize Schema Generator Class
      $schema_generator = new Database\Schema();

      // Get Table Schemas And Insert Them Into an Array
      $schemas = [];
      $schemas[] = $schema_generator::settings();

      // Iterate over schemas and create them
      foreach($schemas as $schema) {
         dbDelta( $schema );
      }
   }

   /**
    * Initialize hooks
    *
    * @return void
    */
   private function init_hooks() {

      Hooks::add_action("init", function() {
         // Load languages
         load_plugin_textdomain("wtm-plugin", false, dirname(plugin_basename(__FILE__)) . '/../languages');
      });
   }

}
