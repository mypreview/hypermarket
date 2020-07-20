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
			add_filter( 'hypermarket_body_classes', array( $this, 'body_classes' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 20 );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'flexslider_args' ) );
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
		public function body_classes( $classes ) {
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
			wp_enqueue_style( 'hypermarket-woocommerce-style', get_theme_file_uri( sprintf( '/%s/woocommerce.css', HYPERMARKET_THEME_DIST_PATH ) ), array( 'hypermarket-style' ), HYPERMARKET_THEME_VERSION );
			wp_style_add_data( 'hypermarket-woocommerce-style', 'rtl', 'replace' );

			/**
			 * Scripts
			 */
			$script_dir = sprintf( '%s/woocommerce.js', HYPERMARKET_THEME_DIST_PATH );
			$script_asset = hypermarket_dependency_extraction( sprintf( '%s/%s', get_template_directory(), $script_dir ), array( 'hypermarket-script' ) );
			wp_enqueue_script( 'hypermarket-woocommerce-script', get_theme_file_uri( sprintf( '/%s', $script_dir ) ), $script_asset['dependencies'], $script_asset['version'], true );
		}

		/**
		 * Related Products Args
		 *
		 * @param  	array 		$args 	Related products args.
		 * @return  array 		$args 	Modified number of related products args
		 */
		public function related_products_args( $args ) {
			$args = apply_filters(
				'hypermarket_related_products_args', array(
					'posts_per_page' => 3,
					'columns'        => 3
				)
			);

			return $args;
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return 	integer 			Number of columns
		 * @return  integer
		 */
		public function thumbnail_columns() {
			$columns = 4;

			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			} // End If Statement

			return intval( apply_filters( 'hypermarket_product_thumbnail_columns', $columns ) );
		}

		/**
		 * Remove the breadcrumb delimiter.
		 *
		 * @param  	array 	$defaults 	The breadcrumb defaults.
		 * @return 	array           	The breadcrumb defaults.
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
			$defaults['wrap_before'] = '<div class="hypermarket-breadcrumb"><div class="col-full"><nav class="woocommerce-breadcrumb">';
			$defaults['wrap_after']  = '</nav></div></div>';

			return $defaults;
		}

		/**
		 * Modifies flexslider args.
		 *
		 * @param 	array 	$args 		The current flexslider arguments.
		 * @return 	array
		 */
		public function flexslider_args( $args ) {
			$args['smoothHeight'] = FALSE;
			$args['useCSS'] = is_rtl();

			return apply_filters( 'hypermarket_product_flexslider_args', $args );
		}

	}
endif;

return new Hypermarket_WooCommerce();