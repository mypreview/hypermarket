<?php
/**
 * Hypermarket theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * Do not add any custom code here.
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
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