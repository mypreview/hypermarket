<?php
/**
 * Hypermarket theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * Functions that are not pluggable (not wrapped in `function_exists()`) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 *
 * @see 		https://codex.wordpress.org/Theme_Development
 * @see 		https://codex.wordpress.org/Plugin_API
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Assign the "Hypermarket" info to constants.
$this_theme = wp_get_theme( 'hypermarket' );
define( 'HYPERMARKET_THEME_NAME', $this_theme->get( 'Name' ) );
define( 'HYPERMARKET_THEME_URI', $this_theme->get( 'ThemeURI' ) );
define( 'HYPERMARKET_THEME_AUTHOR', $this_theme->get( 'Author' ) );
define( 'HYPERMARKET_THEME_AUTHOR_URI', $this_theme->get( 'AuthorURI' ) );
define( 'HYPERMARKET_THEME_VERSION', $this_theme->get( 'Version' ) );

$hypermarket = (object) array(
	'version'    => HYPERMARKET_THEME_VERSION,

	/**
	 * Initialize all the things.
	 */
	'main'       => require get_parent_theme_file_path( '/inc/class-hypermarket.php' ),
	'customizer' => require get_parent_theme_file_path( '/inc/customizer/class-hypermarket-customizer.php' ),
);

require get_parent_theme_file_path( '/inc/hypermarket-functions.php' );
require get_parent_theme_file_path( '/inc/hypermarket-template-hooks.php' );
require get_parent_theme_file_path( '/inc/hypermarket-template-functions.php' );

if ( class_exists( 'Jetpack' ) ) {
	$hypermarket->jetpack = require get_parent_theme_file_path( '/inc/jetpack/class-hypermarket-jetpack.php' );
} // End If Statement

if ( hypermarket_is_woocommerce_activated() ) {
	$hypermarket->woocommerce            = require get_parent_theme_file_path( '/inc/woocommerce/class-hypermarket-woocommerce.php' );
	$hypermarket->woocommerce_customizer = require get_parent_theme_file_path( '/inc/woocommerce/class-hypermarket-woocommerce-customizer.php' );

	require get_parent_theme_file_path( '/inc/woocommerce/class-hypermarket-woocommerce-adjacent-products.php' );
	require get_parent_theme_file_path( '/inc/woocommerce/hypermarket-woocommerce-template-hooks.php' );
	require get_parent_theme_file_path( '/inc/woocommerce/hypermarket-woocommerce-template-functions.php' );
	require get_parent_theme_file_path( '/inc/woocommerce/hypermarket-woocommerce-functions.php' );
} // End If Statement

if ( is_admin() ) {
	$hypermarket->admin = require get_parent_theme_file_path( '/inc/admin/class-hypermarket-admin.php' );
	$hypermarket->tgmpa = require get_parent_theme_file_path( '/inc/tgmpa/class-hypermarket-tgmpa.php' );

	require get_parent_theme_file_path( '/inc/tgmpa/class-tgm-plugin-activation.php' );
} // End If Statement

/**
 * Note: Do not add any custom code here!
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */