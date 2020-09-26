<?php
/**
 * A full-width widgetized area which will display any widget added to this region above the footer widget area.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

if ( ! is_active_sidebar( 'footer-bar' ) ) {
	return;
}

?><section class="site-footer-bar" role="complementary">
	<?php dynamic_sidebar( 'footer-bar' ); ?>
</section><!-- .site-footer-bar -->
