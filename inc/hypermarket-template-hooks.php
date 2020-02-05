<?php
/**
 * Hypermarket hooks
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

/**
 * General
 *
 * @see  hypermarket_get_sidebar()
 */
add_action( 'hypermarket_sidebar', 'hypermarket_get_sidebar', 10 );

/**
 * Header
 *
 * @see  hypermarket_container()
 * @see  hypermarket_skip_links()
 * @see  hypermarket_site_branding()
 * @see  hypermarket_primary_navigation()
 * @see  hypermarket_container_close()
 */
add_action( 'hypermarket_header', 'hypermarket_container', 0 );
add_action( 'hypermarket_header', 'hypermarket_skip_links', 5 );
add_action( 'hypermarket_header', 'hypermarket_site_branding', 10 );
add_action( 'hypermarket_header', 'hypermarket_primary_navigation', 20 );
add_action( 'hypermarket_header', 'hypermarket_container_close', 35 );

/**
 * Footer
 *
 * @see  hypermarket_container()
 * @see  hypermarket_footer_widgets()
 * @see  hypermarket_credit()
 * @see  hypermarket_container_close()
 */
add_action( 'hypermarket_footer', 'hypermarket_container', 5 );
add_action( 'hypermarket_footer', 'hypermarket_footer_widgets', 10 );
add_action( 'hypermarket_footer', 'hypermarket_credit', 20 );
add_action( 'hypermarket_footer', 'hypermarket_container_close', 25 );

/**
 * Content
 *
 * @see  hypermarket_container()
 * @see  hypermarket_container_close()
 */
add_action( 'hypermarket_content_top', 'hypermarket_container', 5 );
add_action( 'hypermarket_content_bottom', 'hypermarket_container_close', 5 );

/**
 * Posts
 *
 * @see  hypermarket_post_header()
 * @see  hypermarket_post_meta()
 * @see  hypermarket_post_content()
 * @see  hypermarket_paging_nav()
 * @see  hypermarket_single_post_header()
 * @see  hypermarket_post_nav()
 * @see  hypermarket_display_comments()
 */
add_action( 'hypermarket_loop_post', 'hypermarket_post_header', 10 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_content', 30 );
add_action( 'hypermarket_loop_post', 'hypermarket_post_taxonomy', 40 );
add_action( 'hypermarket_loop_after', 'hypermarket_paging_nav', 10 );
add_action( 'hypermarket_single_post', 'hypermarket_post_header', 10 );
add_action( 'hypermarket_single_post', 'hypermarket_post_content', 30 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_edit_post_link', 5 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_post_taxonomy', 5 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_post_nav', 10 );
add_action( 'hypermarket_single_post_bottom', 'hypermarket_display_comments', 20 );
add_action( 'hypermarket_post_header_before', 'hypermarket_post_meta', 10 );
add_action( 'hypermarket_post_content_before', 'hypermarket_post_thumbnail', 10 );

/**
 * Pages
 *
 * @see  hypermarket_page_header()
 * @see  hypermarket_page_content()
 * @see  hypermarket_display_comments()
 */
add_action( 'hypermarket_page', 'hypermarket_page_header', 10 );
add_action( 'hypermarket_page', 'hypermarket_page_content', 20 );
add_action( 'hypermarket_page', 'hypermarket_edit_post_link', 30 );
add_action( 'hypermarket_page_after', 'hypermarket_display_comments', 10 );