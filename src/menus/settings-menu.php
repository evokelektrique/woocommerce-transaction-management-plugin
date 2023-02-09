<?php

namespace wtm_plugin\Menus;

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

class SettingsMenu {

   public function __construct() {
      add_submenu_page(
         "wtm-plugin-dashboard",
         __("Settings", "wtm-plugin"),
         __("Settings", "wtm-plugin"),
         "manage_options",
         "wtm-plugin-settings",
         [$this, "handle"]
      );
   }

   public static function handle() {
      $file_path = \wtm_plugin\Config::$ROOT_DIR . "src/views/settings.php";

      if(is_file($file_path)) {
         require_once $file_path;
      }
   }
}
