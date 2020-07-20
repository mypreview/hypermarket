<?php
/**
 * Hypermarket WooCommerce hooks
 *
 * @since       2.0.0
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/**
 * Layout
 *
 * @see  hypermarket_before_content()
 * @see  hypermarket_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  hypermarket_shop_messages()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_main_content', 'hypermarket_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'hypermarket_after_content', 10 );
add_action( 'hypermarket_content_top', 'hypermarket_shop_messages', 15 );
add_action( 'hypermarket_before_content', 'woocommerce_breadcrumb', 10 );
add_action( 'woocommerce_after_shop_loop', 'hypermarket_sorting_wrapper', 9 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
add_action( 'woocommerce_after_shop_loop', 'hypermarket_sorting_wrapper_close', 31 );
add_action( 'woocommerce_before_shop_loop', 'hypermarket_sorting_wrapper', 9 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'hypermarket_woocommerce_pagination', 30 );
add_action( 'woocommerce_before_shop_loop', 'hypermarket_sorting_wrapper_close', 31 );
add_action( 'hypermarket_footer', 'hypermarket_handheld_footer_bar', 999 );

/**
 * Products
 *
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_upsell_display()
 * @see  hypermarket_single_product_pagination()
 * @see  hypermarket_sticky_single_add_to_cart()
 * @see  hypermarket_quantity_minus_btn()
 * @see  hypermarket_quantity_plus_btn()
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_edit_post_link', 60 );

add_action( 'woocommerce_after_single_product_summary', 'hypermarket_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_single_product_pagination', 30 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
add_action( 'hypermarket_after_footer', 'hypermarket_sticky_single_add_to_cart', 999 );
add_action( 'woocommerce_before_quantity_input_field', 'hypermarket_quantity_minus_btn', 10 );
add_action( 'woocommerce_after_quantity_input_field', 'hypermarket_quantity_plus_btn', 10 );

/**
 * Header
 *
 * @see  hypermarket_header_cart()
 */
add_action( 'hypermarket_header', 'hypermarket_header_cart', 30 );

/**
 * Cart fragment
 *
 * @see  hypermarket_cart_link_fragment()
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'hypermarket_cart_link_fragment' );
