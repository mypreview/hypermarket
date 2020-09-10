<?php
/**
 * Template part for displaying posts.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 * @subpackage  hypermarket/template-parts
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

		do_action( 'hypermarket_single_post_top' );

		/**
		 * Functions hooked into `hypermarket_single_post` add_action
		 *
		 * @hooked hypermarket_post_header            - 10
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
		 * @hooked hypermarket_display_comments       - 30
		 */
		do_action( 'hypermarket_single_post_bottom' );

	?>
</article><!-- #post-## -->
