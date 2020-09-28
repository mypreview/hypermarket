<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the `#content` div and all content after.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */ 
	
				/**
				 * Functions hooked in to `hypermarket_content_bottom` action
				 *
				 * @hooked hypermarket_div_close      - 5
				 */
				do_action( 'hypermarket_content_bottom' ); ?>
			</div><!-- #content -->

			<?php 
				/**
				 * Functions hooked in to `hypermarket_before_footer` action
				 *
				 * @hooked hypermarket_get_footer_bar      - 10
				 */
				do_action( 'hypermarket_before_footer' ); 
			?>

			<footer id="colophon" class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<?php
					/**
					 * Functions hooked in to `hypermarket_footer` action
					 *
					 * @hooked hypermarket_footer_widgets      - 10
					 * @hooked hypermarket_credit              - 20
					 */
					do_action( 'hypermarket_footer' );
				?>
			</footer><!-- #colophon -->

			<?php 
				/**
				 * Functions hooked in to `hypermarket_after_footer` action
				 *
				 * @hooked hypermarket_sticky_single_add_to_cart      - 10
				 * @hooked hypermarket_handheld_toolbar               - 99
				 */
				do_action( 'hypermarket_after_footer' ); 
			?>
		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>
</html>
