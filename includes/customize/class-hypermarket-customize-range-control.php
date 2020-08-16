<?php
/**
 * Class to create a generic range with value control you can use to replace the range control.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/customize
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_Customize_Range_Control' ) ) :

	/**
	 * The range control class
	 */
	class Hypermarket_Customize_Range_Control extends WP_Customize_Control {

		/**
		 * Renter the control
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		protected function render_content() {
			?>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<span class="customize-control-description description">
				<?php echo wp_kses_post( $this->description ); ?>
			</span>
			<div class="customize-control-range">
				<span>
					<input 
						type="range" 
						class="customize-control-range__field"
						value="<?php echo esc_attr( $this->value() ); ?>" 
						<?php 
						$this->input_attrs();
						$this->link(); 
						?>
					 />
					<span class="customize-control-range__value">
						<?php echo intval( 0 ); ?>
					</span>
				</span>
			</div>
			<?php
		}
	}
endif;
