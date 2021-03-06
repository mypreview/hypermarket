<?php
/**
 * Hypermarket Customizer Class.
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/customize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_Customize' ) ) :

	/**
	 * The Hypermarket Customizer class
	 */
	final class Hypermarket_Customize {

		/**
		 * The settings control id.
		 *
		 * @access  public
		 * @var     string      $settings       The blog name.
		 */
		public static $setting_prefix = 'hypermarket_customize';

		/**
		 * Setup class.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ) );
		}

		/**
		 * Enqueue Customizer control scripts.
		 *
		 * @since   2.0.0
		 * @return  void
		 * @phpcs:disable WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
		 */
		public function enqueue() {
			$asset_name    = 'customize';
			$asset         = hypermarket_get_file_asset( $asset_name );
			$style_handle  = hypermarket_get_asset_handle( $asset_name, 'style' );
			$script_handle = hypermarket_get_asset_handle( $asset_name, 'script' );
			$l10n          = apply_filters(
				sprintf( 'hypermarket_%s_l10n_args', $asset_name ),
				array(
					'shop_url'  => hypermarket_is_woocommerce_activated() ? wc_get_page_permalink( 'shop' ) : '',
				) 
			);

			// Styles.
			wp_enqueue_style( $style_handle, get_theme_file_uri( sprintf( '/build/%s.css', $asset_name ) ), '', $asset['version'], 'all' );
			wp_style_add_data( $style_handle, 'rtl', 'replace' );
			// Scripts.
			wp_enqueue_script( $script_handle, get_theme_file_uri( sprintf( '/build/%s.js', $asset_name ) ), array( 'jquery', 'customize-controls' ), $asset['version'], true );
			wp_localize_script( $script_handle, sprintf( 'hypermarket_%s', $asset_name ), $l10n );

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound, WordPress.NamingConventions.ValidHookName.UseUnderscores
			do_action( sprintf( 'hypermarket_enqueue_%s', $asset_name ), $style_handle, $script_handle, $asset_name );
		}

		/**
		 * Fires once WordPress has loaded, allowing scripts and styles to be initialized.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $wp_customize   Theme Customizer object.
		 * @return  void
		 * @phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		 */
		public function customize_register( $wp_customize ) {
			// Import Customizer custom control(s).
			require get_parent_theme_file_path( '/includes/customize/class-hypermarket-customize-color-control.php' );
			require get_parent_theme_file_path( '/includes/customize/class-hypermarket-customize-more-control.php' );
			require get_parent_theme_file_path( '/includes/customize/class-hypermarket-customize-range-control.php' );
			// Registers Customizer color controls.
			$this->_register_controls( $wp_customize, 'color', 'Hypermarket_Customize_Color_Control' );
			// Registers Customizer font controls.
			$this->_register_controls( $wp_customize, 'font', 'Hypermarket_Customize_Range_Control' );
			// Registers Customizer layout controls.
			$this->_register_controls( $wp_customize, 'layout', 'WP_Customize_Control' );

			do_action( 'hypermarket_customize_register_controls', $wp_customize );
		}

		/**
		 * Returns an array of the desired default Customizer options.
		 *
		 * @since   2.0.0
		 * @return  array
		 */
		public static function get_default_settings() {
			global $hypermarket;
			$font_attrs = apply_filters(
				'hypermarket_customize_font_attrs',
				array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				) 
			);
			$settings   = apply_filters(
				'hypermarket_default_customize_values',
				array(
					'color' => array(
						'has_css'     => true,
						'type'        => 'color',
						'title'       => __( 'Colors', 'hypermarket' ),
						'description' => __( 'This option allows you to choose a color, view color suggestions, refine with the color picker and apply background color changes.', 'hypermarket' ),
						'settings'    => array( 
							array(
								'id'       => sprintf( '%s_general_colors', self::$setting_prefix ),
								'title'    => esc_html__( 'General', 'hypermarket' ),
								'controls' => array(
									array(
										'var'     => sprintf( '%s-general-entry', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_entry_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Entry', 'hypermarket' ),
										'default' => '#606060',
									),
									array(
										'var'         => sprintf( '%s-general-entry-alt', $hypermarket->slug ),
										'id'          => sprintf( '%s_general_entry_alt_color', self::$setting_prefix ),
										'label'       => esc_html__( 'Entry', 'hypermarket' ),
										'description' => esc_html__( 'Alternate', 'hypermarket' ),
										'default'     => '#999999',
									),
									array(
										'var'     => sprintf( '%s-general-quote', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_quote_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Blockquote', 'hypermarket' ),
										'default' => '#333333',
									),
									array(
										'var'     => sprintf( '%s-general-primary', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_primary_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Primary', 'hypermarket' ),
										'default' => '#77cde3',
									),
									array(
										'var'         => sprintf( '%s-general-primary-alt', $hypermarket->slug ),
										'id'          => sprintf( '%s_general_primary_alt_color', self::$setting_prefix ),
										'label'       => esc_html__( 'Primary', 'hypermarket' ),
										'description' => esc_html__( 'Alternate', 'hypermarket' ),
										'default'     => '#51bfdb',
									),
									array(
										'var'     => sprintf( '%s-general-border', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_border_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Border', 'hypermarket' ),
										'default' => '#ededed',
									),
									array(
										'var'     => sprintf( '%s-general-tile', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_tile_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Tile', 'hypermarket' ),
										'default' => '#f5f5f5',
									),
									array(
										'var'         => sprintf( '%s-general-tile-alt', $hypermarket->slug ),
										'id'          => sprintf( '%s_general_tile_alt_color', self::$setting_prefix ),
										'label'       => esc_html__( 'Tile', 'hypermarket' ),
										'description' => esc_html__( 'Alternate', 'hypermarket' ),
										'default'     => '#f0f0f0',
									),
									array(
										'var'     => sprintf( '%s-general-background', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_background_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Background', 'hypermarket' ),
										'default' => '#ffffff',
									),
								),
							),
							array(
								'id'       => sprintf( '%s_alert_colors', self::$setting_prefix ),
								'title'    => esc_html__( 'Alert', 'hypermarket' ),
								'controls' => array(
									array(
										'var'     => sprintf( '%s-alert-info', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_info_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Info', 'hypermarket' ),
										'default' => '#93c4ef',
									),
									array(
										'var'     => sprintf( '%s-alert-success', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_success_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Success', 'hypermarket' ),
										'default' => '#a7c04d',
									),
									array(
										'var'     => sprintf( '%s-alert-warning', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_warning_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Warning', 'hypermarket' ),
										'default' => '#f8c313',
									),
									array(
										'var'     => sprintf( '%s-alert-danger', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_danger_color', self::$setting_prefix ),
										'label'   => esc_html__( 'Danger', 'hypermarket' ),
										'default' => '#ef0568',
									),
								),
							),
							array(
								'id'       => sprintf( '%s_gradient_colors', self::$setting_prefix ),
								'title'    => esc_html__( 'Gradient', 'hypermarket' ),
								'controls' => array(
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-1', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_1', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 1', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(238,238,238) 0%, rgb(169,184,195) 100%)',
									),
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-2', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_2', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 2', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(254,205,165) 0%, rgb(254,45,45) 50%, rgb(107,0,62) 100%)',
									),
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-3', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_3', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 3', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(255,203,112) 0%, rgb(199,81,192) 50%, rgb(65,88,208) 100%)',
									),
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-4', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_4', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 4', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(255,245,203) 0%, rgb(182,227,212) 50%, rgb(51,167,181) 100%)',
									),
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-5', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_5', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 5', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(202,248,128) 0%, rgb(113,206,126) 100%)',
									),
									array(
										'type'    => 'gradient',
										'var'     => sprintf( '%s-gradient-preset-6', $hypermarket->slug ),
										'id'      => sprintf( '%s_gradient_preset_6', self::$setting_prefix ),
										'label'   => esc_html__( 'Preset 6', 'hypermarket' ),
										'default' => 'linear-gradient(to right, rgb(2,3,129) 0%, rgb(40,116,252) 100%)',
									),
								),
							),
						),
					),
					'font' => array(
						'has_css'     => true,
						'type'        => 'range',
						'title'       => __( 'Fonts', 'hypermarket' ),
						'description' => __( 'Implies the font size changes to both site front-end and editor.', 'hypermarket' ),
						'settings'    => array( 
							array(
								'id'       => sprintf( '%s_general_fonts', self::$setting_prefix ),
								'title'    => esc_html__( 'General', 'hypermarket' ),
								'controls' => array(
									array(
										'var'     => sprintf( '%s-general-small', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_small_font', self::$setting_prefix ),
										'label'   => esc_html__( 'Small', 'hypermarket' ),
										'default' => 14,
										'suffix'  => 'px',
										'attrs'   => $font_attrs,
									),
									array(
										'var'     => sprintf( '%s-general-normal', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_normal_font', self::$setting_prefix ),
										'label'   => esc_html__( 'Normal', 'hypermarket' ),
										'default' => 16,
										'suffix'  => 'px',
										'attrs'   => $font_attrs,
									),
									array(
										'var'     => sprintf( '%s-general-medium', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_medium_font', self::$setting_prefix ),
										'label'   => esc_html__( 'Medium', 'hypermarket' ),
										'default' => 23,
										'suffix'  => 'px',
										'attrs'   => $font_attrs,
									),
									array(
										'var'     => sprintf( '%s-general-large', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_large_font', self::$setting_prefix ),
										'label'   => esc_html__( 'Large', 'hypermarket' ),
										'default' => 26,
										'suffix'  => 'px',
										'attrs'   => $font_attrs,
									),
									array(
										'var'     => sprintf( '%s-general-huge', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_huge_font', self::$setting_prefix ),
										'label'   => esc_html__( 'Huge', 'hypermarket' ),
										'default' => 37,
										'suffix'  => 'px',
										'attrs'   => $font_attrs,
									),
								),
							),
						),
					),
					'layout' => array(
						'title'       => __( 'Layout', 'hypermarket' ),
						'description' => __( 'This section gives you creative control of style and layout options for your theme.', 'hypermarket' ),
						'settings'    => array(
							array(
								'id'             => sprintf( '%s_general_layout', self::$setting_prefix ),
								'title'          => esc_html__( 'General', 'hypermarket' ),
								'controls'       => array(
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_general_is_tagline', self::$setting_prefix ),
										'label'          => esc_html__( 'Display tagline', 'hypermarket' ),
										'description'    => esc_html__( 'Outputs the short description entered within the "Site Identity" section.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_general_is_fluid', self::$setting_prefix ),
										'label'          => esc_html__( 'Fluid width', 'hypermarket' ),
										'description'    => esc_html__( 'The container element will have a percentage width and can, therefore, adjust according to resolution.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_general_sidebar_before', self::$setting_prefix ),
										'label'          => esc_html__( 'Sidebar before content', 'hypermarket' ),
										'description'    => esc_html__( 'Enabling this option will place the sidebar to appear before the main content.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_general_sidebar_sticky', self::$setting_prefix ),
										'label'          => esc_html__( 'Sticky sidebar', 'hypermarket' ),
										'description'    => esc_html__( 'Stick the sidebar area to the top of the browser window as visitor scrolls down the page.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_general_ajax_pagination', self::$setting_prefix ),
										'label'          => esc_html__( 'AJAX pagination', 'hypermarket' ),
										'description'    => esc_html__( 'Render the next page once clicked on the "Load More" button, saving users from a full page load or refresh.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'theme_supports' => 'woocommerce',
										'id'             => sprintf( '%s_general_products_slider', self::$setting_prefix ),
										'label'          => esc_html__( 'Products carousel', 'hypermarket' ),
										'description'    => esc_html__( 'This option replaces the default grid layout in "Related", "Upsell", and "Cross-sell" sections with a carousel slider.', 'hypermarket' ),
									),
								),
							),
							array(
								'id'             => sprintf( '%s_wc_catalog', self::$setting_prefix ),
								'title'          => esc_html__( 'Product Catalog', 'hypermarket' ),
								'theme_supports' => 'woocommerce',
								'controls'       => array(
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_catalog_featured_flash', self::$setting_prefix ),
										'label'          => esc_html__( 'Display "Featured" flash', 'hypermarket' ),
										'description'    => esc_html__( 'The flash (badge) will be shown on products that are featured.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_catalog_new_flash', self::$setting_prefix ),
										'label'          => esc_html__( 'Display "New" flash', 'hypermarket' ),
										'description'    => esc_html__( 'The flash (badge) will be shown on products that were published in the last 30 days.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_catalog_stock', self::$setting_prefix ),
										'label'          => esc_html__( 'Display stock status', 'hypermarket' ),
										'description'    => esc_html__( 'Append the product stock status to the loop items.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_catalog_categories', self::$setting_prefix ),
										'label'          => esc_html__( 'Display categories', 'hypermarket' ),
										'description'    => esc_html__( 'Append the product categories to the loop items.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_catalog_image_flipper', self::$setting_prefix ),
										'label'          => esc_html__( 'Product image flipper', 'hypermarket' ),
										'description'    => esc_html__( 'Add a secondary product thumbnail that is revealed when you hover over the main product image.', 'hypermarket' ),
									),
								),
							),
							array(
								'id'             => sprintf( '%s_wc_details', self::$setting_prefix ),
								'title'          => esc_html__( 'Product Details', 'hypermarket' ),
								'theme_supports' => 'woocommerce',
								'controls'       => array(
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_details_disable_zoom', self::$setting_prefix ),
										'label'          => esc_html__( 'Thumbnail zoom', 'hypermarket' ),
										'description'    => esc_html__( 'Disable zooming effect that triggers by hovering over the product feature image.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_details_navigation', self::$setting_prefix ),
										'label'          => esc_html__( 'Product navigation', 'hypermarket' ),
										'description'    => esc_html__( 'Previous and next product navigation buttons from same collection on product page.', 'hypermarket' ),
									),
									array(
										'type'           => 'checkbox',
										'id'             => sprintf( '%s_wc_details_sticky_add_to_cart', self::$setting_prefix ),
										'label'          => esc_html__( 'Sticky add to cart', 'hypermarket' ),
										'description'    => esc_html__( 'A content bar at the top of the browser window which includes the product name, price, rating, stock status and the add to cart button.', 'hypermarket' ),
									),
								),
							),
						),
					),
				) 
			);

			return (array) $settings;
		}

		/**
		 * Returns an array of the desired Customizer controls.
		 *
		 * @since   2.0.0
		 * @param   string $control     Optional. Customizer section id.
		 * @return  array
		 */
		public static function get_controls( $control = null ) {
			$controls = self::get_default_settings();

			if ( is_array( $controls ) && ! is_null( $control ) && isset( $controls[ $control ] ) ) {
				return $controls[ $control ];
			}

			return $controls;
		}

		/**
		 * Filter controls based on the given (control) type definition.
		 *
		 * @since   2.0.0
		 * @param   array       $controls                 A list of controls.
		 * @param   string      $type           Optional. Type of the control.
		 * @param   bool|string $type_value     Optional. Value of the control type.
		 * @return  array
		 */
		public static function get_controls_by_type( $controls, $type = null, $type_value = false ) {
			$controls = array_filter(
				$controls,
				// phpcs:ignore PHPCompatibility.FunctionDeclarations.NewClosure.Found
				function( $controls ) use ( $type, $type_value ) { 
					if ( ! $type_value ) {
						return ! isset( $controls[ $type ] );
					} else {
						return isset( $controls[ $type ] ) && $type_value === $controls[ $type ];
					}
				}
			);

			return $controls;
		}

		/**
		 * Add extra CSS styles to a registered stylesheet.
		 *
		 * @since   2.0.0
		 * @return  string
		 */
		public static function get_css() {
			$return = ':root {';
			$groups = self::get_controls_by_type( self::get_controls(), 'has_css', true );

			if ( is_array( $groups ) && ! empty( $groups ) ) {
				// Loop through Customize groups.
				foreach ( $groups as $group ) {
					if ( isset( $group['settings'] ) ) {
						// Loop through Customize sections.
						foreach ( $group['settings'] as $section ) {
							$controls = isset( $section['controls'] ) ? $section['controls'] : array();
							// Make sure there are at least one control to register!
							if ( is_array( $controls ) && ! empty( $controls ) ) {
								foreach ( $controls as $control ) {
									// Determine if the control id is declared and is different than null.
									if ( isset( $control['id'] ) ) {
										$control_id            = (string) $control['id'];
										$control_var           = (string) $control['var'];
										$control_suffix        = isset( $control['suffix'] ) ? (string) $control['suffix'] : '';
										$control_default_value = isset( $control['default'] ) ? (string) $control['default'] : '';
										$control_value         = (string) get_theme_mod( $control_id, $control_default_value );
										$return               .= sprintf( '--%s: %s;', hypermarket_sanitize( $control_var ), hypermarket_sanitize( $control_value, $group ) . $control_suffix );
									}
								}
							}
						}
					}
				}
			}

			$return .= '}';
			$return  = apply_filters( 'hypermarket_customize_inline_css', $return );
			return hypermarket_minify_inline_css( $return );
		}

		/**
		 * Registers Customizer controls.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $hm_customize   Theme Customizer object.
		 * @param   string               $id             The group id or key name.
		 * @param   string               $class          Theme Customizer control class name.
		 * @return  void
		 */
		private function _register_controls( $hm_customize, $id, $class ) {
			global $hypermarket;
			$capability = 'edit_theme_options';
			$group      = self::get_controls( $id );
			$panel_id   = sprintf( '%s_%s_panel', $hypermarket->slug, $id );

			// Check whether there are any controls to register.
			if ( is_array( $group ) && ! empty( $group ) && isset( $group['settings'] ) ) {
				$group_title       = isset( $group['title'] ) ? (string) $group['title'] : '';
				$group_type        = isset( $group['type'] ) ? (string) $group['type'] : '';
				$group_description = isset( $group['description'] ) ? (string) $group['description'] : '';
				$group_priority    = isset( $group['priority'] ) ? (int) $group['priority'] : 30;

				// Add `Colors` customize panel.
				$hm_customize->add_panel(
					esc_html( $panel_id ),
					array(
						'title'       => esc_html( $group['title'] ),
						'description' => esc_html( $group['description'] ),
						'priority'    => intval( $group_priority ),
						'capability'  => esc_html( $capability ),
					) 
				);

				// List of Customizer controls.
				$controls = isset( $group['settings'] ) ? $group['settings'] : array();
				
				// Loop through Customize sections.
				foreach ( $controls as $section ) {
					// Determine if the section id is declared and is different than null.
					if ( isset( $section['id'] ) ) {
						$section_id             = (string) $section['id'];
						$section_title          = (string) $section['title'];
						$section_theme_supports = isset( $section['theme_supports'] ) ? (string) $section['theme_supports'] : '';
						$section_controls       = (array) $section['controls'];

						// Registers a new customize section.
						$hm_customize->add_section(
							esc_html( $section_id ),
							array(
								'title'          => esc_html( $section_title ),
								'theme_supports' => esc_html( $section_theme_supports ),
								'panel'          => esc_html( $panel_id ),
								'capability'     => esc_html( $capability ),
							) 
						);

						// Make sure there are at least one control to register!
						if ( ! empty( $section_controls ) ) {
							foreach ( $section_controls as $control ) {
								// Determine if the control id is declared and is different than null.
								if ( isset( $control['id'] ) ) {
									$control_id             = (string) $control['id'];
									$control_type           = isset( $control['type'] ) ? (string) $control['type'] : (string) $group_type;
									$control_label          = isset( $control['label'] ) ? (string) $control['label'] : '';
									$control_description    = isset( $control['description'] ) ? (string) $control['description'] : '';
									$control_default_value  = isset( $control['default'] ) ? (string) $control['default'] : '';
									$control_attrs          = isset( $control['attrs'] ) ? (array) array_merge( $control['attrs'], array( 'data-default' => $control_default_value ) ) : array();
									$control_theme_supports = isset( $control['theme_supports'] ) ? (string) $control['theme_supports'] : '';

									// Registers a new customize setting.
									$hm_customize->add_setting(
										esc_html( $control_id ),
										array(
											'type'       => 'theme_mod',
											'transport'  => 'refresh',
											'capability' => 'edit_theme_options',
											// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
											'default'    => apply_filters( sprintf( '%s_default', hypermarket_sanitize( $control_id ) ), hypermarket_sanitize( $control_default_value, $control_type ) ),
											'sanitize_callback' => hypermarket_sanitize_method( $control_type ),
											'theme_supports' => esc_html( $control_theme_supports ),
										) 
									);
									
									// Registers a new customize control.
									$hm_customize->add_control(
										new $class(
											$hm_customize,
											esc_html( $control_id ),
											array(
												'type'     => esc_html( $control_type ),
												'label'    => esc_html( $control_label ),
												'description' => esc_html( $control_description ),
												'section'  => esc_html( $section_id ),
												'settings' => esc_html( $control_id ),
												'input_attrs' => hypermarket_sanitize_array( $control_attrs ),
											) 
										) 
									);
								}
							}
						}
					}
				}
			}
		}
	}
endif;
