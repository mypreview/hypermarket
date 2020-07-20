<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link        https://codex.wordpress.org/Creating_an_Error_404_Page
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

get_header(); 

?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="error-404 not-found">
				<div class="page-content">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'hypermarket' ); ?></h1>
					</header><!-- .page-header -->
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'hypermarket' ); ?></p>
					<section aria-label="<?php esc_html_e( 'Search', 'hypermarket' ); ?>"><?php get_search_form(); ?></section></div><!-- .page-content -->
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

get_footer();
