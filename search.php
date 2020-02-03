<?php
/**
 * The template for displaying search results pages.
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

get_header(); 

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php 

		if ( have_posts() ) : 

			?><header class="page-header">
				<h1 class="page-title"><?php
					/* translators: %s: search term */
					printf( esc_attr__( 'Search Results for: %s', 'hypermarket' ), sprintf( '<span>%s</span>', get_search_query() ) );
				?></h1>
			</header><!-- .page-header --><?php

			get_template_part( 'loop' );
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		
		?></main><!-- #main -->
	</div><!-- #primary --><?php

	do_action( 'hypermarket_sidebar' );

get_footer();