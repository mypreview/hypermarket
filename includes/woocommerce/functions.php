<?php
/**
 * Integration between theme and WooCommerce plugin.
 *
 * @link          https://mypreview.one
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/includes/woocommerce
 */

namespace Hypermarket\Includes\WooCommerce;

use function Hypermarket\Includes\Utils\enqueue_resources as enqueue_resources;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Sets up theme defaults and registers support for various WooCommerce features.
 * Note that this function is hooked into the `hypermarket_after_setup_theme` hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since     2.0.0
 * @return    void
 */
function setup(): void {
	add_theme_support(
		'woocommerce',
		apply_filters(
			'hypermarket_woocommerce_theme_support_args',
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
add_action( 'hypermarket_after_setup_theme', __NAMESPACE__ . '\setup' );

/**
 * Enqueue scripts and styles.
 *
 * @since     2.0.0
 * @param     array $classes    Classes for the body element.
 * @return    array
 */
function body_classes( array $classes ): array {
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
add_filter( 'hypermarket_body_classes', __NAMESPACE__ . '\body_classes' );

/**
 * Cross-sell products columns.
 *
 * @since     2.0.0
 * @return    int       
 */
function cross_sell_columns(): int {
	$columns = apply_filters( 'hypermarket_woocommerce_cross_sells_columns', 4 );
	return $columns;
}
add_filter( 'woocommerce_cross_sells_columns', __NAMESPACE__ . '\cross_sell_columns' );

/**
 * Upsell products args.
 *
 * @since     2.0.0
 * @param     array $args    Upsell products args.
 * @return    array       
 */
function upsell_products_args( array $args ): array {
	$args = apply_filters( 'hypermarket_woocommerce_upsell_display_args', array( 'columns' => 4 ) );
	return $args;
}
add_filter( 'woocommerce_upsell_display_args', __NAMESPACE__ . '\upsell_products_args' );

/**
 * Related products args.
 *
 * @since     2.0.0
 * @param     array $args    Related products args.
 * @return    array       
 */
function related_products_args( array $args ): array {
	$args = apply_filters(
		'hypermarket_woocommerce_output_related_products_args',
		array(
			'columns'        => 4,
			'posts_per_page' => 6,
		) 
	);
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', __NAMESPACE__ . '\related_products_args' );

/**
 * Product gallery thumbnail columns.
 *
 * @since     2.0.0
 * @return    int
 */
function product_thumbnails_columns(): int {
	return apply_filters( 'hypermarket_woocommerce_product_thumbnails_columns', 1 );
}
add_filter( 'woocommerce_product_thumbnails_columns', __NAMESPACE__ . '\product_thumbnails_columns' );

/**
 * Customize breadcrumbs default arguments.
 *
 * @since     2.0.0
 * @param     array $defaults    The breadcrumb defaults.
 * @return    array
 */
function breadcrumb_defaults( array $defaults ): array {
	$defaults['delimiter']   = '<span class="breadcrumb-separator"> / </span>';
	$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
	$defaults['wrap_after']  = '</nav>';
	$defaults                = apply_filters( 'hypermarket_woocommerce_breadcrumb_defaults', $defaults );

	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', __NAMESPACE__ . '\breadcrumb_defaults' );

/**
 * Customize single product image carousel options.
 *
 * @since     2.0.0
 * @param     array $options    The current flexslider options.
 * @return    array
 */
function single_product_carousel_options( array $options ): array {
	$options['smoothHeight'] = false;
	$options['animation']    = 'fade';
	$options['useCSS']       = is_rtl();
	$options                 = apply_filters( 'hypermarket_woocommerce_single_product_carousel_options', $options );

	return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', __NAMESPACE__ . '\single_product_carousel_options' );

/**
 * Modifies pagination for shop archive pages.
 *
 * @since     2.0.0
 * @param     array $args    The current pagination arguments.
 * @return    array
 */
function pagination_args( array $args ): array {
	/* translators: 1: Open span tag, 2: Close span tag. */
	$args['next_text'] = apply_filters( 'hypermarket_paging_next_text', sprintf( esc_html_x( '%1$sNext%2$s', 'Next post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) );
	/* translators: 1: Open span tag, 2: Close span tag. */
	$args['prev_text'] = apply_filters( 'hypermarket_paging_prev_text', sprintf( esc_html_x( '%1$sPrev%2$s', 'Previous post', 'hypermarket' ), '<span class="screen-reader-text">', '</span>' ) );

	return apply_filters( 'hypermarket_woocommerce_pagination_args', $args );
}
add_filter( 'woocommerce_pagination_args', __NAMESPACE__ . '\pagination_args' );

/**
 * Appends tooltip content attribute to the link.
 * Only append when viewing the cart page.
 *
 * @since     2.0.0
 * @param     string $link    HTML anchor tag.
 * @return    string
 */
function remove_link( string $link ): string {
	/* translators: 1: Tooltip attribute, 2: Closing anchor tag. */
	$link = is_cart() ? str_replace( '">', sprintf( esc_html__( '%1$sRemove%2$s', 'hypermarket' ), '" data-tippy-content="', '">' ), $link ) : $link;
	return $link;
}
add_filter( 'woocommerce_cart_item_remove_link', __NAMESPACE__ . '\remove_link' );

/**
 * Overwrite "Place Order" button text on checkout page.
 *
 * @since     2.0.0
 * @return    string
 */
function order_button_text(): string {
	$text = apply_filters( 'hypermarket_woocommerce_order_button_text', esc_html_x( 'Checkout', 'place order button', 'hypermarket' ) );
	return $text;
}
add_filter( 'woocommerce_order_button_text', __NAMESPACE__ . '\order_button_text' );

/**
 * Update default user gravatar size.
 *
 * @since     2.0.0
 * @return    int
 */
function review_gravatar_size(): int {
	$size = apply_filters( 'hypermarket_woocommerce_review_gravatar_size', 80 ); 
	return $size;
}
add_filter( 'woocommerce_review_gravatar_size', __NAMESPACE__ . '\review_gravatar_size' );

/**
 * Adds a span around review counts in single product tab.
 *
 * @since     2.0.0
 * @param     string $title    HTML markup of the review tab title.
 * @return    string
 */
function reviews_tab_title( string $title ): string {
	$title = str_replace( array( '(', ')' ), array( '<sup class="count">', '</sup>' ), $title );
	return $title;
}
add_filter( 'woocommerce_product_reviews_tab_title', __NAMESPACE__ . '\reviews_tab_title' );

/**
 * Removes parentheses from the subcategory count.
 *
 * @since     2.0.0
 * @param     string $html    HTML markup of the subcategory count.
 * @return    string
 */
function subcategory_count_html( string $html ): string {
	$html = str_replace( array( '(', ')' ), '', $html );
	return $html;
}
add_filter( 'woocommerce_subcategory_count_html', __NAMESPACE__ . '\subcategory_count_html' );

/**
 * This hook will remove the default WooCommerce stylesheet and enqueuing Hypermarket 
 * specific static resources to protect your site during WooCommerce core updates.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
