<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other 'pages' on your 
 * WordPress site may use a different template.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

get_header(); 

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php
		
			while ( have_posts() ) :
				the_post();

				do_action( 'hypermarket_page_before' );

				get_template_part( 'template-parts/content', 'page' );

				/**
				 * Functions hooked in to `hypermarket_page_after` action
				 *
				 * @hooked hypermarket_display_comments		   - 10
				 */
				do_action( 'hypermarket_page_after' );

			endwhile; // End of the loop.
		
		?></main><!-- #main -->
	</div><!-- #primary --><?php

	do_action( 'hypermarket_sidebar' );

get_footer();