<?php
/**
 * Hypermarket Customizer Class.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/customizer
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
		 * Setup class.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'hypermarket_customize_register_controls', array( $this, 'register_colors' ) );
		}

		/**
		 * Fires once WordPress has loaded, allowing scripts and styles to be initialized.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $wp_customize   Theme Customizer object.
		 * @return  void
		 */
		public function customize_register( $wp_customize ) {
			do_action( 'hypermarket_customize_register_controls', $wp_customize );
		}

		/**
		 * Registers Customizer color controls.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $hm_customize   Theme Customizer object.
		 * @return  void
		 */
		public function register_colors( $hm_customize ) {
			global $hypermarket;
			$id         = 'color';
			$capability = 'edit_theme_options';
			$group      = self::get_controls( $id );
			$panel_id   = sprintf( '%s_%s_panel', $hypermarket->slug, $id );

			// Check whether there are any controls to register.
			if ( is_array( $group ) && ! empty( $group ) && isset( $group['settings'] ) ) {
				$group_title       = (string) isset( $group['title'] ) ? $group['title'] : '';
				$group_description = (string) isset( $group['description'] ) ? $group['description'] : '';
				$group_priority    = (int) isset( $group['priority'] ) ? $group['priority'] : 30;

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
						$section_id       = (string) $section['id'];
						$section_title    = (string) $section['title'];
						$section_controls = (array) $section['controls'];

						// Registers a new customize section.
						$hm_customize->add_section(
							esc_html( $section_id ),
							array(
								'title'      => esc_html( $section_title ),
								'panel'      => esc_html( $panel_id ),
								'capability' => esc_html( $capability ),
							) 
						);

						// Make sure there are at least one control to register!
						if ( ! empty( $section_controls ) ) {
							foreach ( $section_controls as $control ) {
								// Determine if the control id is declared and is different than null.
								if ( isset( $control['id'] ) ) {
									$control_id            = (string) $control['id'];
									$control_label         = (string) isset( $control['label'] ) ? $control['label'] : '';
									$control_description   = (string) isset( $control['description'] ) ? $control['description'] : '';
									$control_default_value = (string) isset( $control['default'] ) ? $control['default'] : '#ffffff';

									// Registers a new customize setting.
									$hm_customize->add_setting(
										esc_html( $control_id ),
										array(
											'type'       => 'theme_mod',
											'transport'  => 'refresh',
											'capability' => 'edit_theme_options',
											// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
											'default'    => apply_filters( sprintf( '%s_default', self::get_sanitized( '', $control_id ) ), self::get_sanitized( $group, $control_default_value ) ),
											'sanitize_callback' => 'sanitize_hex_color',
										) 
									);
									
									// Registers a new customize control.
									$hm_customize->add_control(
										new WP_Customize_Color_Control(
											$hm_customize,
											esc_html( $control_id ),
											array(
												'label'    => esc_html( $control_label ),
												'description' => esc_html( $control_description ),
												'section'  => esc_html( $section_id ),
												'settings' => esc_html( $control_id ),
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

		/**
		 * Returns an array of the desired default Customizer options.
		 *
		 * @since   2.0.0
		 * @return  array
		 */
		public static function get_default_settings() {
			global $hypermarket;
			$setting_prefix = 'hypermarket_customize';
			$settings       = apply_filters(
				'hypermarket_default_customize_values',
				array(
					'color' => array(
						'title'       => __( 'Colors', 'hypermarket' ),
						'description' => __( 'This option allows you to choose a color, view color suggestions, refine with the color picker and apply background color changes.', 'hypermarket' ),
						'settings'    => array( 
							array(
								'id'       => sprintf( '%s_general_colors', $setting_prefix ),
								'title'    => esc_html__( 'General', 'hypermarket' ),
								'controls' => array(
									array(
										'var'     => sprintf( '%s-general-primary', $hypermarket->slug ),
										'id'      => sprintf( '%s_general_primary_color', $setting_prefix ),
										'label'   => esc_html__( 'Primary', 'hypermarket' ),
										'default' => '#77cde3',
									),
								),
							),
							array(
								'id'       => sprintf( '%s_alert_colors', $setting_prefix ),
								'title'    => esc_html__( 'Alert', 'hypermarket' ),
								'controls' => array(
									array(
										'var'     => sprintf( '%s-alert-info', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_info_color', $setting_prefix ),
										'label'   => esc_html__( 'Info', 'hypermarket' ),
										'default' => '#93c4ef',
									),
									array(
										'var'     => sprintf( '%s-alert-success', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_success_color', $setting_prefix ),
										'label'   => esc_html__( 'Success', 'hypermarket' ),
										'default' => '#a7c04d',
									),
									array(
										'var'     => sprintf( '%s-alert-warning', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_warning_color', $setting_prefix ),
										'label'   => esc_html__( 'Warning', 'hypermarket' ),
										'default' => '#ffce2b',
									),
									array(
										'var'     => sprintf( '%s-alert-danger', $hypermarket->slug ),
										'id'      => sprintf( '%s_alert_danger_color', $setting_prefix ),
										'label'   => esc_html__( 'Danger', 'hypermarket' ),
										'default' => '#ef0568',
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
		 * Add extra CSS styles to a registered stylesheet.
		 *
		 * @since   2.0.0
		 * @return  string
		 */
		public static function get_css() {
			$return = ':root {';
			$groups = self::get_controls();

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
										$control_default_value = (string) isset( $control['default'] ) ? $control['default'] : '';
										$control_value         = (string) get_theme_mod( $control_id, $control_default_value );

										$return .= sprintf( '--%s: %s;', self::get_sanitized( '', $control_var ), self::get_sanitized( $group, $control_value ) );
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
		 * Sanitize an input.
		 *
		 * @param  string     $group   Optional. The group id of the control.
		 * @param  int|string $input             The value to sanitize.
		 * @return mixed
		 */
		public static function get_sanitized( $group = '', $input ) {
			$return = '';

			switch ( $group ) {
				case 'color':
					// Sanitizes a hex color.
					$return = sanitize_hex_color( $input );
					break;
				default:
					// Escaping for HTML blocks.
					$return = esc_html( $input );
					break;
			}

			return $return;
		}
	}
endif;
