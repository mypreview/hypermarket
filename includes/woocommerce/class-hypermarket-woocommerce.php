<?php
/**
 * The class that defines the integration between theme and WooCommerce plugin.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/woocommerce
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_WooCommerce' ) ) :

	/**
	 * The main `Hypermarket` WooCommerce integration class
	 */
	final class Hypermarket_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'hypermarket_after_setup_theme', array( $this, 'setup' ) );
			add_action( 'hypermarket_enqueue_scripts', array( $this, 'enqueue' ) );
			add_filter( 'hypermarket_body_classes', array( $this, 'body_classes' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'flexslider_args' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WooCommerce features.
		 * Note that this function is hooked into the `hypermarket_after_setup_theme` hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function setup() {
			add_theme_support(
				'woocommerce',
				apply_filters(
					'hypermarket_woocommerce_args',
					array(
						'single_image_width'    => 416,
						'thumbnail_image_width' => 324,
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 1,
							'max_columns'     => 6,
							'min_rows'        => 1,
						),
					)
				)
			);

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function enqueue() {
			global $hypermarket;
			$asset_name = 'woocommerce';
			$asset      = hypermarket_get_file_assets( $asset_name );
			// Styles.
			wp_enqueue_style( sprintf( '%s-%s-style', $hypermarket->slug, $asset_name ), get_theme_file_uri( sprintf( '/dist/%s.css', $asset_name ) ), '', $asset['version'], 'all' );
			wp_style_add_data( sprintf( '%s-%s-style', $hypermarket->slug, $asset_name ), 'rtl', 'replace' );
			// Scripts.
			wp_enqueue_script( sprintf( '%s-%s-script', $hypermarket->slug, $asset_name ), get_theme_file_uri( sprintf( '/dist/%s.js', $asset_name ) ), $asset['dependencies'], $asset['version'], true );
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @since   2.0.0
		 * @param   array $classes    Css classes applied to the body tag.
		 * @return  array       $classes    Modified to include 'woocommerce-active' class
		 */
		public function body_classes( $classes ) {
			$classes[] = 'woocommerce-active';

			// Add class if WooCommerce ajax is disabled.
			if ( ! wc_string_to_bool( get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) ) {
				$classes[] = 'no-wc-ajax';
			}

			// Remove `no-wc-breadcrumb` body class.
			$key = array_search( 'no-wc-breadcrumb', $classes, true );

			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}

			return $classes;
		}

		/**
		 * Related Products Args
		 *
		 * @since   2.0.0
		 * @param   array $args   Related products args.
		 * @return  array       $args   Modified number of related products args
		 */
		public function related_products_args( $args ) {
			$args = apply_filters(
				'hypermarket_related_products_args',
				array(
					'posts_per_page' => 3,
					'columns'        => 3,
				)
			);

			return $args;
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @since   2.0.0
		 * @return  integer
		 */
		public function thumbnail_columns() {
			$columns = 4;

			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			}

			return intval( apply_filters( 'hypermarket_product_thumbnail_columns', $columns ) );
		}

		/**
		 * Remove the breadcrumb delimiter.
		 *
		 * @since   2.0.0
		 * @param   array $defaults   The breadcrumb defaults.
		 * @return  array
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
			$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
			$defaults['wrap_after']  = '</nav>';

			return $defaults;
		}

		/**
		 * Modifies flexslider args.
		 *
		 * @since   2.0.0
		 * @param   array $args       The current flexslider arguments.
		 * @return  array
		 */
		public function flexslider_args( $args ) {
			$args['smoothHeight'] = false;
			$args['useCSS']       = is_rtl();

			return apply_filters( 'hypermarket_product_flexslider_args', $args );
		}

	}
endif;
