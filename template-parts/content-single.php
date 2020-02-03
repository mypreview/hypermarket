<?php
/**
 * Template part for displaying posts
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

	do_action( 'hypermarket_single_post_top' );

	/**
	 * Functions hooked into `hypermarket_single_post` add_action
	 *
	 * @hooked hypermarket_post_header           	- 10
	 * @hooked hypermarket_post_content          	- 30
	 */
	do_action( 'hypermarket_single_post' );

	/**
	 * Functions hooked in to `hypermarket_single_post_bottom` action
	 *
	 * @hooked hypermarket_post_nav         		- 10
	 * @hooked hypermarket_display_comments 		- 20
	 */
	do_action( 'hypermarket_single_post_bottom' );

?></article><!-- #post-## -->