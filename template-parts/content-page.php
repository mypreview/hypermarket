<?php
/**
 * Template part for displaying page content in `page.php`.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
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
		do_action( 'hypermarket_page_top', get_the_ID() );

	?>
	<div class="entry-wrapper">
	<?php

		/**
		 * Functions hooked into `hypermarket_page` add_action
		 *
		 * @hooked hypermarket_shop_messages          - 0
		 * @hooked hypermarket_post_thumbnail         - 10
		 * @hooked hypermarket_page_content           - 20
		 */
		do_action( 'hypermarket_page', get_the_ID() );

		/**
		 * Functions hooked in to `hypermarket_page_bottom` action
		 *
		 * @hooked hypermarket_edit_post_link         - 10
		 * @hooked hypermarket_page_nav               - 20
		 * @hooked hypermarket_display_comments       - 30
		 */
		do_action( 'hypermarket_page_bottom', get_the_ID() );
		
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
