<?php
/**
 * Template part for displaying page content in `page.php`
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

	/**
	 * Functions hooked in to `hypermarket_page` add_action
	 *
	 * @hooked hypermarket_page_header          - 10
	 * @hooked hypermarket_page_content         - 20
	 */
	do_action( 'hypermarket_page' );

?></article><!-- #post-## -->