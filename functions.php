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
$hypermarket       = (object) array(
	'version'    => $hypermarket_theme->get( 'Version' ),
	'name'       => $hypermarket_theme->get( 'Name' ),
	'theme_uri'  => $hypermarket_theme->get( 'ThemeURI' ),
	'slug'       => 'hypermarket',
	'main'       => require get_parent_theme_file_path( '/includes/class-hypermarket.php' ),
);

require get_parent_theme_file_path( '/includes/hypermarket-functions.php' );
require get_parent_theme_file_path( '/includes/hypermarket-template-hooks.php' );
require get_parent_theme_file_path( '/includes/hypermarket-template-functions.php' );

// Query WooCommerce activation.
if ( hypermarket_is_woocommerce_activated() ) {
	$hypermarket->woocommerce = require get_parent_theme_file_path( '/includes/woocommerce/class-hypermarket-woocommerce.php' );

	require get_parent_theme_file_path( '/includes/woocommerce/class-hypermarket-woocommerce-adjacent-products.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-template-hooks.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-template-functions.php' );
	require get_parent_theme_file_path( '/includes/woocommerce/hypermarket-woocommerce-functions.php' );
}

// Query Jetpack activation.
if ( hypermarket_is_jetpack_activated() ) {
	$hypermarket->jetpack = require get_parent_theme_file_path( '/includes/jetpack/class-hypermarket-jetpack.php' );
}

// Determines whether the current request is for an administrative interface page.
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
 * @since    2.0.0
 */
function hypermarket_run() {
	$theme = new Hypermarket();
	
	// Check for WooCommerce before initialization of the class.
	if ( hypermarket_is_woocommerce_activated() ) {
		$woocommerce = new Hypermarket_WooCommerce();
	}

	// Check for Jetpack before initialization of the class.
	if ( hypermarket_is_jetpack_activated() ) {
		$woocommerce = new Hypermarket_Jetpack();
	}
}
hypermarket_run();

/**
 * Note: Do not add any custom code here!
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */
