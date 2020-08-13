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
			add_action( 'hypermarket_customize_register_controls', array( $this, 'customize_register_colors' ) );
		}

		/**
		 * Fires once WordPress has loaded, allowing scripts and styles to be initialized.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $wp_customize   Theme Customizer object.
		 * @return  void
		 */
		public function customize_register( $wp_customize ) {
			$wp_customize->add_panel(
				'hypermarket_colors_panel',
				array(
					'priority'    => 30,
					'capability'  => 'edit_theme_options',
					'title'       => __( 'Colors', 'hypermarket' ),
					'description' => __( 'This option allows you to choose a color, view color suggestions, refine with the color picker and apply background color changes.', 'hypermarket' ),
				) 
			);


			do_action( 'hypermarket_customize_register_controls', $wp_customize );
		}

		/**
		 * Registers Customizer color controls.
		 *
		 * @since   2.0.0
		 * @param   WP_Customize_Manager $hm_customize   Theme Customizer object.
		 * @return  void
		 */
		public function customize_register_colors( $hm_customize ) {
			$controls = self::get_customize_controls( 'colors' );

			// Check whether there are any controls to register.
			if ( is_array( $controls ) && ! empty( $controls ) ) {
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
								'panel'      => 'hypermarket_colors_panel',
								'capability' => 'edit_theme_options',
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
											'default'    => apply_filters( sprintf( '%s_default', esc_html( $control_id ) ), sanitize_hex_color( $control_default_value ) ),
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
		public static function get_default_customize_settings() {
			global $hypermarket;
			$setting_prefix = 'hypermarket_customize';
			$settings       = apply_filters(
				'hypermarket_default_customize_values',
				array(
					'colors' => array(
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
		public static function get_customize_controls( $control = null ) {
			$controls = self::get_default_customize_settings();

			if ( is_array( $controls ) && ! is_null( $control ) && isset( $controls[ $control ] ) ) {
				return $controls[ $control ];
			}

			return $controls;
		}
	}
endif;
