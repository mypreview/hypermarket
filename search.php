<?php
/**
 * The template for displaying search results pages.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
				 * Functions hooked into `hypermarket_search_top` action
				 *
				 * @hooked  hypermarket_div                    - 5
				 * @hooked  hypermarket_search_page_header     - 10
				 * @hooked  hypermarket_breadcrumb             - 20
				 * @hooked  hypermarket_div_close              - 25
				 */
				do_action( 'hypermarket_search_top' );

			?>
			<div class="entry-wrapper">
				<?php
				
				/**
				 * Functions hooked into `hypermarket_before_loop` action
				 *
				 * @hooked  hypermarket_jscroll                - 10
				 */
				do_action( 'hypermarket_before_loop' );
				
				if ( have_posts() ) :
					get_template_part( 'loop' );
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				
				/**
				 * Functions hooked into `hypermarket_after_loop` action
				 *
				 * @hooked  hypermarket_jscroll_close          - 10
				 */
				do_action( 'hypermarket_after_loop' );

				?>
			</div>
			<?php

			/**
			 * Functions hooked into `hypermarket_sidebar` action
			 *
			 * @hooked  hypermarket_get_sidebar               - 10
			 */
			do_action( 'hypermarket_sidebar' );

			do_action( 'hypermarket_search_bottom' );

			?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

get_footer();
