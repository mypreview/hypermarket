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

if ( ! function_exists( 'hypermarket_do_shortcode' ) ) :
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @since   2.0.0
	 * @param   string $tag        The shortcode whose function to call.
	 * @param   array  $atts       The attributes to pass to the shortcode function. Optional.
	 * @param   array  $content    The shortcode's content. Default is null (none).
	 * @return  string|bool             False on failure, the result of the shortcode on success.
	 */
	function hypermarket_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}
			
		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
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

if ( ! function_exists( 'hypermarket_generate_editor_styles' ) ) :
	/**
	 * Build CSS reflecting colors, fonts and other options set in the Gutenberg editor, and return them for output.
	 *
	 * @since    2.0.0
	 * @return   void|string
	 */
	function hypermarket_generate_editor_styles() {
		$css              = null;
		$font_sizes       = get_theme_support( 'editor-font-sizes' );
		$color_palette    = get_theme_support( 'editor-color-palette' );
		$gradient_presets = get_theme_support( 'editor-gradient-presets' );

		// Editor font sizes.
		if ( ! empty( $font_sizes ) && is_array( $font_sizes ) ) {
			$font_sizes = $font_sizes[0];
			foreach ( $font_sizes as $font_size ) {
				$css .= hypermarket_generate_css( sprintf( '.has-%s-font-size', $font_size['slug'] ), 'font-size', $font_size['size'], '', 'px' );
			}
		}

		// Editor color palettes.
		if ( ! empty( $color_palette ) && is_array( $color_palette ) ) {
			$color_palette = $color_palette[0];
			foreach ( $color_palette as $color ) {
				$css .= hypermarket_generate_css( sprintf( '.has-%s-color', $color['slug'] ), 'color', $color['color'], '', '', false );
				$css .= hypermarket_generate_css( sprintf( '.has-%s-background-color', $color['slug'] ), 'background-color', $color['color'] );
			}
		}

		// Editor gradient presets.
		if ( ! empty( $gradient_presets ) && is_array( $gradient_presets ) ) {
			$gradient_presets = $gradient_presets[0];
			foreach ( $gradient_presets as $gradient ) {
				$css .= hypermarket_generate_css( sprintf( '.has-%s-gradient-background', $gradient['slug'] ), 'background-image', $gradient['gradient'] );
			}
		}

		return hypermarket_minify_inline_css( $css );
	}
endif;
