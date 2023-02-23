<?php
/**
 * Features block pattern.
 *
 * @link          https://mypreview.one
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/patterns
 */

namespace Hypermarket\Patterns\Features;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

return array(
	'title'      => esc_html__( 'Features', 'hypermarket' ),
	'categories' => array( 'featured' ),
	'blockTypes' => array( 'core/image', 'core/columns' ),
	'content'    => '
		<!-- wp:columns -->
		<div class="wp-block-columns"><!-- wp:column {"width":"","style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}}} -->
		<div class="wp-block-column" style="padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:group {"style":{"border":{"style":"dashed","radius":"20px","width":"2px"},"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}},"borderColor":"green","backgroundColor":"gray-extra-light"} -->
		<div class="wp-block-group has-border-color has-green-border-color has-gray-extra-light-background-color has-background" style="border-radius:20px;border-style:dashed;border-width:2px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:image -->
		<figure class="wp-block-image"><img alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:heading {"level":5} -->
		<h5 id="title-is-here">' . __( 'Title is here', 'hypermarket' ) . '</h5>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s.', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}},"border":{"style":"dashed","width":"2px","radius":"20px"}},"borderColor":"blue","backgroundColor":"gray-light"} -->
		<div class="wp-block-group has-border-color has-blue-border-color has-gray-light-background-color has-background" style="border-radius:20px;border-style:dashed;border-width:2px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:image -->
		<figure class="wp-block-image"><img alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:heading {"level":5} -->
		<h5 id="title-is-here">' . __( 'Title is here', 'hypermarket' ) . '</h5>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s.', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"","style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}}} -->
		<div class="wp-block-column" style="padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:spacer -->
		<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:group {"style":{"border":{"style":"dashed","radius":"20px","width":"2px"},"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}}},"borderColor":"green","backgroundColor":"gray-extra-light"} -->
		<div class="wp-block-group has-border-color has-green-border-color has-gray-extra-light-background-color has-background" style="border-radius:20px;border-style:dashed;border-width:2px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:image -->
		<figure class="wp-block-image"><img alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:heading {"level":5} -->
		<h5 id="title-is-here">' . __( 'Title is here', 'hypermarket' ) . '</h5>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s.', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group -->

		<!-- wp:spacer {"height":50} -->
		<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:group {"style":{"spacing":{"padding":{"top":"20px","right":"20px","bottom":"20px","left":"20px"}},"border":{"style":"dashed","width":"2px","radius":"20px"}},"borderColor":"blue","backgroundColor":"gray-light"} -->
		<div class="wp-block-group has-border-color has-blue-border-color has-gray-light-background-color has-background" style="border-radius:20px;border-style:dashed;border-width:2px;padding-top:20px;padding-right:20px;padding-bottom:20px;padding-left:20px"><!-- wp:image -->
		<figure class="wp-block-image"><img alt=""/></figure>
		<!-- /wp:image -->

		<!-- wp:heading {"level":5} -->
		<h5 id="title-is-here">' . __( 'Title is here', 'hypermarket' ) . '</h5>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"medium"} -->
		<p class="has-medium-font-size">' . __( 'Lorem Ipsum has been the industry <br>standard dummy text ever since the 1500s.', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns -->
	',
);
