<?php
/**
 * The file that defines the core theme class.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

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
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'wp_head', array( $this, 'javascript_detection' ), 0 );
			add_action( 'wp_head', array( $this, 'pingback_header' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 35 );
			add_action( 'wp_resource_hints', array( $this, 'preconnect_gstatic' ), 10, 2 );
			add_filter( 'body_class', array( $this, 'body_classes' ) );
			add_filter( 'navigation_markup_template', array( $this, 'navigation_markup_template' ) );
			add_filter( 'excerpt_more', array( $this, 'custom_excerpt_more' ) );
			add_filter( 'comment_form_fields', array( $this, 'move_comment_field_to_bottom' ) );
			add_filter( 'wp_list_categories', array( $this, 'cat_count_span' ) );
			add_filter( 'get_archives_link', array( $this, 'archive_count_span' ) );
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
			}

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
				'html5',
				apply_filters(
					'hypermarket_html5_args',
					array(
						'search-form',
						'comment-form',
						'comment-list',
						'gallery',
						'caption',
						'widgets',
						'script', 
						'style',
					)
				)
			);

			/**
			 * Enable support for site logo.
			 */
			add_theme_support(
				'custom-logo',
				apply_filters(
					'hypermarket_custom_logo_args',
					array(
						'height'      => 110,
						'width'       => 470,
						'flex-width'  => true,
						'flex-height' => true,
					)
				)
			);

			/**
			 * Set up the WordPress core custom background feature.
			 */
			add_theme_support(
				'custom-background',
				apply_filters(
					'hypermarket_custom_background_args',
					array(
						'default-color' => apply_filters( 'hypermarket_default_background_color', 'ffffff' ),
						'default-image' => '',
					)
				)
			);

			/**
			 * Set up the WordPress core custom header feature.
			 */
			add_theme_support(
				'custom-header',
				apply_filters(
					'hypermarket_custom_header_args',
					array(
						'default-image' => '',
						'header-text'   => false,
						'width'         => 1950,
						'height'        => 500,
						'flex-width'    => true,
						'flex-height'   => true,
					)
				)
			);

			/**
			 * Add support for editor font sizes.
			 */
			add_theme_support( 
				'editor-font-sizes',
				apply_filters(
					'hypermarket_font_sizes_args',
					array(
						array(
							'name' => __( 'Small', 'hypermarket' ),
							'size' => 14,
							'slug' => 'small',
						),
						array(
							'name' => __( 'Normal', 'hypermarket' ),
							'size' => 16,
							'slug' => 'normal',
						),
						array(
							'name' => __( 'Medium', 'hypermarket' ),
							'size' => 23,
							'slug' => 'medium',
						),
						array(
							'name' => __( 'Large', 'hypermarket' ),
							'size' => 26,
							'slug' => 'large',
						),
						array(
							'name' => __( 'Huge', 'hypermarket' ),
							'size' => 37,
							'slug' => 'huge',
						),
					)
				) 
			);

			/**
			 * Add support for editor color palettes.
			 */
			add_theme_support( 
				'editor-color-palette',
				apply_filters(
					'hypermarket_color_palette_args',
					array(
						array(
							'name'  => __( 'Black', 'hypermarket' ),
							'slug'  => 'black',
							'color' => '#000000',
						),
						array(
							'name'  => __( 'White', 'hypermarket' ),
							'slug'  => 'white',
							'color' => '#FFFFFF',
						),
					)
				) 
			);

			/**
			 * Add support for editor gradient presets.
			 */
			add_theme_support( 
				'editor-gradient-presets',
				apply_filters(
					'hypermarket_gradient_presets_args',
					array(
						array(
							'name'     => __( 'Picton Blue to Mariner', 'hypermarket' ),
							'slug'     => 'picton-blue-to-mariner',
							'gradient' => 'linear-gradient(180deg,rgb(77, 166, 226),rgb(48, 102, 204))',
						),
					)
				) 
			);

			/**
			 * This theme uses `wp_nav_menu()` in four location.
			 */
			register_nav_menus(
				apply_filters(
					'hypermarket_register_nav_menus',
					array(
						'primary'  => __( 'Primary', 'hypermarket' ),
						'handheld' => __( 'Handheld', 'hypermarket' ),
					)
				)
			);

			/**
			 * Enqueue editor styles.
			 */
			add_editor_style( array( sprintf( '%s/legacy-editor.css', HYPERMARKET_THEME_DIST_PATH ), $this->google_fonts() ) );
		}

		/**
		 * Handles JavaScript detection.
		 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
		 *
		 * @return  void
		 */
		public function javascript_detection() {
			echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n"; 
		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 *
		 * @return  void
		 */
		public function pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		/**
		 * Register widget areas.
		 *
		 * @return  void
		 */
		public function widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'        => __( 'Sidebar', 'hypermarket' ),
				'id'          => 'sidebar-1',
				'description' => '',
			);

			$rows    = intval( apply_filters( 'hypermarket_footer_widget_rows', 2 ) );
			$regions = intval( apply_filters( 'hypermarket_footer_widget_columns', 3 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 === $rows ) {
						/* translators: 1: column number */
						$footer_region_name = sprintf( __( 'Footer Column %1$d', 'hypermarket' ), $region );

						/* translators: 1: column number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'hypermarket' ), $region );
					} else {
						/* translators: 1: row number, 2: column number */
						$footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'hypermarket' ), $row, $region );

						/* translators: 1: column number, 2: row number */
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'hypermarket' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				} // End of the loop.
			} // End of the loop.

			$sidebar_args = apply_filters( 'hypermarket_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<span class="widget-title">',
					'after_title'   => '</span>',
				);

				/**
				 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
				 *
				 * 'hypermarket_header_widget_tags'
				 * 'hypermarket_sidebar_widget_tags'
				 *
				 * 'hypermarket_footer_1_widget_tags' -> (Row 1)
				 * 'hypermarket_footer_2_widget_tags' -> (Row 1)
				 * 'hypermarket_footer_3_widget_tags' -> (Row 1)
				 * 'hypermarket_footer_4_widget_tags' -> (Row 1)
				 * 'hypermarket_footer_1_widget_tags' -> (Row 2)
				 * 'hypermarket_footer_2_widget_tags' -> (Row 2)
				 * 'hypermarket_footer_3_widget_tags' -> (Row 2)
				 * 'hypermarket_footer_4_widget_tags' -> (Row 2)
				 */
				$filter_hook = sprintf( 'hypermarket_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			} // End of the loop.
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @return  void
		 */
		public function enqueue() {
			$public_asset_name = 'public';
			$public_asset      = hypermarket_get_file_assets( $public_asset_name );

			// Fonts.
			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			wp_enqueue_style( sprintf( '%s-fonts', $hypermarket->slug ), $this->google_fonts(), array(), null );
			// Styles.
			wp_enqueue_style( sprintf( '%s-style', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.css', $public_asset_name ) ), '', $public_asset['version'], 'all' );
			wp_style_add_data( sprintf( '%s-style', $hypermarket->slug ), 'rtl', 'replace' );
			// Scripts.
			wp_enqueue_script( sprintf( '%s-script', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.js', $public_asset_name ) ), $public_asset['dependencies'], $public_asset['version'], true );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			do_action( 'hypermarket_enqueue_scripts' );
		}

		/**
		 * Enqueue supplemental block editor assets.
		 *
		 * @since   1.0.0
		 * @return  void
		 */
		public function enqueue_editor() {
			$editor_asset_name = 'editor';
			$editor_asset      = hypermarket_get_file_assets( $editor_asset_name );

			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			wp_enqueue_style( sprintf( '%s-fonts', $hypermarket->slug ), $this->google_fonts(), array(), null );
			wp_enqueue_style( sprintf( '%s-editor-style', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.css', $editor_asset_name ) ), '', $editor_asset['version'] );
			wp_style_add_data( sprintf( '%s-editor-style', $hypermarket->slug ), 'rtl', 'replace' );
			wp_add_inline_style( sprintf( '%s-editor-style', $hypermarket->slug ), hypermarket_generate_editor_styles() );
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 * Wait for the WooCommerce...
		 *
		 * @return  void
		 */
		public function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'hypermarket-child-style', get_stylesheet_uri(), '', apply_filters( 'hypermarket_child_style_version', $child_theme->get( 'Version' ) ) );
			}
		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param   array $urls            URLs to print for resource hints.
		 * @param   array $relation_type   The relation type the URLs are printed.
		 * @return  array   $urls            URLs to print for resource hints.
		 */
		public function preconnect_gstatic( $urls, $relation_type ) {
			if ( wp_style_is( sprintf( '%s-fonts', $hypermarket->slug ), 'queue' ) && 'preconnect' === $relation_type ) {
				$urls[] = array(
					'crossorigin',
					'href' => 'https://fonts.gstatic.com',
				);
			}

			return $urls;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param   array $classes        Classes for the body element.
		 * @return  array
		 */
		public function body_classes( $classes ) {
			// The list of WordPress global browser checks
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

			// Add class if sidebar is used.
			if ( is_active_sidebar( 'sidebar-1' ) && ! is_404() && ! hypermarket_is_fluid_template() ) {
				$classes[] = 'has-sidebar';
			}

			// Add class when using featured image.
			if ( has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			// Add class if we're viewing the Customizer for easier styling of theme options.
			if ( is_customize_preview() ) {
				$classes[] = 'customizer-running';
			}

			// Add class if the current page is a blog post archive/single.
			if ( hypermarket_is_blog_archive() ) {
				$classes[] = 'blog-archive';
			}

			// Check the globals to see if the browser is in there and return a string with the match
			if ( is_array( $browsers ) && ! empty( $browsers ) ) {
				// Search and filter the classnames using a callback function
				$classes[] = join(
					' ',
					array_filter(
						$browsers,
						function( $browser ) {
							return $GLOBALS[ $browser ];
						} 
					) 
				);
			}

			return apply_filters( 'hypermarket_body_classes', $classes );
		}

		/**
		 * Custom navigation markup template hooked 
		 * into `navigation_markup_template` filter hook.
		 *
		 * @return  string      $template   Modified version of the default template.
		 */
		public function navigation_markup_template() {
			$template  = '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="' . esc_html__( 'Post Navigation', 'hypermarket' ) . '">';
			$template .= '<h2 class="screen-reader-text">%2$s</h2>';
			$template .= '<div class="nav-links">%3$s</div>';
			$template .= '</nav>';

			return apply_filters( 'hypermarket_navigation_markup_template', $template );
		}

		/**
		 * Replaces "[...]" (appended to automatically generated excerpts) with `...`
		 *
		 * @param   string $excerpt    Excerpt more string.
		 * @return  string
		 */
		public function custom_excerpt_more( $more ) {
			if ( is_admin() ) {
				return $more;
			}

			return apply_filters( 'hypermarket_custom_excerpt_more', '&hellip;' );
		}

		/**
		 * Move the comment text field to the bottom.
		 *
		 * @param   array $fields     The comment fields.
		 * @return  array
		 */
		public function move_comment_field_to_bottom( $fields ) {
			$comment_field = $fields['comment'];
			unset( $fields['comment'] );
			$fields['comment'] = $comment_field;

			return $fields;
		}

		/**
		 * Adds a span around post counts in category widget.
		 *
		 * @param   html $links      HTML markup of the links.
		 * @return  html
		 */
		public function cat_count_span( $links ) {
			$links = str_replace( '</a> (', '<span class="count">(', $links );
			$links = str_replace( ')', ')</span></a>', $links );

			return $links;
		}

		/**
		 * Adds a span around post counts in archive widget.
		 *
		 * @param   html $links      HTML markup of the links.
		 * @return  html
		 */
		public function archive_count_span( $links ) {
			$links = str_replace( '</a>&nbsp;(', '<span class="count">(', $links );
			$links = str_replace( ')', ')</span></a>', $links );

			return $links;
		}

		/**
		 * Register Google fonts.
		 *
		 * @return  string      Google fonts URL for the theme.
		 */
		public function google_fonts() {
			$google_fonts = apply_filters(
				'hypermarket_google_font_families',
				array(
					'work-sans' => 'Work+Sans:300,400,500,600',
				)
			);

			$query_args = array(
				'family'  => implode( '|', $google_fonts ),
				'subset'  => rawurlencode( 'latin,latin-ext' ),
				'display' => 'swap',
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

			return $fonts_url;
		}

	}
endif;