<?php
/**
 * Class to create a custom arbitrary html control for dividers etc.
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

if ( ! class_exists( 'Hypermarket_Arbitrary_Customize_Control' ) ) :

	/**
	 * The arbitrary control class
	 */
	class Hypermarket_Arbitrary_Customize_Control extends WP_Customize_Control {

		/**
		 * The settings var
		 *
		 * @var string $settings
		 */
		public $settings = 'blogname';

		/**
		 * The description var
		 *
		 * @var string $description
		 */
		public $description = '';

		/**
		 * The CSS class var
		 *
		 * @var string $classname
		 */
		public $classname = '';

		/**
		 * The dashicon var
		 *
		 * @var string $dashicon
		 */
		public $dashicon = '';

		/**
		 * Renter the control
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		protected function render_content() {
			switch ( $this->type ) :
				default:
					// Call-out.
				case 'callout': 
					printf( '<div class="customize-control-callout %1$s"><div class="heading"><span class="customize-control-title">%2$s</span><span class="customize-control-dashicon"><i class="dashicon %3$s"></i></span></div>', esc_attr( $this->classname ), esc_html( $this->label ), esc_attr( $this->dashicon ) );
					// Append description if there is any to display!
					if ( $this->description ) {
						printf( '<div class="description %1$s">%2$s</div>', esc_attr( $this->classname ), wp_kses_post( $this->description ) );
					}
					?>
					</div>
					<?php
					break;
				// Notice.
				case 'notice':
					printf( '<div class="customize-control-notice"><span class="dashicons dashicons-info"></span>%s</div>', wp_kses_post( $this->description ) );
					break;
				// Arbitrary text.
				case 'text':
					printf( '<p class="description">%s</p>', wp_kses_post( $this->description ) );
					break;
				// Arbitrary heading.
				case 'heading':
					printf( '<span class="customize-control-title">%s</span>', esc_html( $this->label ) );
					break;
				// Divider.
				case 'divider':
					?>
					<hr style="margin:1em 0;" />
					<?php
					break;
			endswitch;
		}
	}
endif;
