<?php

/**
 * @link              https://github.com/h8ps1tm
 * @since             1.0.0
 * @package           Manage_Discount_In_Admin_Orders_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Manage Discount in Admin Orders for WooCommerce
 * Plugin URI:        https://hellodev.us
 * Description:       This plugin allows you to manage discounts in WooCommerce orders placed in the backoffice.
 * Version:           1.0.0
 * Author:            Tiago Mano
 * Author URI:        https://github.com/h8ps1tm
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       manage-discount-in-admin-orders-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MANAGE_DISCOUNT_IN_ADMIN_ORDERS_FOR_WOOCOMMERCE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-manage-discount-in-admin-orders-for-woocommerce-activator.php
 */
function activate_manage_discount_in_admin_orders_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manage-discount-in-admin-orders-for-woocommerce-activator.php';
	Manage_Discount_In_Admin_Orders_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-manage-discount-in-admin-orders-for-woocommerce-deactivator.php
 */
function deactivate_manage_discount_in_admin_orders_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manage-discount-in-admin-orders-for-woocommerce-deactivator.php';
	Manage_Discount_In_Admin_Orders_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_manage_discount_in_admin_orders_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_manage_discount_in_admin_orders_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-manage-discount-in-admin-orders-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_manage_discount_in_admin_orders_for_woocommerce() {

	$plugin = new Manage_Discount_In_Admin_Orders_For_Woocommerce();
	$plugin->run();

}
run_manage_discount_in_admin_orders_for_woocommerce();
