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
 * @see         https://codex.wordpress.org/Theme_Development
 * @see         https://codex.wordpress.org/Plugin_API
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

// Assign the "Hypermarket" info to constants.
$hypermarket_theme = wp_get_theme( 'hypermarket' );
define( 'HYPERMARKET_THEME_NAME', $hypermarket_theme->get( 'Name' ) );
define( 'HYPERMARKET_THEME_URI', $hypermarket_theme->get( 'ThemeURI' ) );

$hypermarket = (object) array(
	'version'    => HYPERMARKET_THEME_VERSION,
	'slug'       => 'hypermarket',
	'main'       => require get_parent_theme_file_path( '/includes/class-hypermarket.php' ),
);

require get_parent_theme_file_path( '/includes/hypermarket-functions.php' );
require get_parent_theme_file_path( '/includes/hypermarket-template-hooks.php' );
require get_parent_theme_file_path( '/includes/hypermarket-template-functions.php' );

if ( class_exists( 'Jetpack' ) ) {
	$hypermarket->jetpack = require get_parent_theme_file_path( '/includes/jetpack/class-hypermarket-jetpack.php' );
}

if ( hypermarket_is_woocommerce_activated() ) {
	$hypermarket->woocommerce = require get_parent_theme_file_path( '/includes/woocommerce/class-hypermarket-woocommerce.php' );

	require get_parent_theme_file_path( '/includes/woocommerce/class-hypermarket-woocommerce-adjacent-products.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-template-hooks.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-template-functions.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-functions.php' );
}

if ( is_admin() ) {
	$hypermarket->tgmpa = require get_parent_theme_file_path( '/includes/tgmpa/class-hypermarket-tgmpa-register.php' );

	require get_parent_theme_file_path( '/includes/tgmpa/class-tgm-plugin-activation.php' );
}

/**
 * Begins execution of the theme.
 *
 * Since everything within the theme is registered via hooks,
 * then kicking off the theme from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function hypermarket_run() {
	$theme = new Hypermarket();
	// Check for WooCommerce before initialization of the class.
	if ( hypermarket_is_woocommerce_activated() ) {
		$woocommerce = new Hypermarket_WooCommerce();
	}
}
hypermarket_run();

/**
 * Note: Do not add any custom code here!
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */
