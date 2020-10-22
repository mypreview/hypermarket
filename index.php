<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being `style.css`).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 */

get_header(); 

?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php

				/**
				 * Functions hooked into `hypermarket_home_top` action
				 *
				 * @hooked  hypermarket_div                    - 5
				 * @hooked  hypermarket_posts_page_header      - 10
				 * @hooked  hypermarket_breadcrumb             - 20
				 * @hooked  hypermarket_div_close              - 25
				 */
				do_action( 'hypermarket_home_top' );

			?>
			<div class="entry-wrapper">
				<?php
				
				/**
				 * Functions hooked into `hypermarket_before_loop` action
				 *
				 * @hooked  hypermarket_jscroll           	   - 10
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
			 * @hooked  hypermarket_get_sidebar          	  - 10
			 */
			do_action( 'hypermarket_sidebar' );

			do_action( 'hypermarket_home_bottom' );

			?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

get_footer();
