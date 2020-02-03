<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link 		https://codex.wordpress.org/Creating_an_Error_404_Page
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
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

					<section aria-label="<?php esc_html_e( 'Search', 'hypermarket' ); ?>"><?php

						if ( hypermarket_is_woocommerce_activated() ) {
							the_widget( 'WC_Widget_Product_Search' );
						} else {
							get_search_form();
						} // End If Statement

					?></section><?php

					if ( hypermarket_is_woocommerce_activated() ) :

						?><div class="columns-2">
							<section class="col-1" aria-label="<?php esc_html_e( 'Promoted Products', 'hypermarket' ); ?>"><?php

								hypermarket_promoted_products();

							?></section>
							<nav class="col-2" aria-label="<?php esc_html_e( 'Product Categories', 'hypermarket' ); ?>">
								<h2><?php esc_html_e( 'Product Categories', 'hypermarket' ); ?></h2><?php

								the_widget(
									'WC_Widget_Product_Categories', array(
										'count' => 1
									)
								);

							?></nav>
						</div>
						<section aria-label="<?php esc_html_e( 'Popular Products', 'hypermarket' ); ?>">
							<h2><?php esc_html_e( 'Popular Products', 'hypermarket' ); ?></h2><?php

							$shortcode_content = hypermarket_do_shortcode(
								'best_selling_products', array(
									'per_page' => 4,
									'columns'  => 4
								)
							);

							echo $shortcode_content; // WPCS: XSS ok.

						?></section><?php

					endif; // End hypermarket_is_woocommerce_activated();

				?></div><!-- .page-content -->
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();