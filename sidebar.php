<?php
/**
 * The sidebar containing the main widget area.
 * Displays a button to open the collapsible sidebar on mobile devices.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 */

if ( ! hypermarket_has_sidebar() ) {
	return;
}

?>
<a href="#" class="widget-area-toggle">
	<span>
		<?php esc_html_e( 'Toggle sidebar', 'hypermarket' ); ?>
	</span>
</a><!-- .widget-area-toggle -->
<aside id="secondary" class="widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<a href="#" class="widget-area__close dashicons dashicons-no-alt">
		<span class="screen-reader-text">
			<?php esc_html_e( 'Close sidebar', 'hypermarket' ); ?>
		</span>
	</a>
	<div class="<?php echo hypermarket_sanitize_html_classes( apply_filters( 'hypermarket_sidebar_class', array( 'widget-area__content' ) ), 'string' ); ?>">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside><!-- #secondary -->
