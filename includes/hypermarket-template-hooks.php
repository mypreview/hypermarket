<?php
/**
 * Hypermarket hooks.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes
 */

/**
 * Header
 *
 * @see  hypermarket_skip_links()
 * @see  hypermarket_site_branding()
 * @see  hypermarket_primary_menu()
 */
add_action( 'hypermarket_header', 'hypermarket_skip_links', 5 );
add_action( 'hypermarket_header', 'hypermarket_site_branding' );
add_action( 'hypermarket_header', 'hypermarket_primary_menu', 20 );

/**
 * Footer
 *
 * @see  hypermarket_footer_widgets()
 * @see  hypermarket_credit()
 */
add_action( 'hypermarket_footer', 'hypermarket_footer_widgets' );
add_action( 'hypermarket_footer', 'hypermarket_credit', 20 );

/**
 * Content
 *
 * @see  hypermarket_container()
 * @see  hypermarket_div_close()
 */
add_action( 'hypermarket_content_top', 'hypermarket_container', 5 );
add_action( 'hypermarket_content_bottom', 'hypermarket_div_close', 5 );

/**
 * Sidebar
 * 
 * @see  hypermarket_get_sidebar()
 */
add_action( 'hypermarket_sidebar', 'hypermarket_get_sidebar' );

/**
 * Posts
 *
 * @see  hypermarket_div()
 * @see  hypermarket_post_thumbnail()
 * @see  hypermarket_post_header()
 * @see  hypermarket_post_meta()
 * @see  hypermarket_post_content()
 * @see  hypermarket_paging_nav()
 * @see  hypermarket_display_comments()
 * @see  hypermarket_div_close()
 * @see  hypermarket_post_excerpt()
 */
add_action( 'hypermarket_loop_post', 'hypermarket_post_thumbnail', 10, 2 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_header', 20 );
add_action( 'hypermarket_loop_after', 'hypermarket_paging_nav' );
add_action( 'hypermarket_single_post', 'hypermarket_div' );
add_action( 'hypermarket_single_post', 'hypermarket_post_thumbnail', 20, 2 );
add_action( 'hypermarket_single_post', 'hypermarket_post_header', 30 );
add_action( 'hypermarket_single_post', 'hypermarket_div_close', 35 );
add_action( 'hypermarket_single_post', 'hypermarket_post_content', 40 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_edit_post_link' );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_display_comments', 20 );
add_action( 'hypermarket_post_meta', 'hypermarket_post_meta' );
add_action( 'hypermarket_post_meta', 'hypermarket_post_taxonomy', 20 );
add_action( 'hypermarket_post_header_after', 'hypermarket_post_excerpt' );

/**
 * Pages
 *
 * @see  hypermarket_div()
 * @see  hypermarket_post_thumbnail()
 * @see  hypermarket_page_header()
 * @see  hypermarket_div_close()
 * @see  hypermarket_post_content()
 * @see  hypermarket_display_comments()
 */
add_action( 'hypermarket_page', 'hypermarket_div' );
add_action( 'hypermarket_page', 'hypermarket_post_thumbnail', 20, 2 );
add_action( 'hypermarket_page', 'hypermarket_page_header', 30 );
add_action( 'hypermarket_page', 'hypermarket_div_close', 35 );
add_action( 'hypermarket_page', 'hypermarket_page_content', 40 );
add_action( 'hypermarket_page_after', 'hypermarket_display_comments' );
