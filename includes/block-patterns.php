<?php
/**
 * Block patterns.
 *
 * @link          https://mypreview.github.io/hypermarket
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/includes
 * @phpcs:disable WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
 */

namespace Hypermarket\Includes\Block_Patterns;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Registers block patterns and categories.
 *
 * @since     2.0.0
 * @return    void
 */
function patterns(): void {
	$block_pattern_categories = array(
		'featured' => array( 'label' => __( 'Featured', 'hypermarket' ) ),
		'footer'   => array( 'label' => __( 'Footers', 'hypermarket' ) ),
		'pages'    => array( 'label' => __( 'Pages', 'hypermarket' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since     2.0.0
	 * @return    array
	 */
	$block_pattern_categories = (array) apply_filters( 'hypermarket_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! \WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	// Array of block pattern names.
	$block_patterns = array(
		'contact',
		'footer-services',
		'features',
	);

	/**
	 * Filters the theme block patterns.
	 *
	 * @since     2.0.0
	 * @return    array
	 */
	$block_patterns = (array) apply_filters( 'hypermarket_block_patterns', $block_patterns );

	foreach ( $block_patterns as $block_pattern ) {
		$pattern_file = get_parent_theme_file_path( '/patterns/' . $block_pattern . '.php' );

		register_block_pattern(
			'hypermarket/' . $block_pattern,
			require $pattern_file // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\patterns', 9 );
