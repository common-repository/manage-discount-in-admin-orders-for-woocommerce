<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/h8ps1tm
 * @since      1.0.0
 *
 * @package    Manage_Discount_In_Admin_Orders_For_Woocommerce
 * @subpackage Manage_Discount_In_Admin_Orders_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Manage_Discount_In_Admin_Orders_For_Woocommerce
 * @subpackage Manage_Discount_In_Admin_Orders_For_Woocommerce/includes
 * @author     Tiago Mano <tiago@hellodev.us>
 */
class Manage_Discount_In_Admin_Orders_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'manage-discount-in-admin-orders-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
