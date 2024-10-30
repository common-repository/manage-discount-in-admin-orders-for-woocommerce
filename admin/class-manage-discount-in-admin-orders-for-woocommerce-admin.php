<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/h8ps1tm
 * @since      1.0.0
 *
 * @package    Manage_Discount_In_Admin_Orders_For_Woocommerce
 * @subpackage Manage_Discount_In_Admin_Orders_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Manage_Discount_In_Admin_Orders_For_Woocommerce
 * @subpackage Manage_Discount_In_Admin_Orders_For_Woocommerce/admin
 * @author     Tiago Mano <tiago@hellodev.us>
 */
class Manage_Discount_In_Admin_Orders_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Manage_Discount_In_Admin_Orders_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Manage_Discount_In_Admin_Orders_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/manage-discount-in-admin-orders-for-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Manage_Discount_In_Admin_Orders_For_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Manage_Discount_In_Admin_Orders_For_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/manage-discount-in-admin-orders-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'wmdaoa_locales', array(
			'apply_error_message' => __('Invalid discount amount.', $this->plugin_name ),
			'confirm_apply_discount' => __('Applying the discount will overwrite existing discounts. Do you want to continue?', $this->plugin_name )
		) );

	}
	
	/**
	 * Check if WooCommerce is activated and if not show a notice message
	 *
	 * @since    1.0.0
	*/
	public function hc_wc_admin_notice() {
		
		if ( ! class_exists( 'woocommerce' ) && current_user_can( 'activate_plugins' ) ) :
			?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php
					printf(
						__('To use our plugin %1$s you need to activate the %2$sWooCommerce%3$s.', $this->plugin_name ),
						'<strong>Manage Discount in Admin Orders for WooCommerce</strong>',
						'<a href="https://pt.wordpress.org/plugins/woocommerce/" target="_blank" >',
						'</a>'
					);
					?>
				</p>
			</div>		
			<?php
		endif;
		
	}
	
	/**
	 * Add a column to WooCommerce Products items
	 *
	 * @since    1.0.0
	*/
	public function admin_order_item_headers() {
		
		$order_editable = Manage_Discount_In_Admin_Orders_For_Woocommerce_Admin::check_order_editable( '' );
		if (  $order_editable === '1' ) {
			?>
			<th class="discount"><?php _e( 'Apply Discount', $this->plugin_name ); ?></th>
			<?php
			
		}
		
	}
	
	/**
	 * Add the field and button to apply discount to a product
	 *
	 * @since    1.0.0
	*/
	public function admin_order_item_values( $product, $item, $item_id ) {

		$order_editable = Manage_Discount_In_Admin_Orders_For_Woocommerce_Admin::check_order_editable( $item );
		if (  $order_editable === '1' ) {
			?>
			<td class="discount-percentage-td">
				<?php if ( $product ) { ?>
				<input type="number" class="hellodev-discount-manager-apply-discount-percentage" name="hellodev-discount-manager-apply-discount-percentage" min="0" max="100" placeholder="<?php _e( 'In %', $this->plugin_name ); ?>" style="width: 80px" />
				<?php } ?>
			</td>
			<?php
		}
		
	}
	
	/**
	 * Add a meta box to a Shop Order
	 *
	 * @since    1.0.0
	*/
	public function add_apply_discount_container() {
		
		$order_editable = Manage_Discount_In_Admin_Orders_For_Woocommerce_Admin::check_order_editable( '' );
		if (  $order_editable !== '0' ) 
			add_meta_box( 'wc-discount-manager', __('Order Discount', $this->plugin_name ), array($this, 'wc_create_apply_discount'), 'shop_order', 'side' );		
	}
	
	/**
	 * Content for the Meta Box to apply the discount to an order
	 *
	 * @since    1.0.0
	*/
	public function wc_create_apply_discount() {
		?>
		<ul id="hellodev-discount-manager-apply-discount" class="hellodev-discount-manager-apply-discount">
			<li>
				<input id="hellodev-discount-manager-apply-discount-percentage" type="number" name="discount" min="0" max="100" step="1" placeholder="<?php _e( 'Discount in percentage (%)', $this->plugin_name ) ?>" style="width: 100%"/>
			</li>
			<li>
				<button type="button" class="calculate-discount-order button"><?php _e( 'Calculate Discount', $this->plugin_name ) ?></button>
			</li>
		</ul>
		<?php
	}
	
	/**
	 * Check if the discounts fields can be applied or not
	 *
	 * @since    1.0.0
	*/
	private function check_order_editable( $item ) {

		global $post_id;

		if ( $item !== '' ) {
			
			if ( $post_id && get_post_type( $post_id ) === 'shop_order' ) {
				$order = wc_get_order( $post_id );
			
				if( is_a( $item, "WC_Order_Refund" ) || ! $order->is_editable() ) {
					return '0';
				}
			} else if( is_a( $item, "WC_Order_Refund" ) ) {
				return '0';
			}
			
		} else {
						
			if ( $post_id && get_post_type( $post_id ) === 'shop_order' ) {
				$order = wc_get_order( $post_id );
			
				if( ! $order->is_editable() ) {
					return '0';
				}
			}
		}
		
		return '1';
		
	}

}
