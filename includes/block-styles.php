<?php
/**
 * Block styles.
 *
 * @link          https://mypreview.one
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/includes
 * @phpcs:disable WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
 */

namespace Hypermarket\Includes\Block_Styles;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Register block styles
 *
 * @since     2.0.0
 * @return    void
 */
function styles(): void {
	/**
	 * Filters the theme block styles.
	 *
	 * @since     1.0.0
	 * @return    array
	 */
	$block_styles = (array) apply_filters(
		'hypermarket_block_styles',
		array(
			'core/navigation' => array(
				'name'  => 'minimal',
				'label' => __( 'minimal', 'hypermarket' ),
			),
			'core/heading' => array(
				'name'  => 'h2',
				'label' => __( 'Heading 2', 'hypermarket' ),
			),
		) 
	);

	foreach ( $block_styles as $block_name => $style_args ) {
		register_block_style( $block_name, $style_args );
	}
}
add_action( 'init', __NAMESPACE__ . '\styles' );
