<?php
/**
 * Template part for displaying post content.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 * @subpackage  hypermarket/template-parts
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class( 'single-view' ); ?>>
	<?php

		do_action( 'hypermarket_single_post_top' );

		/**
		 * Functions hooked into `hypermarket_single_post` add_action
		 *
		 * @hooked hypermarket_div                    - 5
		 * @hooked hypermarket_post_header            - 10
		 * @hooked hypermarket_breadcrumb             - 20
		 * @hooked hypermarket_div_close              - 25
		 * @hooked hypermarket_post_meta              - 20
		 * @hooked hypermarket_post_thumbnail         - 30
		 * @hooked hypermarket_post_content           - 40
		 */
		do_action( 'hypermarket_single_post' );

		/**
		 * Functions hooked in to `hypermarket_single_post_bottom` action
		 *
		 * @hooked hypermarket_edit_post_link         - 10
		 * @hooked hypermarket_post_footnote          - 20
		 * @hooked hypermarket_post_nav               - 30
		 * @hooked hypermarket_display_comments       - 40
		 */
		do_action( 'hypermarket_single_post_bottom' );

	?>
</article><!-- #post-## -->
