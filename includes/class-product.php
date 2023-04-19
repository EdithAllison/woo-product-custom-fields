<?php

namespace WooProductField;

defined( 'ABSPATH' ) || exit;

class Product {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		$this->hooks();

	}

	/**
	 * Register the hooks
	 *
	 * @since 1.0.0
	 */
	private function hooks() {

		add_action( 'woocommerce_single_product_summary', array( $this, 'add_stock_info' ), 21 );

	}


	/**
	 * ADD stock information
	 *
	 * @since 1.0.0
	 */
	public function add_stock_info() {

		global $product;

		?>
		<p><?php echo esc_html( $product->get_meta( '_new_stock_information' ) ); ?> </p>
		<?php

	}





}
