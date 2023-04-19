<?php
/**
 * Plugin Name: Woo Product Field
 * Version: 1.0.0
 * Author: The WordPress Contributors
 * Author URI: https://woocommerce.com
 * Text Domain: woo_product_field
 * Domain Path: /languages
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package extension
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MAIN_PLUGIN_FILE' ) ) {
	define( 'MAIN_PLUGIN_FILE', __FILE__ );
}

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';

use WooProductField\Admin\Setup;

// phpcs:disable WordPress.Files.FileName

/**
 * WooCommerce fallback notice.
 *
 * @since 1.0.0
 */
function woo_product_field_missing_wc_notice() {
	/* translators: %s WC download URL link. */
	echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Woo Product Field requires WooCommerce to be installed and active. You can download %s here.', 'woo_product_field' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
}

register_activation_hook( __FILE__, 'woo_product_field_activate' );

/**
 * Activation hook.
 *
 * @since 1.0.0
 */
function woo_product_field_activate() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'woo_product_field_missing_wc_notice' );
		return;
	}
}

if ( ! class_exists( 'woo_product_field' ) ) :
	/**
	 * The woo_product_field class.
	 */
	class woo_product_field {
		/**
		 * This class instance.
		 *
		 * @var \woo_product_field single instance of this class.
		 */
		private static $instance;

		/**
		 * Constructor.
		 */
		public function __construct() {
			if ( is_admin() ) {
				new Setup();
			}
			new WooProductField\Product();
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'woo_product_field' ), $this->version );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'woo_product_field' ), $this->version );
		}

		/**
		 * Gets the main instance.
		 *
		 * Ensures only one instance can be loaded.
		 *
		 * @return \woo_product_field
		 */
		public static function instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
endif;

add_action( 'plugins_loaded', 'woo_product_field_init', 10 );

/**
 * Initialize the plugin.
 *
 * @since 1.0.0
 */
function woo_product_field_init() {
	load_plugin_textdomain( 'woo_product_field', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'woo_product_field_missing_wc_notice' );
		return;
	}

	woo_product_field::instance();

}
