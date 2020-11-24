<?php
/**
 * The class that defines the integration between theme and WooCommerce plugin.
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
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
			add_filter( 'hypermarket_l10n_args', array( $this, 'l10_args' ) );
			add_action( 'hypermarket_enqueue_public', array( $this, 'enqueue' ) );
			add_filter( 'hypermarket_body_classes', array( $this, 'body_classes' ) );
			add_filter( 'hypermarket_post_meta_args', array( $this, 'register_post_meta' ) );
			add_filter( 'woocommerce_sale_flash', array( $this, 'sale_flash' ) );
			add_filter( 'woocommerce_upsell_display_args', array( $this, 'upsell_products_args' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sell_products_cols' ) );
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
			add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'flexslider_args' ) );
			add_filter( 'woocommerce_single_product_image_gallery_classes', array( $this, 'image_gallery_classes' ) );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'woocommerce_cart_item_remove_link', array( $this, 'remove_link' ) );
			add_filter( 'woocommerce_order_button_text', array( $this, 'order_button_text' ) );
			add_filter( 'woocommerce_review_gravatar_size', array( $this, 'review_gravatar_size' ) );
			add_filter( 'woocommerce_product_reviews_tab_title', array( $this, 'reviews_tab_title' ) );
			add_filter( 'woocommerce_subcategory_count_html', array( $this, 'subcategory_count_html' ) );
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
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
						'single_image_width'    => apply_filters( 'hypermarket_woocommerce_single_image_width', 660 ),
						'thumbnail_image_width' => apply_filters( 'hypermarket_woocommerce_thumbnail_image_width', 364 ),
						'product_grid'          => array(
							'default_columns' => 3,
							'default_rows'    => 4,
							'min_columns'     => 2,
							'max_columns'     => 4,
						),
					)
				)
			);

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		/**
		 * Adds a few extra localized data to the public-facing JavaScript params.
		 *
		 * @since    1.0.0
		 * @param    array $args   Localized script params.
		 * @return   array
		 */
		public function l10_args( $args ) {
			$args['i18n_added_to_cart']     = _x( 'Added to your cart.', 'toast message', 'hypermarket' );
			$args['i18n_removed_from_cart'] = _x( 'Removed from your cart.', 'toast message', 'hypermarket' );

			return $args;
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function enqueue() {
			$asset_name    = 'woocommerce';
			$asset         = hypermarket_get_file_assets( $asset_name );
			$style_handle  = hypermarket_get_asset_handle( $asset_name, 'style' );
			$script_handle = hypermarket_get_asset_handle( $asset_name, 'script' );

			// Styles.
			wp_enqueue_style( $style_handle, get_theme_file_uri( sprintf( '/build/%s.css', $asset_name ) ), '', $asset['version'], 'all' );
			wp_style_add_data( $style_handle, 'rtl', 'replace' );
			// Scripts.
			wp_enqueue_script( $script_handle, get_theme_file_uri( sprintf( '/build/%s.js', $asset_name ) ), $asset['dependencies'], $asset['version'], true );

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound, WordPress.NamingConventions.ValidHookName.UseUnderscores
			do_action( sprintf( 'hypermarket_enqueue_%s', $asset_name ), $style_handle, $script_handle, $asset_name );
		}

		/**
		 * Add WooCommerce specific classes to the body tag
		 *
		 * @since   2.0.0
		 * @param   array $classes    Css classes applied to the body tag.
		 * @return  array
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
		 * Append additional metas to the `hypermarket_metas` meta-data.
		 *
		 * @since   2.0.0
		 * @param   array $properties   Default meta properties.
		 * @return  array       
		 */
		public function register_post_meta( $properties ) {
			$properties['breadcrumbs'] = array(
				'type'              => 'boolean',
				'sanitize_callback' => hypermarket_sanitize_method( 'boolean' ),
			);
			
			return $properties;
		} 

		/**
		 * Overwrite product `Sale` flash markup/output.
		 *
		 * @since   2.0.0
		 * @param   html $return   Default html markup.
		 * @return  html       
		 */
		public function sale_flash( $return ) {
			$is_new = hypermarket_product_new_flash( true, false );
			
			// Whether the product was published within the newness time frame.
			if ( ! empty( $is_new ) ) {
				return $is_new;
			}

			$is_featured = hypermarket_product_featured_flash( true, false );
			
			// Whether the product was marked as a `Featured` product.
			if ( ! empty( $is_featured ) ) {
				return $is_featured;
			}

			return $return;
		}

		/**
		 * Upsell products args.
		 *
		 * @since   2.0.0
		 * @param   array $args   Upsell products args.
		 * @return  array       
		 */
		public function upsell_products_args( $args ) {
			$has_sidebar = hypermarket_has_sidebar();
			$args        = apply_filters(
				'hypermarket_upsell_products_args',
				array(
					'columns'  => $has_sidebar ? 3 : 4,
				)
			);

			return $args;
		}

		/**
		 * Related products args.
		 *
		 * @since   2.0.0
		 * @param   array $args   Related products args.
		 * @return  array       
		 */
		public function related_products_args( $args ) {
			$has_sidebar = hypermarket_has_sidebar();
			$args        = apply_filters(
				'hypermarket_related_products_args',
				array(
					'posts_per_page' => 6,
					'columns'        => $has_sidebar ? 3 : 4,
				)
			);

			return $args;
		}

		/**
		 * Cross-sell products columns.
		 *
		 * @since   2.0.0
		 * @param   integer $cols   Cross sell products columns.
		 * @return  integer       
		 */
		public function cross_sell_products_cols( $cols ) {
			$has_sidebar = hypermarket_has_sidebar();
			$args        = apply_filters(
				'hypermarket_cross_sell_products_cols',
				$has_sidebar ? 3 : 4
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
			return apply_filters( 'hypermarket_product_thumbnail_columns', 1 );
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
			$args['animation']    = 'fade';
			$args['useCSS']       = is_rtl();

			return apply_filters( 'hypermarket_product_flexslider_args', $args );
		}

		/**
		 * Modifies product gallery CSS class names.
		 *
		 * @since   2.0.0
		 * @param   array $classes    The current CSS class names.
		 * @return  array
		 */
		public function image_gallery_classes( $classes ) {
			// Retrieves theme modification value for the current theme (parent or child).
			$is_activated = get_theme_mod( sprintf( '%s_wc_details_disable_zoom', Hypermarket_Customize::$setting_prefix ), false );

			if ( ! ! $is_activated ) {
				$classes[] = 'woocommerce-product-gallery--disable-zoom';
			}

			return $classes;
		}

		/**
		 * Modifies pagination for shop archive pages.
		 *
		 * @since   2.0.0
		 * @param   array $args   The current pagination arguments.
		 * @return  array
		 */
		public function pagination_args( $args ) {
			/* translators: 1: Open span tag, 2: Close span tag. */
			$args['next_text'] = apply_filters( 'hypermarket_paging_next_text', sprintf( esc_html_x( '%1$sNext%2$s', 'Next post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) );
			/* translators: 1: Open span tag, 2: Close span tag. */
			$args['prev_text'] = apply_filters( 'hypermarket_paging_prev_text', sprintf( esc_html_x( '%1$sPrev%2$s', 'Previous post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) );

			return apply_filters( 'hypermarket_product_pagination_args', $args );
		}

		/**
		 * Appends tooltip content attribute to the link.
		 * Only append when viewing the cart page.
		 *
		 * @since   2.0.0
		 * @param   html $link       HTML anchor tag.
		 * @return  html
		 */
		public function remove_link( $link ) {
			/* translators: 1: Tooltip attribute, 2: Closing anchor tag. */
			$link = is_cart() ? str_replace( '">', sprintf( esc_html__( '%1$sRemove%2$s', 'hypermarket' ), '" data-tippy-content="', '">' ), $link ) : $link;
			return apply_filters( 'hypermarket_cart_item_remove_link', $link );
		}

		/**
		 * Overwrite `Place Order` button text on checkout page.
		 * 
		 * @since   2.0.0
		 * @return  string
		 */
		public function order_button_text() {
			return apply_filters( 'hypermarket_order_button_text', esc_html_x( 'Checkout', 'place order button', 'hypermarket' ) );
		}

		/**
		 * Overwrite default user gravatar size.
		 * 
		 * @since   2.0.0
		 * @return  integer
		 */
		public function review_gravatar_size() {
			return apply_filters( 'hypermarket_review_gravatar_size', 80 ); 
		}

		/**
		 * Adds a span around review counts in single product tab.
		 *
		 * @since   2.0.0
		 * @param   html $title      HTML markup of the review tab title.
		 * @return  html
		 */
		public function reviews_tab_title( $title ) {
			$title = str_replace( '(', '<sup class="count">', $title );
			$title = str_replace( ')', '</sup>', $title );

			return $title;
		}

		/**
		 * Removes parentheses from the subcategory count.
		 *
		 * @since   2.0.0
		 * @param   html $html      HTML markup of the subcategory count.
		 * @return  html
		 */
		public function subcategory_count_html( $html ) {
			$html = str_replace( array( '(', ')' ), '', $html );

			return $html;
		}

	}
endif;
