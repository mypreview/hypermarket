<?php
/**
 * Hypermarket WooCommerce hooks
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
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
 * @see  hypermarket_container()
 * @see  hypermarket_div_close()
 * @see  hypermarket_handheld_toolbar()
 */
add_action( 'hypermarket_after_footer', 'hypermarket_single_sticky_add_to_cart' );
add_actioN( 'hypermarket_single_before_sticky_add_to_cart', 'hypermarket_container' );
add_actioN( 'hypermarket_single_after_sticky_add_to_cart', 'hypermarket_div_close' );
add_action( 'hypermarket_after_footer', 'hypermarket_handheld_toolbar', 99 );

/**
 * Pages
 *
 * @see  hypermarket_shop_messages()
 */
add_action( 'hypermarket_page', 'hypermarket_shop_messages', 0 );

/**
 * No products found
 *
 * @see  hypermarket_wrapper()
 * @see  hypermarket_div_close()
 * @see  woocommerce_get_sidebar()
 */
add_action( 'woocommerce_no_products_found', 'hypermarket_wrapper', 5 );
add_action( 'woocommerce_no_products_found', 'hypermarket_div_close', 15 );
add_action( 'woocommerce_no_products_found', 'woocommerce_get_sidebar', 30 );

/**
 * Layout
 *
 * @see  hypermarket_before_content()
 * @see  hypermarket_after_content()
 * @see  hypermarket_quantity_minus_btn()
 * @see  hypermarket_quantity_plus_btn()
 * @see  hypermarket_woocommerce_pagination()
 * @see  hypermarket_jscroll()
 * @see  hypermarket_jscroll_close()
 * @see  hypermarket_wrapper()
 * @see  hypermarket_div_close()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
add_action( 'woocommerce_before_shop_loop', 'hypermarket_wrapper', 5 );
add_action( 'woocommerce_before_shop_loop', 'hypermarket_jscroll', 40 );
add_action( 'woocommerce_before_main_content', 'hypermarket_before_content' );
add_action( 'woocommerce_after_main_content', 'hypermarket_after_content' );
add_action( 'woocommerce_after_shop_loop', 'hypermarket_woocommerce_pagination', 30 );
add_action( 'woocommerce_after_shop_loop', 'hypermarket_jscroll_close', 40 );
add_action( 'woocommerce_after_shop_loop', 'hypermarket_div_close', 45 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_get_sidebar', 50 );
add_action( 'woocommerce_before_quantity_input_field', 'hypermarket_quantity_minus_btn' );
add_action( 'woocommerce_after_quantity_input_field', 'hypermarket_quantity_plus_btn' );

/**
 * Breadcrumbs
 * 
 * @see  hypermarket_breadcrumb()
 */
add_action( 'hypermarket_single_post_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_page_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_home_top', 'hypermarket_breadcrumb', 20 );
add_action( 'hypermarket_archive_top', 'hypermarket_breadcrumb', 20 );
add_action( 'woocommerce_archive_description', 'hypermarket_breadcrumb', 20 );

/**
 * My-account
 * 
 * @see  hypermarket_myaccount_user_info()
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 */
add_action( 'woocommerce_before_account_navigation', 'hypermarket_div' );
add_action( 'woocommerce_before_account_navigation', 'hypermarket_myaccount_user_info', 20 );
add_action( 'woocommerce_after_account_navigation', 'hypermarket_div_close' );

/**
 * Loop item
 *
 * @see  hypermarket_product_new_flash()
 * @see  hypermarket_product_featured_flash()
 * @see  hypermarket_product_image_flipper()
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'hypermarket_product_new_flash', 9 );
add_action( 'woocommerce_before_shop_loop_item_title', 'hypermarket_product_featured_flash', 9 );
add_action( 'woocommerce_before_shop_loop_item_title', 'hypermarket_product_image_flipper', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 25 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_action( 'woocommerce_after_shop_loop_item_title', 'hypermarket_product_categories', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 'hypermarket_product_stock_status', 30 );
add_action( 'woocommerce_after_shop_loop_item', 'hypermarket_div', 6 );
add_action( 'woocommerce_after_shop_loop_item', 'hypermarket_div_close', 20 );

/**
 * Single product
 *
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_product_new_flash()
 * @see  hypermarket_product_featured_flash()
 * @see  hypermarket_single_product_share()
 * @see  hypermarket_single_product_navigation()
 * @see  hypermarket_div()
 * @see  hypermarket_products_flkty_div()
 * @see  hypermarket_products_flkty_div_close()
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
add_action( 'woocommerce_single_product_summary', 'hypermarket_single_product_navigation', 99 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div', 0 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 5 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div', 7 );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_product_new_flash' );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_product_featured_flash' );
add_action( 'woocommerce_before_single_product_summary', 'hypermarket_div_close', 25 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_div_close', 5 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_wrapper', 7 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_products_flkty_div', 12 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_products_flkty_div_close', 18 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_products_flkty_div', 18 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_products_flkty_div_close', 25 );
add_action( 'woocommerce_after_single_product_summary', 'hypermarket_div_close', 30 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_get_sidebar', 40 );

/**
 * Cart
 *
 * @see  hypermarket_cart_link_fragment()
 * @see  hypermarket_cart_update_button()
 * @see  hypermarket_button_proceed_to_checkout()
 * @see  hypermarket_products_flkty_div()
 * @see  hypermarket_products_flkty_div_close()
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
add_filter( 'woocommerce_add_to_cart_fragments', 'hypermarket_cart_link_fragment' );
add_action( 'woocommerce_proceed_to_checkout', 'hypermarket_cart_update_button' );
add_action( 'woocommerce_proceed_to_checkout', 'hypermarket_button_proceed_to_checkout', 20 );
add_action( 'woocommerce_after_cart', 'hypermarket_products_flkty_div', 5 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'hypermarket_products_flkty_div_close', 15 );

/**
 * Checkout
 *
 * @see  hypermarket_button_back_to_cart()
 */
add_action( 'woocommerce_review_order_before_submit', 'hypermarket_button_back_to_cart' );

/**
 * Widgets
 *
 * @see hypermarket_tag_cloud_args()
 */
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'hypermarket_tag_cloud_args' );
