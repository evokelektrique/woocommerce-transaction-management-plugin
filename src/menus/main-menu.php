<?php

namespace wtm_plugin\Menus;

// Exit if accessed directly
if(!defined( 'ABSPATH' )) exit;

class MainMenu {

   public function __construct() {
      add_menu_page(
         __("WTM", "wtm-plugin"),
         __("WTM", "wtm-plugin"),
         "manage_options",
         "wtm-plugin-dashboard",
         [$this, "handle"],
         \wtm_plugin\Config::$ROOT_URL . "../dist/images/icon_16x16.png",
         6
      );
   }

   public static function handle() {
      $file_path = \wtm_plugin\Config::$ROOT_DIR . "src/views/dashboard.php";

      if(is_file($file_path)) {
         require_once $file_path;
      }
   }
}
