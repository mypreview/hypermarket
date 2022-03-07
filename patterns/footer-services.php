<?php
/**
 * Footer Services block pattern.
 *
 * @link          https://mypreview.github.io/hypermarket
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/patterns
 */

namespace Hypermarket\Patterns\Footer_Services;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

return array(
	'title'      => esc_html__( 'Footer Services', 'hypermarket' ),
	'categories' => array( 'footer' ),
	'content'    => '
		<!-- wp:group {"align":"full","backgroundColor":"gray-extra-light"} -->
		<div class="wp-block-group alignfull has-gray-extra-light-background-color has-background"><!-- wp:group {"layout":{"inherit":true}} -->
		<div class="wp-block-group"><!-- wp:columns -->
		<div class="wp-block-columns"><!-- wp:column -->
		<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1"}},"fontSize":"huge"} -->
		<p class="has-text-align-center has-huge-font-size" style="line-height:1">🏆</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><strong>' . __( 'Lorem Ipsum', 'hypermarket' ) . '</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
		<p class="has-text-align-center has-small-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1"}},"fontSize":"huge"} -->
		<p class="has-text-align-center has-huge-font-size" style="line-height:1">🏆</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><strong>' . __( 'Lorem Ipsum', 'hypermarket' ) . '</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
		<p class="has-text-align-center has-small-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1"}},"fontSize":"huge"} -->
		<p class="has-text-align-center has-huge-font-size" style="line-height:1">🏆</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center"} -->
		<p class="has-text-align-center"><strong>' . __( 'Lorem Ipsum', 'hypermarket' ) . '</strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
		<p class="has-text-align-center has-small-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->
	',
);



