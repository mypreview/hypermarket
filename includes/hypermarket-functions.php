<?php
/**
 * Hypermarket functions.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes
 */

if ( ! function_exists( 'hypermarket_get_file_assets' ) ) :
	/**
	 * Reterive dependency extraction array for a given resource.
	 *
	 * @since    2.0.0
	 * @param    string $filename        Asset name (filename).
	 * @param    array  $dependencies    Array of asset dependencies.
	 * @return   void|array
	 */
	function hypermarket_get_file_assets( $filename = null, $dependencies = array() ) {
		if ( empty( $filename ) ) {
			return;
		}

		$file_path       = get_parent_theme_file_path( sprintf( '/dist/%s.js', $filename ) );
		$file_asset_path = get_parent_theme_file_path( sprintf( '/dist/%s.asset.php', $filename ) );
		//phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		$file_asset = file_exists( $file_asset_path ) ? require $file_asset_path : array(
			'dependencies' => $dependencies,
			'version'      => filemtime( $file_path ),
		);

		return $file_asset;
	}
endif;

if ( ! function_exists( 'hypermarket_is_fluid_template' ) ) :
	/**
	 * Checks if the current page is the fluid template.
	 *
	 * @since   2.0.0
	 * @return  bool
	 */
	function hypermarket_is_fluid_template() {
		return is_page_template( 'page-templates/template-fluid.php' ) ? true : false;
	}
endif;

