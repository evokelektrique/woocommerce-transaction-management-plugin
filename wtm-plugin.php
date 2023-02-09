<?php

/**
 * Plugin Name:       Woocommerce Transaction Management
 * Plugin URI:        https://github.com/evokelektrique/woocommerce-transaction-management-plugin
 * Description:       Easily manage and migrate your WooCommerce transactions
 * Version:           0.1
 * Requires at least: 5.2
 * Author:            EVOKE
 * Author URI:        https://github.com/evokelektrique/
 * License:           AGPL v3
 * License URI:       https://www.gnu.org/licenses/agpl-3.0.txt
 * Text Domain:       wtm-plugin
 * Domain Path:       /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

use \wtm_plugin\Plugin;

require_once __DIR__ . "/vendor/autoload.php";

$GLOBALS["wtm-plugin"] = Plugin::get_instance();
