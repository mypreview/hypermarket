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
 * @author      MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since       2.0.0
 *
 * @package     hypermarket
 */

namespace Hypermarket;

use function Hypermarket\Includes\Utils\get_asset_handle as get_asset_handle;
use function Hypermarket\Includes\Utils\enqueue_resources as enqueue_resources;
use function Hypermarket\Includes\Utils\is_woocommerce_activated as is_woocommerce_activated;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

// Assign the "Hypermarket" info to constants.
$_theme = wp_get_theme(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
define(
	__NAMESPACE__ . '\THEME',
	array(
		'version'    => $_theme->get( 'Version' ),
		'name'       => $_theme->get( 'Name' ),
		'theme_uri'  => $_theme->get( 'ThemeURI' ),
		'slug'       => 'hypermarket',
	)
);

require get_parent_theme_file_path( '/includes/block-styles.php' );
require get_parent_theme_file_path( '/includes/utils.php' );

// Call for WooCommerce specific files when the plugin is active.
if ( is_woocommerce_activated() ) {
	require get_parent_theme_file_path( '/includes/woocommerce/functions.php' );
}

/**
 * Load the theme text domain for translation.
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * @since     2.0.0
 * @return    void
 */
function load_textdomain(): void {
	// Loads `wp-content/languages/themes/siuy-it_IT.mo`.
	load_theme_textdomain( 'hypermarket', untrailingslashit( WP_LANG_DIR ) . '/themes/' );
	// Loads `wp-content/themes/child-theme-name/languages/it_IT.mo`.
	load_theme_textdomain( 'hypermarket', untrailingslashit( get_stylesheet_directory() ) . '/languages' );
	// Loads `wp-content/themes/siuy/languages/it_IT.mo`.
	load_theme_textdomain( 'hypermarket', untrailingslashit( get_template_directory() ) . '/languages' );
}
add_action( 'init', __NAMESPACE__ . '\load_textdomain', 10, 2 );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since     2.0.0
 * @return    void
 */
function theme_support(): void {
	// Adding support for core block visual styles.
	add_theme_support( 'wp-block-styles' );

	// Enqueue editor styles.
	add_editor_style( 'style.css' );

	/**
	 * Add 'hypermarket_after_setup_theme' action.
	 */
	do_action( 'hypermarket_after_setup_theme' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_support' );

/**
 * Handles JavaScript detection.
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since     2.0.0
 * @return    void
 */
function javascript_detection(): void {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', __NAMESPACE__ . '\javascript_detection' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since     2.0.0
 * @return    void
 */
function pingback_header(): void {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\pingback_header' );

/**
 * Register the static resources for the public-facing side of the site.
 *
 * @since     2.0.0
 * @return    void
 */
function enqueue_frontend(): void {
	// Enqueue public-facing static resources.
	enqueue_resources( 'frontend' );

	wp_localize_script(
		get_asset_handle( 'frontend', 'script' ),
		'hypermarket',
		apply_filters(
			'hypermarket_l10n_args',
			array(
				'ajaxurl'  => admin_url( 'admin-ajax.php', 'relative' ),
				'isRTL'    => is_rtl(),
				'isMobile' => wp_is_mobile(),
			)
		)
	);

	do_action( 'hypermarket_enqueue_frontend', 'frontend' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_frontend' );

/**
 * Register the static resources for the Gutenberg editor area.
 *
 * @since     2.0.0
 * @return    void
 */
function enqueue_editor(): void {
	// Enqueue editor-facing static resources.
	enqueue_resources( 'editor' );

	do_action( 'hypermarket_enqueue_editor', 'editor' );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor' );

/**
 * Changes the number of words included in a post excerpt.
 *
 * @since     2.0.0
 * @param     int $length    The maximum number of words.
 * @return    int
 */
function reduced_post_excerpt_length( int $length ): int {
	if ( is_admin() ) {
		return $length;
	}

	return 35;
}
add_filter( 'excerpt_length', __NAMESPACE__ . '\reduced_post_excerpt_length' );

/**
 * Changes ellipsis shown at the end of a truncated post
 * excerpt.
 *
 * @since     2.0.0
 * @param     string $more    The string shown within the more link.
 * @return    string
 */
function dotted_excerpt_more( string $more ): string {
	if ( is_admin() ) {
		return $more;
	}

	return '&hellip;';
}
add_filter( 'excerpt_more', __NAMESPACE__ . '\dotted_excerpt_more' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since     2.0.0
 * @param     array $classes    Classes for the body element.
 * @return    array
 */
function body_classes( array $classes ): array {
	// The list of WordPress global browser checks.
	$browsers = apply_filters( 
		'hypermarket_browser_names',
		array( 
			'is_iphone', 
			'is_chrome', 
			'is_safari', 
			'is_NS4', 
			'is_opera', 
			'is_macIE', 
			'is_winIE', 
			'is_gecko', 
			'is_lynx', 
			'is_IE', 
			'is_edge', 
		) 
	);

	/**
	 * Adds a class when WooCommerce is not active.
	 */
	$classes[] = 'no-wc-breadcrumb';

	// Adds a class to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class when using featured image.
	if ( has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'customize-running';
	}

	// Add class if the current browser runs on a mobile device.
	if ( wp_is_mobile() ) {
		$classes[] = 'is-mobile';
	}

	// Check the globals to see if the browser is in there and return a string with the match.
	if ( is_array( $browsers ) && ! empty( $browsers ) ) {
		// Search and filter the classnames using a callback function.
		$classes[] = join(
			' ',
			array_filter(
				$browsers,
				// phpcs:ignore PHPCompatibility.FunctionDeclarations.NewClosure.Found
				function( $browser ) {
					return $GLOBALS[ $browser ];
				} 
			) 
		);
	}

	return apply_filters( 'hypermarket_body_classes', $classes );
}
add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );

/**
 * Note: Do not add any custom code here!
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */
