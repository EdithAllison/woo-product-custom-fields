<?php

namespace WooProductField\Admin;

/**
 * WooProductField Setup Class
 */
class Setup {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );

		new ProductFields();
	}

	/**
	 * Load all necessary dependencies.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		if ( ! method_exists( 'Automattic\WooCommerce\Admin\PageController', 'is_admin_or_embed_page' ) ||
		! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page()
		) {
			return;
		}

		$script_path       = '/build/index.js';
		$script_asset_path = dirname( MAIN_PLUGIN_FILE ) . '/build/index.asset.php';
		$script_asset      = file_exists( $script_asset_path )
		? require $script_asset_path
		: array(
			'dependencies' => array(),
			'version'      => filemtime( $script_path ),
		);
		$script_url        = plugins_url( $script_path, MAIN_PLUGIN_FILE );

		wp_register_script(
			'woo-product-field',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_register_style(
			'woo-product-field',
			plugins_url( '/build/index.css', MAIN_PLUGIN_FILE ),
			// Add any dependencies styles may have, such as wp-components.
			array(),
			filemtime( dirname( MAIN_PLUGIN_FILE ) . '/build/index.css' )
		);

		wp_enqueue_script( 'woo-product-field' );
		wp_enqueue_style( 'woo-product-field' );
	}

}
