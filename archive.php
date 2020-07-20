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
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php

				get_template_part( 'loop' );
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;

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
