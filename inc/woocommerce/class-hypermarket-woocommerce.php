<?php
/**
 * Hypermarket WooCommerce class
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview, @gookalani)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Hypermarket_WooCommerce' ) ) :

	/**
	 * The main `Hypermarket` WooCommerce integration class
	 */
	final class Hypermarket_WooCommerce {

		/**
		 * Setup class.
		 * 
		 * @return  void
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_filter( 'hypermarket_body_classes', array( $this, 'body_classes' ), 10, 1 );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 20 );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 * Note that this function is hooked into the `after_setup_theme` hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @return 	void
		 */
		public function setup() {
			add_theme_support(
				'woocommerce', apply_filters(
					'hypermarket_woocommerce_args', array(
						'single_image_width'    => 416,
						'thumbnail_image_width' => 324,
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1
						),
					)
				)
			);

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			/**
			 * Add 'hypermarket_woocommerce_setup' action.
			 */
			do_action( 'hypermarket_woocommerce_setup' );
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @param  	array 		$classes 	Css classes applied to the body tag.
		 * @return 	array 		$classes 	Modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			$classes[] = 'woocommerce-active';

			// Add class if WooCommerce ajax is disabled.
			if ( ! wc_string_to_bool( get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) ) {
				$classes[] = 'no-wc-ajax';
			} // End If Statement

			// Remove `no-wc-breadcrumb` body class.
			$key = array_search( 'no-wc-breadcrumb', $classes, true );

			if ( false !== $key ) {
				unset( $classes[ $key ] );
			} // End If Statement

			return $classes;
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @return  void
		 */
		public function scripts() {
			/**
			 * Styles
			 */
			wp_enqueue_style( 'hypermarket-woocommerce-style', get_theme_file_uri( sprintf( '/%s/css/woocommerce.css', HYPERMARKET_THEME_DIST_PATH ) ), array( 'hypermarket-style' ), HYPERMARKET_THEME_VERSION );
			wp_style_add_data( 'hypermarket-woocommerce-style', 'rtl', 'replace' );

			/**
			 * Scripts
			 */
			$script_dir = sprintf( '%s/js/woocommerce.js', HYPERMARKET_THEME_DIST_PATH );
			$script_asset = hypermarket_dependency_extraction( sprintf( '%s/%s', get_template_directory(), $script_dir ), array( 'hypermarket-script' ) );
			wp_enqueue_script( 'hypermarket-woocommerce-script', get_theme_file_uri( sprintf( '/%s', $script_dir ) ), $script_asset['dependencies'], $script_asset['version'], true );
		}

	}
endif;

return new Hypermarket_WooCommerce();