if ( ! function_exists( 'hypermarket_is_woocommerce_activated' ) ) :
	/**
	 * Query WooCommerce activation.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_is_woocommerce_activated() {
		if ( class_exists( 'WooCommerce' ) ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_is_jetpack_activated' ) ) :
	/**
	 * Query Jetpack activation.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_is_jetpack_activated() {
		if ( class_exists( 'Jetpack' ) ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_is_blog_archive' ) ) :
	/**
	 * Checks if the current page is a blog post archive.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_is_blog_archive() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' === get_post_type() ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_has_blog_page' ) ) :
	/**
	 * Query if the blog posts page already configured and exists.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_has_blog_page() {
		$has_blog_page = (bool) get_option( 'page_for_posts', true );
		// phpcs:ignore PHPCompatibility.Operators.NewOperators.t_coalesceFound
		return $has_blog_page ?? true;
	}
endif;

if ( ! function_exists( 'hypermarket_blog_page_url' ) ) :
	/**
	 * Retrieve the URL for the blog posts page.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_blog_page_url() {
		if ( hypermarket_has_blog_page() ) {
			$page_id = get_option( 'page_for_posts', 0 );
			return get_the_permalink( $page_id );
		} else {
			return home_url();
		}
	}
endif;

if ( ! function_exists( 'hypermarket_site_title_or_logo' ) ) :
	/**
	 * Display the site title or logo
	 *
	 * @since   2.0.0
	 * @param   bool $echo   Optional. Echo the string or return it.
	 * @return  string
	 */
	function hypermarket_site_title_or_logo( $echo = true ) {
		if ( has_custom_logo() ) {
			$logo = get_custom_logo();
			$html = is_home() ? sprintf( '<h1 class="logo">%s</h1>', $logo ) : $logo;
		} else {
			$tag  = is_home() ? 'h1' : 'div';
			$html = sprintf( '<%s class="beta site-title"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url( '/' ) ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= sprintf( '<p class="site-description">%s</p>', esc_html( get_bloginfo( 'description', 'display' ) ) );
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'hypermarket_get_background_color' ) ) :
	/**
	 * Get the content background color.
	 *
	 * @since    2.0.0
	 * @return   array                  
	 */
	function hypermarket_get_background_color() {
		$bg_color = str_replace( '#', '', get_theme_mod( 'background_color' ) );

		return sprintf( '#%s', sanitize_hex_color_no_hash( $bg_color ) );
	}
endif;

if ( ! function_exists( 'hypermarket_get_post_meta' ) ) :
	/**
	 * Retrieves hypermarket post meta field for the given or queried post ID.
	 *
	 * @since    2.0.0
	 * @param    string $param      Meta key to retrieve.
	 * @param    int    $post_id    Queried post id.
	 * @return   array|bool                  
	 */
	function hypermarket_get_post_meta( $param = null, $post_id = null ) {
		// Retrieve ID of the current queried object.
		$object_id = is_null( $post_id ) ? intval( $post_id ) : (int) get_queried_object_id();

		if ( $object_id ) {
			// Retrieves the SEO post meta field for the queried post ID.
			$metas = get_post_meta( $object_id, 'hypermarket_metas', true );
			if ( is_array( $metas ) ) {
				if ( ! is_null( $param ) && isset( $metas[ $param ] ) ) {
					return $metas[ $param ];
				} else {
					return $metas;
				}           
			}
		}

		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_do_shortcode' ) ) :
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @since   2.0.0
	 * @param   string $tag                  The shortcode whose function to call.
	 * @param   array  $atts       Optional. The attributes to pass to the shortcode function.
	 * @param   array  $content    Optional. The shortcode's content. Default is null (none).
	 * @return  string|bool        
	 */
	function hypermarket_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}
			
		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
endif;

if ( ! function_exists( 'hypermarket_post_categories' ) ) :
	/**
	 * Retrieve category list for a post in either HTML list or custom format.
	 *
	 * @since   2.0.0
	 * @param   bool $echo      Echo the output.
	 * @return  string        
	 */
	function hypermarket_post_categories( $echo = false ) {
		// Categories.
		/* translators: used between list items, there is a space after the comma. */
		$category_list = get_the_category_list( __( ', ', 'hypermarket' ) );
		$return        = '';
		
		if ( $category_list ) {
			$return = sprintf(
				/* translators: 1: Open div tag, 2: Close div tag. */
				esc_html__( '%1$sin %2$s', 'hypermarket' ),
				'<div class="post-categories">',
				sprintf(
					'%s</div>',
					$category_list 
				)
			);
		}

		if ( $echo ) {
			//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $return; 
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_post_tags' ) ) :
	/**
	 * Retrieve the tags for a post formatted as a string.
	 *
	 * @since   2.0.0
	 * @param   bool $echo      Echo the output.
	 * @return  string        
	 */
	function hypermarket_post_tags( $echo = false ) {
		// Tags.
		/* translators: used between list items, there is a # after the each tag name. */
		$tag_list = get_the_tag_list();
		$return   = '';
		
		if ( $tag_list ) {
			$return = sprintf(
				'<div class="post-tags">%s</div>',
				/* translators: 1: Open span tag, 2: Close span tag. */
				sprintf( _n( '%1$sTag:%2$s', '%1$sTags:%2$s', count( get_the_tags() ), 'hypermarket' ), '<span class="screen-reader-text">', sprintf( '</span>%s', $tag_list ) )
			);
		}

		if ( $echo ) {
			//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $return; 
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_social_share_buttons' ) ) :
	/**
	 * Available list of networks for displaying social sharing buttons.
	 *
	 * @since    1.0.0
	 * @param    string $permalink     Queried post permalink (URL).
	 * @param    string $title         Queried post title.
	 * @param    bool   $echo          Echo the share buttons.
	 * @return   html
	 */
	function hypermarket_social_share_buttons( $permalink, $title, $echo = false ) {
		// Component classname.
		$classname = 'entry-share';
		$return    = sprintf( '<div class="%1$s"><span class="%1$s__label">', $classname );
		/* translators: %s: Post type. */
		$return       .= sprintf( esc_html__( 'Share %s:', 'hypermarket' ), get_post_type() );
		$return       .= '</span><ul>';
		$share_buttons = apply_filters(
			'hypermarket_social_share_buttons',
			array(
				array(
					'label'   => esc_html_x( 'Facebook', 'share icon', 'hypermarket' ),
					'network' => 'facebook',
					'url'     => sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%1$s&amp;t=%2$s', $permalink, rawurlencode( $title ) ),
				),
				array(
					'label'   => esc_html_x( 'LinkedIn', 'share icon', 'hypermarket' ),
					'network' => 'linkedin',
					'url'     => sprintf( 'https://www.linkedin.com/shareArticle?mini=true&amp;url=%1$s&title=%2$s', $permalink, rawurlencode( $title ) ),
				),
				array(
					'label'   => esc_html_x( 'Twitter', 'share icon', 'hypermarket' ),
					'network' => 'twitter',
					'url'     => sprintf( 'https://www.twitter.com/share?text=%1$s&amp;url=%2$s', rawurlencode( $title ), $permalink ),
				),
				array(
					'label'   => esc_html_x( 'Telegram', 'share icon', 'hypermarket' ),
					'network' => 'telegram',
					'url'     => sprintf( 'https://www.telegram.me/share/url?text=%1$s&amp;url=%2$s', rawurlencode( $title ), $permalink ),
				),
				'whatsapp' => array(
					'label'   => esc_html_x( 'WhatsApp', 'share icon', 'hypermarket' ),
					'network' => 'whatsapp',
					'url'     => sprintf( 'https://%1$s.whatsapp.com/send?text=%2$s&nbsp;%3$s', wp_is_mobile() ? 'api' : 'web', rawurlencode( $title ), $permalink ),
				),
				array(
					'label'   => esc_html_x( 'Email', 'share icon', 'hypermarket' ),
					'network' => 'email',
					'url'     => sprintf( 'mailto:?subject=%1$s&amp;body=%2$s', rawurlencode( $title ), $permalink ),
				),
			),
			$permalink,
			$title
		);

		// Make sure we have at least one social share button to display.
		if ( ! empty( $share_buttons ) && is_array( $share_buttons ) ) {
			foreach ( $share_buttons as $network ) {
				$return .= sprintf( '<li class="%1$s__%2$s"><a href="%3$s" target="_blank" rel="noopener noreferrer" class="icon icon--%2$s" data-tippy-content="%4$s"><span class="screen-reader-text">%2$s</span></a></li>', $classname, esc_attr( $network['network'] ), esc_url( $network['url'] ), esc_html( $network['label'] ) ); 
			}
		}

		$return .= '</ul></div>';

		if ( $echo ) {
			//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $return; 
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_header_styles' ) ) :
	/**
	 * Apply inline style to the theme header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_header_styles() {
		$header_bg_image = '';
		$is_header_image = get_header_image();

		if ( $is_header_image ) {
			$header_bg_image = sprintf( 'url(%s)', esc_url( $is_header_image ) );
		}

		$styles = array();

		if ( ! empty( $header_bg_image ) ) {
			$styles['background-image'] = $header_bg_image;
		}

		$styles = apply_filters( 'hypermarket_header_styles', $styles );

		foreach ( $styles as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		} // End of the loop.
	}
endif;

if ( ! function_exists( 'hypermarket_allowed_html' ) ) :
	/**
	 * An array of allowed HTML elements and attributes, or a context name such as 'post'.
	 *
	 * @since   2.0.0
	 * @return  array
	 */
	function hypermarket_allowed_html() {
		return (array) apply_filters(
			'hypermarket_allowed_html_args',
			array(
				'div' => array(
					'class' => array(),
				),
				'span' => array(
					'class' => array(),
				),
				'ul' => array(
					'class' => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'a' => array(
					'href'               => array(),
					'title'              => array(),
					'rel'                => array(),
					'class'              => array(),
					'target'             => array(),
					'data-tippy-content' => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			) 
		);
	}
endif;

if ( ! function_exists( 'hypermarket_generate_css' ) ) :
	/**
	 * Generate CSS.
	 *
	 * @since    2.0.0
	 * @param    string $selector  The CSS selector.
	 * @param    string $style     The CSS style.
	 * @param    string $value     The CSS value.
	 * @param    string $prefix    The CSS prefix.
	 * @param    string $suffix    The CSS suffix.
	 * @param    bool   $echo      Echo the styles.
	 * @return   void|string
	 */
	function hypermarket_generate_css( $selector, $style, $value, $prefix = '', $suffix = '', $echo = false ) {
		$return = '';
		
		// Bail early if we have no $selector elements or properties and $value.
		if ( ! $value || ! $selector ) {
			return;
		}

		$return = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $echo ) {
			//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $return; 
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_minify_inline_css' ) ) :
	/**
	 * Minifies the given CSS styles.
	 *
	 * @since    2.0.0
	 * @param    string $css    CSS styles.
	 * @return   void|string                     
	 */
	function hypermarket_minify_inline_css( $css ) {
		// Bail early if we have no $css properties to trim and minify.
		if ( ! isset( $css ) || empty( $css ) ) {
			return;
		}
		
		$css = preg_replace(
			array(
				// Normalize whitespace.
				'/\s+/',
				// Remove spaces before and after comment.
				'/(\s+)(\/\*(.*?)\*\/)(\s+)/',
				// Remove comment blocks, everything between /* and */, unless.
				// preserved with /*! ... */ or /** ... */.
				'~/\*(?![\!|\*])(.*?)\*/~',
				// Remove ; before }.
				'/;(?=\s*})/',
				// Remove space after , : ; { } */ >.
				'/(,|:|;|\{|}|\*\/|>) /',
				// Remove space before , ; { } ( ) >.
				'/ (,|;|\{|}|\)|>)/',
				// Strips leading 0 on decimal values (converts 0.5px into .5px).
				'/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i',
				// Strips units if value is 0 (converts 0px to 0).
				'/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i',
				// Converts all zeros value into short-hand.
				'/0 0 0 0/',
				// Shortern 6-character hex color codes to 3-character where possible.
				'/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i',
				// Replace `(border|outline):none` with `(border|outline):0`.
				'#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
				'#(background-position):0(?=[;\}])#si',
			),
			array(
				' ',
				'$2',
				'',
				'',
				'$1',
				'$1',
				'${1}.${2}${3}',
				'${1}0',
				'0',
				'#\1\2\3',
				'$1:0',
				'$1:0 0',
			),
			$css
		);
		$css = trim( $css );

		return wp_strip_all_tags( $css, false );
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize_method' ) ) :
	/**
	 * Returns the proper method name based on given input/value type to sanitize.
	 *
	 * @param  string $group   The group id or input type.
	 * @return mixed
	 */
	function hypermarket_sanitize_method( $group ) {
		$return = '';

		switch ( $group ) {
			case 'color':
			case 'hex':
				// Sanitizes a hex color.
				$return = 'sanitize_hex_color';
				break;
			case 'font':
			case 'number':
				// Convert a value to non-negative integer.
				$return = 'absint';
				break;
			default:
				// Escaping for HTML blocks.
				$return = 'esc_html';
				break;
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize_array' ) ) :
	/**
	 * Recursive sanitation for an array input.
	 *
	 * @param  array $input    The value to sanitize.
	 * @return string|array
	 */
	function hypermarket_sanitize_array( $input ) {
		foreach ( $input as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = recursive_sanitize_text_field( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}

		return $input;
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize' ) ) :
	/**
	 * Sanitize the given input/value.
	 *
	 * @param  int|string $input              The value to sanitize.
	 * @param  string     $group    Optional. The group id of the control or input type.
	 * @return mixed
	 */
	function hypermarket_sanitize( $input, $group = '' ) {
		$method = (string) hypermarket_sanitize_method( $group );
		return call_user_func( $method, $input );
	}
endif;

if ( ! function_exists( 'hypermarket_has_edit_permission' ) ) :
	/**
	 * Returns whether the current user has the `edit_posts` capability.
	 *
	 * @since    2.0.0
	 * @return   bool
	 */
	function hypermarket_has_edit_permission() {
		return current_user_can( 'edit_posts' );
	}
endif;

if ( ! function_exists( 'hypermarket_slugify' ) ) :
	/**
	 * Slugifies every string, even when it contains unicode!
	 *
	 * @since    2.0.0
	 * @param    string $input    The value to slugify.
	 * @return   string
	 */
	function hypermarket_slugify( $input ) {
		// Replace non letter or digits by -.
		$input = preg_replace( '~[^\pL\d]+~u', '-', $input );
		// Transliterate.
		$input = iconv( 'utf-8', 'us-ascii//TRANSLIT', $input );
		// Remove unwanted characters.
		$input = preg_replace( '~[^-\w]+~', '', $input );
		// Trim.
		$input = trim( $input, '-' );
		// Remove duplicate -.
		$input = preg_replace( '~-+~', '-', $input );
		// Lowercase.
		$input = strtolower( $input );

		if ( empty( $input ) ) {
			return 'n-a';
		}

		return $input;
	}
endif;

if ( ! function_exists( 'hypermarket_generate_editor_features' ) ) :
	/**
	 * Enhancements to opt-in to and the ability to extend and customize core WordPress editor.
	 *
	 * @since    2.0.0
	 * @param    string $id    The group id or key name.
	 * @return   array
	 */
	function hypermarket_generate_editor_features( $id ) {
		$return = array();
		$value  = 'font' === $id ? 'size' : $id;
		$group  = Hypermarket_Customize::get_controls( $id );

		if ( is_array( $group ) && ! empty( $group ) && isset( $group['settings'] ) ) {
			// Pluck the `Controls` list out of each object in the list.
			$sections = (array) wp_list_pluck( $group['settings'], 'controls' );
			// Make sure there are at least one section to loop through!
			if ( is_array( $sections ) && ! empty( $sections ) ) {
				foreach ( $sections as $controls ) {
					if ( is_array( $controls ) && ! empty( $controls ) ) {
						foreach ( $controls as $control ) {
							// Determine if the control id is declared and is different than null.
							if ( isset( $control['id'] ) ) {
								$control_id            = (string) $control['id'];
								$control_var           = (string) $control['var'];
								$control_label         = isset( $control['label'] ) ? (string) $control['label'] : '';
								$control_description   = isset( $control['description'] ) ? (string) $control['description'] : '';
								$control_suffix        = isset( $control['suffix'] ) ? (string) $control['suffix'] : '';
								$control_default_value = isset( $control['default'] ) ? (string) $control['default'] : '';
								$control_value         = (string) get_theme_mod( $control_id, $control_default_value );
								$control_slug          = (string) hypermarket_slugify( $control_label . $control_description );
								$control_name          = ! empty( $control_description ) ? (string) sprintf( '%s %s', $control_label, $control_description ) : $control_label;
								$return[]              = array(
									'name'  => esc_html( $control_name ),
									'slug'  => esc_html( $control_slug ),
									'var'   => esc_html( $control_var ),
									$value  => hypermarket_sanitize( $control_value, $id ),
								);
							}
						}
					}
				}
			}
		}

		return (array) $return;
	}
endif;

if ( ! function_exists( 'hypermarket_generate_editor_css' ) ) :
	/**
	 * Build CSS reflecting colors, fonts and other options set in the Gutenberg editor, and return them for output.
	 *
	 * @since    2.0.0
	 * @return   void|string
	 */
	function hypermarket_generate_editor_css() {
		$return           = null;
		$font_sizes       = get_theme_support( 'editor-font-sizes' );
		$color_palette    = get_theme_support( 'editor-color-palette' );
		$gradient_presets = get_theme_support( 'editor-gradient-presets' );

		// Editor font sizes.
		if ( ! empty( $font_sizes ) && is_array( $font_sizes ) ) {
			$font_sizes = $font_sizes[0];
			foreach ( $font_sizes as $font_size ) {
				$return .= hypermarket_generate_css( sprintf( '.has-%s-font-size', $font_size['slug'] ), 'font-size', sprintf( 'var(--%s)', $font_size['var'] ) );
			}
		}

		// Editor color palettes.
		if ( ! empty( $color_palette ) && is_array( $color_palette ) ) {
			$color_palette = $color_palette[0];
			foreach ( $color_palette as $color ) {
				$return .= hypermarket_generate_css( sprintf( '.has-%s-color', $color['slug'] ), 'color', sprintf( 'var(--%s)', $color['var'] ) );
				$return .= hypermarket_generate_css( sprintf( '.has-%s-background-color', $color['slug'] ), 'background-color', sprintf( 'var(--%s)', $color['var'] ) );
			}
		}

		// Editor gradient presets.
		if ( ! empty( $gradient_presets ) && is_array( $gradient_presets ) ) {
			$gradient_presets = $gradient_presets[0];
			foreach ( $gradient_presets as $gradient ) {
				$return .= hypermarket_generate_css( sprintf( '.has-%s-gradient-background', $gradient['slug'] ), 'background-image', $gradient['gradient'] );
			}
		}

		return hypermarket_minify_inline_css( $return );
	}
endif;
