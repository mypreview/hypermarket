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
		 * @since   2.0.0
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
		 * @since   2.0.0
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
			 * Add support for editor font sizes.
			 */
			add_theme_support( 
				'editor-font-sizes',
				apply_filters(
					'hypermarket_font_sizes_args',
					(array) hypermarket_generate_editor_features( 'font' )
				) 
			);

			/**
			 * Add support for editor color palettes.
			 */
			add_theme_support( 
				'editor-color-palette',
				apply_filters(
					'hypermarket_color_palette_args',
					(array) hypermarket_generate_editor_features( 'color' )
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
			add_editor_style( array( 'dist/legacy-editor.css', $this->google_fonts() ) );

			/**
			 * Add 'hypermarket_after_setup_theme' action.
			 */
			do_action( 'hypermarket_after_setup_theme' );
		}

		/**
		 * Handles JavaScript detection.
		 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function javascript_detection() {
			echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n"; 
		}

		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles.
		 *
		 * @since   2.0.0
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
		 * @since   2.0.0
		 * @return  void
		 */
		public function widgets_init() {
			global $hypermarket;
			$sidebar_args['sidebar'] = array(
				'name'        => __( 'Sidebar', 'hypermarket' ),
				'id'          => 'sidebar-1',
				'description' => '',
			);

			$rows    = intval( apply_filters( 'hypermarket_footer_widget_rows', 1 ) );
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
				$filter_hook = sprintf( '%s_%s_widget_tags', $hypermarket->slug, $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags ); //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			} // End of the loop.
		}

		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function enqueue() {
			global $hypermarket;
			$asset_name = 'public';
			$asset      = hypermarket_get_file_assets( $asset_name );

			// Remove the previously enqueued block-editor stylesheet.
			wp_dequeue_style( 'wp-block-library' );
			// Fonts.
			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			wp_enqueue_style( sprintf( '%s-fonts', $hypermarket->slug ), $this->google_fonts(), array(), null );
			// Styles.
			wp_enqueue_style( sprintf( '%s-style', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.css', $asset_name ) ), '', $asset['version'], 'all' );
			wp_style_add_data( sprintf( '%s-style', $hypermarket->slug ), 'rtl', 'replace' );
			wp_add_inline_style( sprintf( '%s-style', $hypermarket->slug ), Hypermarket_Customize::get_css() );
			wp_add_inline_style( sprintf( '%s-style', $hypermarket->slug ), hypermarket_generate_editor_css() );
			// Scripts.
			wp_enqueue_script( sprintf( '%s-script', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.js', $asset_name ) ), $asset['dependencies'], $asset['version'], true );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			do_action( 'hypermarket_enqueue_scripts' );
		}

		/**
		 * Enqueue supplemental block editor assets.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function enqueue_editor() {
			global $hypermarket;
			$asset_name = 'editor';
			$asset      = hypermarket_get_file_assets( $asset_name );

			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			wp_enqueue_style( sprintf( '%s-fonts', $hypermarket->slug ), $this->google_fonts(), array(), null );
			wp_enqueue_style( sprintf( '%s-editor-style', $hypermarket->slug ), get_theme_file_uri( sprintf( '/dist/%s.css', $asset_name ) ), '', $asset['version'] );
			wp_style_add_data( sprintf( '%s-editor-style', $hypermarket->slug ), 'rtl', 'replace' );
			wp_add_inline_style( sprintf( '%s-editor-style', $hypermarket->slug ), Hypermarket_Customize::get_css() );
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 * Wait for the WooCommerce...
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function child_scripts() {
			global $hypermarket;

			// Whether a child theme is in use.
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( sprintf( '%s-child-style', $hypermarket->slug ), get_stylesheet_uri(), '', apply_filters( 'hypermarket_child_style_version', $child_theme->get( 'Version' ) ) );
			}
		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param   array $urls            URLs to print for resource hints.
		 * @param   array $relation_type   The relation type the URLs are printed.
		 * @return  array $urls            URLs to print for resource hints.
		 */
		public function preconnect_gstatic( $urls, $relation_type ) {
			global $hypermarket;

			// Check whether the main CSS stylesheet has been added to the queue.
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
		 * @since   2.0.0
		 * @param   array $classes   Classes for the body element.
		 * @return  array
		 */
		public function body_classes( $classes ) {
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

		/**
		 * Custom navigation markup template hooked 
		 * into `navigation_markup_template` filter hook.
		 *
		 * @since   2.0.0
		 * @return  string $template   Modified version of the default template.
		 */
		public function navigation_markup_template() {
			$return               = '';
			$needle               = '%%';
			$current_page         = sprintf( '<span aria-current="page" class="page-numbers current">%s</span>', $needle );
			$previous_posts_label = esc_html__( 'Prev', 'hypermarket' );
			$next_posts_label     = esc_html__( 'Next', 'hypermarket' );
			$previous_posts_link  = get_previous_posts_link();
			$next_posts_link      = get_next_posts_link();

			// Whether the previous posts page link exists.
			if ( ! empty( $previous_posts_link ) ) {
				$return .= get_previous_posts_link( $previous_posts_label );
			} else {
				$return .= str_replace( $needle, $previous_posts_label, $current_page );
			}

			// Whether the next posts page link exists.
			if ( ! empty( $next_posts_link ) ) {
				$return .= get_next_posts_link( $next_posts_label );
			} else {
				$return .= str_replace( $needle, $next_posts_label, $current_page );
			}

			/* translators: 1: Open nav tag, 2: Close nav tag. */
			$template  = sprintf( esc_html__( '%1$sPost Navigation%2$s', 'hypermarket' ), '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="', '">' );
			$template .= '<h2 class="screen-reader-text">%2$s</h2>';
			$template .= '<div class="nav-links">%3$s</div>';
			$template .= sprintf( '<div class="navigation__pager">%s</div>', $return );
			$template .= '</nav>';

			return apply_filters( 'hypermarket_navigation_markup_template', $template );
		}

		/**
		 * Replaces "[...]" (appended to automatically generated excerpts) with `...`.
		 *
		 * @since   2.0.0
		 * @param   string $excerpt   Excerpt more string.
		 * @return  string
		 */
		public function custom_excerpt_more( $excerpt ) {
			if ( is_admin() ) {
				return $excerpt;
			}

			return apply_filters( 'hypermarket_custom_excerpt_more', '&hellip;' );
		}

		/**
		 * Move the comment text field to the bottom.
		 *
		 * @since   2.0.0
		 * @param   array $fields   The comment fields.
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
		 * @since   2.0.0
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
		 * @since   2.0.0
		 * @param   html $links   HTML markup of the links.
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
		 * @since   2.0.0
		 * @return  string   Google fonts URL for the theme.
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
