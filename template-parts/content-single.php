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

		/**
		 * Functions hooked into `hypermarket_single_post_top` add_action
		 *
		 * @hooked hypermarket_div                    - 5
		 * @hooked hypermarket_post_header            - 10
		 * @hooked hypermarket_breadcrumb             - 20
		 * @hooked hypermarket_div_close              - 25
		 */
		do_action( 'hypermarket_single_post_top', get_the_ID() );

	?>
	<div class="entry-wrapper">
	<?php

		/**
		 * Functions hooked into `hypermarket_single_post` add_action
		 *
		 * @hooked hypermarket_post_meta              - 10
		 * @hooked hypermarket_post_thumbnail         - 20
		 * @hooked hypermarket_post_content           - 30
		 */
		do_action( 'hypermarket_single_post', get_the_ID() );

		/**
		 * Functions hooked in to `hypermarket_single_post_bottom` action
		 *
		 * @hooked hypermarket_edit_post_link         - 10
		 * @hooked hypermarket_post_footnote          - 20
		 * @hooked hypermarket_post_nav               - 30
		 * @hooked hypermarket_display_comments       - 40
		 */
		do_action( 'hypermarket_single_post_bottom', get_the_ID() );

	?>
	</div><!-- .entry-wrapper -->
	<?php

	/**
	 * Functions hooked into `hypermarket_sidebar` action
	 *
	 * @hooked  hypermarket_get_sidebar              - 10
	 */
	do_action( 'hypermarket_sidebar' );

	?>
</article><!-- #post-<?php the_ID(); ?> -->
