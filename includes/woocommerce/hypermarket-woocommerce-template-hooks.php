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
 * @see  hypermarket_single_sticky_add_to_cart()
 * @see  hypermarket_handheld_toolbar()
 */
add_action( 'hypermarket_after_footer', 'hypermarket_single_sticky_add_to_cart' );
add_action( 'hypermarket_after_footer', 'hypermarket_handheld_toolbar', 99 );

/**
 * Content
 *
 * @see  hypermarket_shop_messages()
 */
add_action( 'hypermarket_page_top', 'hypermarket_shop_messages', 30 );

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
add_action( 'woocommerce_before_main_content', 'hypermarket_before_content' );
add_action( 'woocommerce_after_main_content', 'hypermarket_after_content' );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );

/**
 * Breadcrumbs
 * 
 * @see  hypermarket_breadcrumb()
 */
add_action( 'hypermarket_single_post_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_page_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_home_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_archive_top', 'hypermarket_breadcrumb', 20 );

/**
 * My-account
 * 
 * @see  hypermarket_div()
 * @see  hypermarket_myaccount_user_info()
 * @see  hypermarket_div_close()
 */
add_action( 'woocommerce_before_account_navigation', 'hypermarket_div' );
add_action( 'woocommerce_before_account_navigation', 'hypermarket_myaccount_user_info', 20 );
add_action( 'woocommerce_after_account_navigation', 'hypermarket_div_close' );

/**
 * Layout
 *
 * @see  hypermarket_quantity_minus_btn()
 * @see  hypermarket_quantity_plus_btn()
 */
add_action( 'woocommerce_before_quantity_input_field', 'hypermarket_quantity_minus_btn' );
add_action( 'woocommerce_after_quantity_input_field', 'hypermarket_quantity_plus_btn' );

/**
 * Shop (Archive)
 *
 * @see  hypermarket_product_image_flipper()
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'hypermarket_product_image_flipper', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 25 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

/**
 * Single product
 *
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_single_product_share()
 * @see  hypermarket_single_product_pagination()
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 */
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_edit_post_link', 60 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 7 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_div', 8 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 9 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_div_close', 15 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_single_product_share', 50 );
add_action( 'woocommerce_single_product_summary', 'hypermarket_single_product_pagination', 99 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div', 0 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 5 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div', 7 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div_close', 25 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_div_close', 5 );

/**
 * Cart
 *
 * @see  hypermarket_cart_link_fragment()
 * @see  hypermarket_cart_update_button()
 * @see  hypermarket_button_proceed_to_checkout()
 */
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_filter( 'woocommerce_add_to_cart_fragments', 'hypermarket_cart_link_fragment' );
add_action( 'woocommerce_proceed_to_checkout', 'hypermarket_cart_update_button' );
add_action( 'woocommerce_proceed_to_checkout', 'hypermarket_button_proceed_to_checkout', 20 );

/**
 * Checkout
 *
 * @see  hypermarket_button_back_to_cart()
 */
add_action( 'woocommerce_review_order_before_submit', 'hypermarket_button_back_to_cart' );
