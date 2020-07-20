<?php
/**
 * Hypermarket Jetpack Class
 *
 * @since       2.0.0
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_Jetpack' ) ) :

	/**
	 * The main `Hypermarket` Jetpack integration class
	 */
	final class Hypermarket_Jetpack {

		/**
		 * Setup class.
		 * 
		 * @return  void
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
		}

		/**
		 * Theme support for content options.
		 * 
		 * @return  void
		 */
		public function setup() {
			add_theme_support( 
				'jetpack-content-options',
				apply_filters( 
					'hypermarket_jetpack_content_args',
					array(
						'blog-display'       => array( 'content', 'excerpt' ),
						'author-bio'         => true,
						'author-bio-default' => true,
						'post-details'       => array(
							'stylesheet' => 'hypermarket-style',
							'date'       => '.posted-on',
							'categories' => '.cat-links',
							'tags'       => '.tags-links',
							'author'     => '.byline',
							'comment'    => '.comments-link',
						),
						'featured-images'    => array(
							'archive'         => true,
							'archive-default' => true,
							'post'            => true,
							'post-default'    => true,
							'page'            => true,
							'page-default'    => true,
						), 
					) 
				) 
			);
		}

	}
endif;

return new Hypermarket_Jetpack();
