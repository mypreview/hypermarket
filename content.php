<?php
/**
 * Template part for displaying post content.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

	/**
	 * Functions hooked in to `hypermarket_loop_post` action.
	 *
	 * @hooked hypermarket_post_header          - 10
	 * @hooked hypermarket_post_content         - 30
	 */
	do_action( 'hypermarket_loop_post' );

?></article><!-- #post-## -->