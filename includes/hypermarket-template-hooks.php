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
 * @see  hypermarket_handheld_menu()
 */
add_action( 'hypermarket_header', 'hypermarket_skip_links', 5 );
add_action( 'hypermarket_header', 'hypermarket_site_branding' );
add_action( 'hypermarket_header', 'hypermarket_primary_menu', 20 );
add_action( 'hypermarket_header', 'hypermarket_handheld_menu', 50 );

/**
 * Footer
 *
 * @see  hypermarket_get_footer_bar()
 * @see  hypermarket_footer_widgets()
 * @see  hypermarket_credit()
 */
add_action( 'hypermarket_before_footer', 'hypermarket_get_footer_bar' );
add_action( 'hypermarket_footer', 'hypermarket_footer_widgets' );
add_action( 'hypermarket_footer', 'hypermarket_credit', 20 );

/**
 * Content
 *
 * @see  hypermarket_container()
 * @see  hypermarket_div_close()
 * @see  hypermarket_jscroll()
 * @see  hypermarket_jscroll_close()
 */
add_action( 'hypermarket_content_top', 'hypermarket_container', 5 );
add_action( 'hypermarket_content_bottom', 'hypermarket_div_close', 5 );
add_action( 'hypermarket_before_loop', 'hypermarket_jscroll' );
add_action( 'hypermarket_after_loop', 'hypermarket_jscroll_close' );

/**
 * Sidebar
 * 
 * @see  hypermarket_get_sidebar()
 */
add_action( 'hypermarket_sidebar', 'hypermarket_get_sidebar' );

/**
 * Posts
 *
 * @see  hypermarket_post_thumbnail()
 * @see  hypermarket_post_header()
 * @see  hypermarket_paging_nav()
 * @see  hypermarket_post_header()
 * @see  hypermarket_post_meta()
 * @see  hypermarket_post_content()
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_post_footnote()
 * @see  hypermarket_post_nav()
 * @see  hypermarket_display_comments()
 * @see  hypermarket_post_excerpt()
 */
add_action( 'hypermarket_loop_post', 'hypermarket_div', 5 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_header' );
add_action( 'hypermarket_loop_post', 'hypermarket_post_meta', 20 );
add_action( 'hypermarket_loop_post', 'hypermarket_div_close', 25 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_thumbnail', 30 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_excerpt', 40 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_footnote', 50 );
add_action( 'hypermarket_loop_after', 'hypermarket_paging_nav' );
add_action( 'hypermarket_single_post_top', 'hypermarket_div', 5 );
add_action( 'hypermarket_single_post_top', 'hypermarket_post_header' );
add_action( 'hypermarket_single_post_top', 'hypermarket_div_close', 25 );
add_action( 'hypermarket_single_post', 'hypermarket_post_meta' );
add_action( 'hypermarket_single_post', 'hypermarket_post_thumbnail', 20 );
add_action( 'hypermarket_single_post', 'hypermarket_post_content', 30 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_edit_post_link' );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_post_footnote', 20 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_post_nav', 30 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_display_comments', 40 );

/**
 * Pages
 *
 * @see  hypermarket_div()
 * @see  hypermarket_post_thumbnail()
 * @see  hypermarket_page_header()
 * @see  hypermarket_div_close()
 * @see  hypermarket_page_content()
 * @see  hypermarket_edit_post_link()
 * @see  hypermarket_paging_nav()
 * @see  hypermarket_display_comments()
 */
add_action( 'hypermarket_page_top', 'hypermarket_div', 5 );
add_action( 'hypermarket_page_top', 'hypermarket_page_header' );
add_action( 'hypermarket_page_top', 'hypermarket_div_close', 25 );
add_action( 'hypermarket_page', 'hypermarket_post_thumbnail' );
add_action( 'hypermarket_page', 'hypermarket_page_content', 20 );
add_action( 'hypermarket_page_bottom', 'hypermarket_edit_post_link' );
add_action( 'hypermarket_page_bottom', 'hypermarket_paging_nav', 20 );
add_action( 'hypermarket_page_bottom', 'hypermarket_display_comments', 30 );

/**
 * Blog
 * 
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 * @see  hypermarket_posts_page_header()
 */
add_action( 'hypermarket_home_top', 'hypermarket_div', 5 );
add_action( 'hypermarket_home_top', 'hypermarket_posts_page_header' );
add_action( 'hypermarket_home_top', 'hypermarket_div_close', 25 );

/**
 * Archive
 *
 * @see  hypermarket_div()
 * @see  hypermarket_div_close()
 * @see  hypermarket_archive_header()
 */
add_action( 'hypermarket_archive_top', 'hypermarket_div', 5 );
add_action( 'hypermarket_archive_top', 'hypermarket_archive_header' );
add_action( 'hypermarket_archive_top', 'hypermarket_div_close', 25 );

/**
 * Widgets
 *
 * @see hypermarket_tag_cloud_args()
 */
add_filter( 'widget_tag_cloud_args', 'hypermarket_tag_cloud_args' );

/**
 * Customize
 *
 * @see  hypermarket_customize_more_section()
 */
add_action( 'hypermarket_customize_register_controls', 'hypermarket_customize_more_section' );
