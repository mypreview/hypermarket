<?php
/**
 * Template part for displaying page content in `page.php`.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 * @subpackage  hypermarket/template-parts
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class( 'page-view' ); ?>>
	<?php

		/**
		 * Functions hooked into `hypermarket_page_top` add_action
		 *
		 * @hooked hypermarket_div                    - 5
		 * @hooked hypermarket_page_header            - 10
		 * @hooked hypermarket_breadcrumb             - 20
		 * @hooked hypermarket_div_close              - 25
		 */
		do_action( 'hypermarket_page_top' );

		/**
		 * Functions hooked into `hypermarket_page` add_action
		 *
		 * @hooked hypermarket_post_thumbnail         - 10
		 * @hooked hypermarket_page_content           - 20
		 */
		do_action( 'hypermarket_page' );

		/**
		 * Functions hooked in to `hypermarket_page_bottom` action
		 *
		 * @hooked hypermarket_edit_post_link         - 10
		 * @hooked hypermarket_page_nav               - 20
		 * @hooked hypermarket_display_comments       - 30
		 */
		do_action( 'hypermarket_page_bottom' );
	?>
</article><!-- #post-## -->
