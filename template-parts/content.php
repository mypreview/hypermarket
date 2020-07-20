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

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

		/**
		 * Functions hooked in to `hypermarket_loop_post` action.
		 *
		 * @hooked hypermarket_post_thumbnail      - 10
		 * @hooked hypermarket_post_header         - 20
		 */
		do_action( 'hypermarket_loop_post' );

	?>
</article><!-- #post-## -->
