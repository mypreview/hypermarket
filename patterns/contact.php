<?php
/**
 * Contact page block pattern.
 *
 * @link          https://mypreview.one
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/patterns
 */

namespace Hypermarket\Patterns\Contact;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

return array(
	'title'      => esc_html__( 'Contact', 'hypermarket' ),
	'categories' => array( 'pages' ),
	'content'    => '
		<!-- wp:columns -->
		<div class="wp-block-columns"><!-- wp:column {"width":"40%","style":{"spacing":{"padding":{"top":"50px","right":"50px","bottom":"50px","left":"50px"}}},"backgroundColor":"gray-extra-light"} -->
		<div class="wp-block-column has-gray-extra-light-background-color has-background" style="padding-top:50px;padding-right:50px;padding-bottom:50px;padding-left:50px;flex-basis:40%"><!-- wp:heading -->
		<h2 id="contact-us">' . __( 'Contact us', 'hypermarket' ) . '</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p><strong>Lorem Ipsum</strong>' . __( 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:paragraph -->
		<p>' . __( 'youmail@gmail.com', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>' . __( '+44 111 333 22', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>' . __( 'Address: It is a long established fact that a reader', 'hypermarket' ) . '</p>
		<!-- /wp:paragraph -->

		<!-- wp:spacer {"height":20} -->
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:social-links -->
		<ul class="wp-block-social-links"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

		<!-- wp:social-link {"url":"#","service":"instagram"} /-->

		<!-- wp:social-link {"service":"twitter"} /--></ul>
		<!-- /wp:social-links --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns -->
	',
);
