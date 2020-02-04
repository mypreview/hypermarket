<?php
/**
 * Hypermarket Class
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview, @gookalani)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
} // End If Statement

if ( ! class_exists( 'Hypermarket' ) ) :

	/**
	 * The main `Hypermarket` class
	 */
	final class Hypermarket {

		/**
		 * Setup class.
		 * 
		 * @return  void
		 */
		public function __construct() {
			add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );
			add_action( 'wp_head', array( $this, 'javascript_detection' ), 0 );
			add_action( 'wp_head', array( $this, 'pingback_header' ), 10 );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 * Note that this function is hooked into the `after_setup_theme` hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @return  void
		 */
		public function setup() {
			/**
			 * Set the content width based on the theme's design and stylesheet.
			 */
			if ( ! isset( $content_width ) ) {
				$content_width = apply_filters( 'hypermarket_content_width', 1210 ); /* pixels */
			} // End If Statement

			/*
			 * Load Localisation files.
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */
			// Loads `wp-content/languages/themes/hypermarket-it_IT.mo`.
			load_theme_textdomain( 'hypermarket', trailingslashit( WP_LANG_DIR ) . 'themes/' );
			// Loads `wp-content/themes/child-theme-name/languages/it_IT.mo`.
			load_theme_textdomain( 'hypermarket', get_stylesheet_directory() . '/languages' );
			// Loads `wp-content/themes/hypermarket/languages/it_IT.mo`.
			load_theme_textdomain( 'hypermarket', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/**
			 * Enable support for Post Thumbnails on posts and pages.
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * Declare support for title theme feature.
			 */
			add_theme_support( 'title-tag' );

			/**
			 * Declare support for selective refreshing of widgets.
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for full and wide align blocks.
			 */
			add_theme_support( 'align-wide' );

			/**
			 * Add support for responsive embedded content.
			 */
			add_theme_support( 'responsive-embeds' );

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support(
				'html5', apply_filters(
					'hypermarket_html5_args', array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
						'script', 
						'style'
					)
				)
			);

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo', apply_filters(
					'hypermarket_custom_logo_args', array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true
					)
				)
			);

			/**
			 * Set up the WordPress core custom background feature.
			 */
			add_theme_support(
				'custom-background', apply_filters(
					'hypermarket_custom_background_args', array(
						'default-color' => apply_filters( 'hypermarket_default_background_color', 'ffffff' ),
						'default-image' => ''
					)
				)
			);

			/**
			 * Set up the WordPress core custom header feature.
			 */
			add_theme_support(
				'custom-header', apply_filters(
					'hypermarket_custom_header_args', array(
						'default-image' => '',
						'header-text'   => false,
						'width'         => 1950,
						'height'        => 500,
						'flex-width'    => true,
						'flex-height'   => true
					)
				)
			);

			/**
			 * Add support for editor font sizes.
			 */
			add_theme_support( 
				'editor-font-sizes', apply_filters(
					'hypermarket_font_sizes_args', array(
						array(
							'name' => __( 'Small', 'hypermarket' ),
							'size' => 14,
							'slug' => 'small'
						),
						array(
							'name' => __( 'Normal', 'hypermarket' ),
							'size' => 16,
							'slug' => 'normal'
						),
						array(
							'name' => __( 'Medium', 'hypermarket' ),
							'size' => 23,
							'slug' => 'medium'
						),
						array(
							'name' => __( 'Large', 'hypermarket' ),
							'size' => 26,
							'slug' => 'large'
						),
						array(
							'name' => __( 'Huge', 'hypermarket' ),
							'size' => 37,
							'slug' => 'huge'
						)
					)
				) 
			);

			/**
			 * Add support for editor color palettes.
			 */
			add_theme_support( 
				'editor-color-palette', apply_filters(
					'hypermarket_color_palette_args', array(
						array(
							'name'  => __( 'Black', 'hypermarket' ),
							'slug'  => 'black',
							'color' => '#000000'
						),
						array(
							'name'  => __( 'White', 'hypermarket' ),
							'slug'  => 'white',
							'color' => '#FFFFFF'
						)
					)
				) 
			);

			/**
			 * This theme uses `wp_nav_menu()` in four location.
			 */
			register_nav_menus(
				apply_filters(
					'hypermarket_register_nav_menus', array(
						'primary'  => __( 'Primary', 'hypermarket' ),
						'handheld' => __( 'Handheld', 'hypermarket' )
					)
				)
			);
		}

		/**
		 * Handles JavaScript detection.
		 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
		 *
		 * @return  void
		 */
		public function javascript_detection() {
			echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n"; // WPCS: XSS okay.
		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 *
		 * @return  void
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
			} // End If Statement
		}

	}
endif;

return new Hypermarket();