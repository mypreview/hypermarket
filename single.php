<?php
/**
 * The template for displaying all single posts.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

get_header(); 

?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		
		while ( have_posts() ) :
			the_post();

			do_action( 'hypermarket_single_post_before' );

			get_template_part( 'template-parts/content', 'single' );

			/**
			 * Functions hooked into `hypermarket_single_post_after` add_action
			 *
			 * @hooked hypermarket_related_posts        - 10
			 */
			do_action( 'hypermarket_single_post_after' );
		endwhile; // End of the loop.
		
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

/**
 * Functions hooked into `hypermarket_sidebar` action
 *
 * @hooked  hypermarket_get_sidebar         - 10
 */
do_action( 'hypermarket_sidebar' );

get_footer();
