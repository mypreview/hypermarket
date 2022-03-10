<?php
/**
 * Helper functions.
 * 
 * @link          https://mypreview.github.io/hypermarket
 * @author        MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 * @since         2.0.0
 *
 * @package       hypermarket
 * @subpackage    hypermarket/includes
 */

namespace Hypermarket\Includes\Utils;

use const Hypermarket\THEME as THEME;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! function_exists( 'get_file_asset' ) ) :
	/**
	 * Retrieve dependency extraction array for a given resource.
	 *
	 * @since     2.0.0
	 * @param     string $filename        Asset name (filename).
	 * @param     array  $dependencies    Array of asset dependencies.
	 * @return    array
	 * @phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
	 */
	function get_file_asset( string $filename = '', array $dependencies = array() ): array {
		// Bail early, in case the filename is not provided.
		if ( empty( $filename ) ) {
			return array();
		}

		$file_path       = get_parent_theme_file_path( sprintf( '/build/%s.js', $filename ) );
		$file_asset_path = get_parent_theme_file_path( sprintf( '/build/%s.asset.php', $filename ) );
		$file_asset      = file_exists( $file_asset_path ) ? require $file_asset_path : array(
			'dependencies' => $dependencies,
			'version'      => file_exists( $file_path ) ? filemtime( $file_path ) : THEME['version'],
		);

		return $file_asset;
	}
endif;

if ( ! function_exists( 'get_asset_handle' ) ) :
	/**
	 * Retrieve handle of the stylesheet or script to enqueue.
	 *
	 * @since     2.0.0
	 * @param     string $asset_name    Name of the asset.
	 * @param     string $type          Type of the asset, ex. style, script, font, etc.
	 * @return    string
	 */
	function get_asset_handle( string $asset_name = 'frontend', string $type = 'style' ): string {
		$handle = sprintf( '%s-%s-%s', THEME['slug'] ?? '', $asset_name, $type );
		return $handle;
	}
endif;

if ( ! function_exists( 'enqueue_resources' ) ) :
		/**
		 * Enqueue static resources.
		 *
		 * @since     2.0.0
		 * @param     string $asset_name    Name of the asset.
		 * @return    void
		 */
	function enqueue_resources( string $asset_name = '' ): void {
		// Bail early, in case the asset name is not provided.
		if ( empty( $asset_name ) ) {
			return;
		}

		$asset         = get_file_asset( $asset_name );
		$style_handle  = get_asset_handle( $asset_name, 'style' );
		$script_handle = get_asset_handle( $asset_name, 'script' );

		// Style.
		wp_enqueue_style( $style_handle, get_theme_file_uri( sprintf( '/build/%s.css', $asset_name ) ), array(), $asset['version'], 'screen' );
		wp_style_add_data( $style_handle, 'rtl', 'replace' );
		// Script.
		wp_enqueue_script( $script_handle, get_theme_file_uri( sprintf( '/build/%s.js', $asset_name ) ), $asset['dependencies'], $asset['version'], true );
	}
endif;

if ( ! function_exists( 'google_fonts_css' ) ) :
	/**
	 * Register Google fonts.
	 *
	 * @since     2.0.0
	 * @param     array $fonts    Google fonts names and variations.
	 * @return    string
	 */
	function google_fonts_css( array $fonts = array() ): string {
		if ( ! is_array( $fonts ) || empty( $fonts ) ) {
			return '';
		}

		$query_args = array(
			'family'  => implode( '|', $fonts ),
			'subset'  => rawurlencode( 'latin,latin-ext' ),
			'display' => 'swap',
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		return $fonts_url;
	}
endif;

if ( ! function_exists( 'is_blog_archive' ) ) :
	/**
	 * Checks if the current page is a blog post archive.
	 *
	 * @since     2.0.0
	 * @return    bool
	 */
	function is_blog_archive(): bool {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' === get_post_type() ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'is_plugin_activated' ) ) :
	/**
	 * Query a third-party plugin activation.
	 * This statement prevents from producing fatal errors,
	 * in case the the plugin is not activated on the site.
	 *
	 * @since     2.0.0
	 * @param     string $slug        Plugin slug to check for the activation state.
	 * @param     string $filename    Optional. Plugin’s main file name.
	 * @return    bool
	 * @phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	 */
	function is_plugin_activated( string $slug, string $filename = '' ): bool {
		$filename               = empty( $filename ) ? $slug : $filename;
		$plugin_path            = apply_filters( 'hypermarket_third_party_plugin_path', sprintf( '%s/%s.php', esc_html( $slug ), esc_html( $filename ) ) );
		$subsite_active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		$network_active_plugins = apply_filters( 'active_plugins', get_site_option( 'active_sitewide_plugins' ) );

		// Bail early in case the plugin is not activated on the website.
		// phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
		if ( ( empty( $subsite_active_plugins ) || ! in_array( $plugin_path, $subsite_active_plugins ) ) && ( empty( $network_active_plugins ) || ! array_key_exists( $plugin_path, $network_active_plugins ) ) ) {
			return false;
		}

		return true;
	}
endif;

if ( ! function_exists( 'is_woocommerce_activated' ) ) :
	/**
	 * Return `true` if "WooCommerce" is installed/activated and `false` otherwise.
	 *
	 * @since     2.0.0
	 * @return    bool
	 */
	function is_woocommerce_activated(): bool {
		return is_plugin_activated( 'woocommerce' );
	}
endif;
