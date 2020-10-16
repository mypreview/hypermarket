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
			<?php

				/**
				 * Functions hooked into `hypermarket_notfound_top` action
				 *
				 * @hooked  hypermarket_div                    - 5
				 * @hooked  hypermarket_notfound_header        - 10
				 * @hooked  hypermarket_div_close              - 15
				 */
				do_action( 'hypermarket_notfound_top' );

			?>
			<div class="entry-wrapper">
				<div class="error-404-widgets row-1 col-2">
					<div class="block error-404-widget">
						<?php 
						if ( hypermarket_is_woocommerce_activated() ) {
							hypermarket_promoted_products( '6', '2' );
						} else {
							the_widget( 'WP_Widget_Recent_Posts', array( 'title' => esc_html__( 'Recent Posts', 'hypermarket' ) ) );
						}
						?>
					</div>
					<div class="block error-404-widget">
						<?php 
						if ( hypermarket_is_woocommerce_activated() ) {
							the_widget(
								'WC_Widget_Product_Categories',
								array(
									'count' => 1,
									'title' => esc_html__(
										'Product Categories',
										'hypermarket' 
									),
								) 
							);
						} else {
							the_widget(
								'WP_Widget_Categories',
								array(
									'count' => 1,
									'title' => esc_html__(
										'Post Categories',
										'hypermarket' 
									),
								) 
							);
						}
						?>
					</div>
				</div>
				<?php if ( hypermarket_is_woocommerce_activated() ) : ?>
					<div class="error-404-widgets row-2 col-1">
						<div class="block error-404-widget">
							<?php
							/* translators: 1: Open h2 tag, Close h2 tag. */
							printf( esc_html__( '%1$sBest-Selling Products%2$s', 'hypermarket' ), '<h2>', '</h2>' );

							//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							echo hypermarket_do_shortcode(
								'best_selling_products',
								array(
									'per_page' => 4,
									'columns'  => 4,
								)
							);
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php do_action( 'hypermarket_notfound_bottom' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php

get_footer();
