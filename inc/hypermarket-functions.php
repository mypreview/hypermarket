<?php
/**
 * Hypermarket functions.
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! function_exists( 'hypermarket_is_woocommerce_activated' ) ) :
	/**
	 * Query WooCommerce activation
	 */
	function hypermarket_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
endif;

if ( ! function_exists( 'hypermarket_is_fluid_template' ) ) :
	/**
	 * Checks if the current page is the fluid template.
	 *
	 * @return  bool
	 */
	function hypermarket_is_fluid_template() {
		return is_page_template( 'page-templates/template-fluid.php' ) ? true : false;
	}
endif;


if ( ! function_exists( 'hypermarket_is_blog_archive' ) ) :
	/**
	 * Checks if the current page is a blog post archive.
	 *
	 * @return  bool
	 */
	function hypermarket_is_blog_archive() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' === get_post_type() ) return true;
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_do_shortcode' ) ) {
	/**
	 * Call a shortcode function by tag name.
	 *
	 * @param 	string 		$tag     	The shortcode whose function to call.
	 * @param 	array  		$atts    	The attributes to pass to the shortcode function. Optional.
	 * @param 	array  		$content 	The shortcode's content. Default is null (none).
	 * @return 	string|bool 			False on failure, the result of the shortcode on success.
	 */
	function hypermarket_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) return false;
			
		return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
	}
endif;

if ( ! function_exists( 'hypermarket_get_content_background_color' ) ) {
	/**
	 * Get the content background color
	 *
	 * @return 	string 					The background color
	 */
	function hypermarket_get_content_background_color() {
		$bg_color = str_replace( '#', '', get_theme_mod( 'background_color' ) );

		return sprintf( '#%s', sanitize_hex_color_no_hash( $bg_color ) );
	}
endif;

if ( ! function_exists( 'hypermarket_header_styles' ) ) {
	/**
	 * Apply inline style to the theme header.
	 *
	 * @return 	void
	 */
	function hypermarket_header_styles() {
		$header_bg_image = '';
		$is_header_image = get_header_image();

		if ( $is_header_image ) {
			$header_bg_image = sprintf( 'url(%s)', esc_url( $is_header_image ) );
		} // End If Statement

		$styles = array();

		if ( ! empty( $header_bg_image ) ) {
			$styles['background-image'] = $header_bg_image;
		} // End If Statement

		$styles = apply_filters( 'hypermarket_header_styles', $styles );

		foreach ( $styles as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		} // End of the loop.
	}
endif;

if ( ! function_exists( 'hypermarket_hex_to_rgb' ) ) :
	/**
	 * Convert Hex to RGB
	 * 
	 * @param  	string  	$hex   	Gex color e.g. #111111.
	 * @return 	array    	$rgb	Hex color in array format.
	 */
	function hypermarket_hex_to_rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		} // End If Statement

		$rgb = array( $r, $g, $b );

		return $rgb;
	}
endif;

if ( ! function_exists( 'hypermarket_luma' ) ) :
	/**
	 * Takes a hex value and converts it to a lightness
	 *
	 * @param  	string  	$hex   	Gex color e.g. #111111.
	 * @return 	float      			Value between 0 (dark) and 1 (light).
	 */
	function hypermarket_luma( $hex ) {
		// Convert Hex to RGB
		$rgb = hypermarket_hex_to_rgb( $hex );
		return ( 0.2126 * $rgb[0] + 0.7152 * $rgb[1] + 0.0722 * $rgb[2] ) / 255;
	}
endif;

