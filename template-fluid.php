<?php
/**
 * The template for displaying fluid width pages and possibly other post types as well.
 *
 * Template Name:       Fluid Template
 * Template Post Type:  post, page, product
 *
 * @link        https://developer.wordpress.org/themes/template-files-section/page-template-files/
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

		if ( hypermarket_is_woocommerce_activated() && is_singular( 'product' ) ) :
			woocommerce_content();
		else :
			while ( have_posts() ) :
				the_post();

				do_action( 'hypermarket_page_before' );

				get_template_part( 'template-parts/content', 'page' );

				/**
				 * Functions hooked in to `hypermarket_page_after` action
				 *
				 * @hooked hypermarket_display_comments       - 10
				 */
				do_action( 'hypermarket_page_after' );
			endwhile; // End of the loop.
		endif;
		
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

get_footer();
