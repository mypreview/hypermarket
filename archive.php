<?php
/**
 * The template for displaying archive pages
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

get_header(); 

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php 

			if ( have_posts() ) : 
				
				?><header class="page-header"><?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?></header><!-- .page-header --><?php

				get_template_part( 'loop' );
			else :
				get_template_part( 'content', 'none' );
			endif;

		?></main><!-- #main -->
	</div><!-- #primary --><?php

	do_action( 'hypermarket_sidebar' );

get_footer();