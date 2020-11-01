<?php
/**
 * Class to create a configurable solid/gradient color picker.
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

if ( ! class_exists( 'Hypermarket_Customize_Color_Control' ) ) :

	/**
	 * The color control class
	 */
	class Hypermarket_Customize_Color_Control extends WP_Customize_Color_Control {
		
		/**
		 * The settings control type.
		 *
		 * @access  public
		 * @var     string      $type       Type of the control.
		 */
		public $type = 'color';

		/**
		 * Renter the control
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function render_content() {
			?>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<span class="customize-control-description description">
				<?php echo wp_kses_post( $this->description ); ?>
			</span>
			<div class="customize-control-gradient">
				<div class="customize-control-gradient__picker"></div>
				<input 
					type="hidden" 
					class="customize-control-gradient__field"
					value="<?php echo absint( $this->value() ); ?>" 
					<?php 
					$this->input_attrs();
					$this->link(); 
					?>
				/>
			</div>
			<?php
		}
	}
endif;
