<?php

namespace WooProductField\Admin;

defined( 'ABSPATH' ) || exit;

class ProductFields {

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

		add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'add_field' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_field' ), 10, 2 );

		add_action( 'woocommerce_variation_options_inventory', array( $this, 'add_variation_field' ), 10, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_field' ), 10, 2 );

	}

	/**
	 * ADD custom field
	 *
	 * @since 1.0.0
	 */
	public function add_field() {

		global $product_object;

		?>
		<div class="inventory_new_stock_information options_group show_if_simple show_if_variable">
			<?php woocommerce_wp_text_input(
				array(
					'id'          => '_new_stock_information',
					'label'       => __( 'New Stock', 'woo_product_field' ),
					'description' => __( 'Information shown in store', 'woo_product_field' ),
					'desc_tip'    => true,
					'value'       => $product_object->get_meta( '_new_stock_information' )
				)
			 ); ?>
		</div>
		<?php

	}

	/**
	* SAVE custom field
	 *
	 * @since 1.0.0
	 */
	public function save_field( $post_id, $post ) {

		if( isset( $_POST['_new_stock_information'] ) ) {
			$product = wc_get_product( intval( $post_id ) );
			$product->update_meta_data( '_new_stock_information', sanitize_text_field( $_POST['_new_stock_information'] ) );
			$product->save_meta_data();
		}

	}

	/**
	 * ADD variation custom field
	 *
	 * @since 1.0.0
	 */
	public function add_variation_field( $loop, $variation_data, $variation ) {

		$variation_product = wc_get_product( $variation->ID );

		woocommerce_wp_text_input(
			array(
				'id'            => '_new_stock_information'  . '[' . $loop . ']',
				'label'         => __( 'New Stock Information', 'woo_product_field' ),
				'wrapper_class' => 'form-row form-row-full',
				'value'         => $variation_product->get_meta( '_new_stock_information' )
			)
		);

	}

	/**
	* SAVE variation custom field
	 *
	 * @since 1.0.0
	 */
	public function save_variation_field( $variation_id, $i  ) {

		if( isset( $_POST['_new_stock_information'][$i] ) ) {
			$variation_product = wc_get_product( $variation_id );
			$variation_product->update_meta_data( '_new_stock_information', sanitize_text_field( $_POST['_new_stock_information'][$i] ) );
			$variation_product->save_meta_data();
		}

	}

}
