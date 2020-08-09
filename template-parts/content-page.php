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

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		/**
		 * Functions hooked in to `hypermarket_page` add_action
		 *
		 * @hooked hypermarket_div                    - 10
		 * @hooked hypermarket_post_thumbnail         - 20
		 * @hooked hypermarket_page_header            - 30
		 * @hooked hypermarket_div_close              - 35
		 * @hooked hypermarket_page_content           - 40
		 */
		do_action( 'hypermarket_page' );
	?>
</article><!-- #post-## -->
