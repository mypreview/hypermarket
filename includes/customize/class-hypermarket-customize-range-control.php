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
				<input 
					type="range" 
					class="customize-control-range__field"
					value="<?php echo absint( $this->value() ); ?>" 
					<?php 
					$this->input_attrs();
					$this->link(); 
					?>
				/>
				<div class="customize-control-range__action">
					<span class="customize-control-range__value">
						<?php echo absint( $this->value() ); ?>
					</span>
					<a href="#" class="customize-control-range__reset" aria-label="<?php esc_attr_e( 'Restore to default', 'hypermarket' ); ?>">
						<span class="dashicons dashicons-image-rotate"></span>
					</a>
				</div>
			</div>
			<?php
		}
	}
endif;