if ( ! function_exists( 'hypermarket_adjust_color_brightness' ) ) :
	/**
	 * Adjust a hex color brightness
	 * Allows us to create hover styles for custom link colors
	 *
	 * @param  strong  $hex   hex color e.g. #111111.
	 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
	 * @return string        brightened/darkened hex color
	 * @since  1.0.0
	 */
	function hypermarket_adjust_color_brightness( $hex, $steps ) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter.
		$steps = max( -255, min( 255, $steps ) );
		// Convert Hex to RGB
		$rgb = hypermarket_hex_to_rgb( $hex );

		// Adjust number of steps and keep it inside 0 to 255.
		$r = max( 0, min( 255, $rgb[0] + $steps ) );
		$g = max( 0, min( 255, $rgb[1] + $steps ) );
		$b = max( 0, min( 255, $rgb[2] + $steps ) );

		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return sprintf( '#%s', $r_hex . $g_hex . $b_hex );
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize_choices' ) ) :
	/**
	 * Sanitizes choices (selects / radios)
	 * Checks that the input matches one of the available choices
	 *
	 * @param 	array 	$input 		The available choices.
	 * @param 	array 	$setting 	The setting object.
	 */
	function hypermarket_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug.
		$input = sanitize_key( $input );
		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;
		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize_checkbox' ) ) :
	/**
	 * Checkbox sanitization callback.
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param 	bool 	$checked 	Whether the checkbox is checked.
	 * @return 	bool 				Whether the checkbox is checked.
	 */
	function hypermarket_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}
endif;


if ( ! function_exists( 'hypermarket_minify_inline_css' ) ) :
	/**
	 * Minifies inline CSS styles
	 *
	 * @param  	string  	$inline_css   	Inline CSS styles.
	 * @return 	string      				Minified and striped version of the CSS style
	 */
	function hypermarket_minify_inline_css( $inline_css ) {
		if ( ! isset( $inline_css ) || empty( $inline_css ) ) return '';
		
		$inline_css = preg_replace(
			array(
				// Normalize whitespace
				'/\s+/',
				// Remove spaces before and after comment
				'/(\s+)(\/\*(.*?)\*\/)(\s+)/',
				// Remove comment blocks, everything between /* and */, unless
				// preserved with /*! ... */ or /** ... */
				'~/\*(?![\!|\*])(.*?)\*/~',
				// Remove ; before }
				'/;(?=\s*})/',
				// Remove space after , : ; { } */ >
				'/(,|:|;|\{|}|\*\/|>) /',
				// Remove space before , ; { } ( ) >
				'/ (,|;|\{|}|\)|>)/',
				// Strips leading 0 on decimal values (converts 0.5px into .5px)
				'/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i',
				// Strips units if value is 0 (converts 0px to 0)
				'/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i',
				// Converts all zeros value into short-hand
				'/0 0 0 0/',
				// Shortern 6-character hex color codes to 3-character where possible
				'/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i',
				// Replace `(border|outline):none` with `(border|outline):0`
				'#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
				'#(background-position):0(?=[;\}])#si'
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
				'$1:0 0'
			),
			$inline_css
		);
		$inline_css = trim( $inline_css );

		return wp_strip_all_tags( $inline_css, FALSE );
	}
endif;

if ( ! function_exists( 'hypermarket_sanitize_html_classes' ) ) :
	/**
	 * Sanitize multiple HTML classes in one pass.
	 *
	 * @param    $classes           Classes to be sanitized.
	 * @param    $return_format     The return format, 'input', 'string', or 'array'.
	 * @return   array|string       String of multiple sanitized classes.
	 */
    function hypermarket_sanitize_html_classes( $classes, $return_format = 'input' ) {
        if ( 'input' === $return_format ) {
            $return_format = is_array( $classes ) ? 'array' : 'string';
        } // End If Statement

        $classes = is_array( $classes ) ? $classes : explode( ' ', $classes );
        $sanitized_classes = array_map( 'sanitize_html_class', $classes );

        if ( 'array' === $return_format ) return $sanitized_classes;
            
        return implode( ' ', $sanitized_classes );
    }
endif;

if ( ! function_exists( 'hypermarket_string_to_bool' ) ) :
	/**
	 * Converts a string (e.g. 'yes' or 'no') to a bool.
	 *
	 * @param 	string 		$string 	String to convert.
	 * @return 	bool
	 */
	function hypermarket_string_to_bool( $string ) {
	    return is_bool( $string )  ?  $string  :  ( 'yes' === $string || 1 === $string || 'true' === $string || 'TRUE' === $string || '1' === $string );
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link 	https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;