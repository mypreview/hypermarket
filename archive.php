<?php
/**
 * The template for displaying archive pages.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
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
		
		/**
		 * Functions hooked into `hypermarket_archive_top` action
		 *
		 * @hooked  hypermarket_div                 - 5
		 * @hooked  hypermarket_archive_header      - 10
		 * @hooked  hypermarket_breadcrumb          - 20
		 * @hooked  hypermarket_div_close           - 25
		 */
		do_action( 'hypermarket_archive_top' );

		if ( have_posts() ) :
			get_template_part( 'loop' );
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		
		do_action( 'hypermarket_archive_bottom' );

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
