<?php
/**
 * Hypermarket Jetpack Class
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/jetpack
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
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
		}

		/**
		 * Theme support for content options.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function setup() {
			global $hypermarket;
			
			add_theme_support( 
				'jetpack-content-options',
				apply_filters( 
					'hypermarket_jetpack_content_args',
					array(
						'blog-display'       => array( 'content', 'excerpt' ),
						'author-bio'         => true,
						'author-bio-default' => true,
						'post-details'       => array(
							'stylesheet' => sprintf( '%s-style', $hypermarket->slug ),
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
