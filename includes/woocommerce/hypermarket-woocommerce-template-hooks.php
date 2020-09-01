<?php
/**
 * Hypermarket WooCommerce hooks
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/woocommerce
 */

/**
 * Header
 *
 * @see  hypermarket_div()
 * @see  hypermarket_myaccount_link()
 * @see  hypermarket_cart()
 * @see  hypermarket_div_close()
 */
add_action( 'hypermarket_header', 'hypermarket_div', 25 );
add_action( 'hypermarket_header', 'hypermarket_myaccount_link', 30 );
add_action( 'hypermarket_header', 'hypermarket_cart', 40 );
add_action( 'hypermarket_header', 'hypermarket_div_close', 45 );

/**
 * Footer
 *
 * @see  hypermarket_handheld_toolbar()
 */
add_action( 'hypermarket_after_footer', 'hypermarket_handheld_toolbar', PHP_INT_MAX );

/**
 * Content
 *
 * @see  hypermarket_breadcrumb()
 * @see  hypermarket_shop_messages()
 */
add_action( 'hypermarket_before_content', 'hypermarket_breadcrumb' );
add_action( 'hypermarket_content_top', 'hypermarket_shop_messages' );

/**
 * Layout
 *
 * @see  hypermarket_before_content()
 * @see  hypermarket_after_content()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_main_content', 'hypermarket_before_content' );
add_action( 'woocommerce_after_main_content', 'hypermarket_after_content' );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );

/**
 * Products
 *
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_quantity_minus_btn()
 * @see  hypermarket_quantity_plus_btn()
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_edit_post_link', 60 );
add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_template_single_price' );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 12 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
add_action( 'woocommerce_after_shop_loop_item_title', 'hypermarket_product_loop_sold_out_flash', 6 );
add_action( 'woocommerce_after_shop_loop_item', 'hypermarket_div', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 8 );
add_action( 'woocommerce_after_shop_loop_item', 'hypermarket_div_close', 11 );
add_action( 'woocommerce_before_quantity_input_field', 'hypermarket_quantity_minus_btn' );
add_action( 'woocommerce_after_quantity_input_field', 'hypermarket_quantity_plus_btn' );


/**
 * Cart fragment
 *
 * @see  hypermarket_cart_link_fragment()
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'hypermarket_cart_link_fragment' );
