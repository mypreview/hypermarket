<?php
/**
 * Class to create a Customizer control for displaying upgrade to the paid version information.
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

if ( ! class_exists( 'Hypermarket_Customize_More_Control' ) ) :

	/**
	 * The 'more' Hypermarket control class
	 */
	class Hypermarket_Customize_More_Control extends WP_Customize_Control {

		/**
		 * Renter the control
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		protected function render_content() {
			global $hypermarket;

			?>
			<span class="customize-control-title">
				<?php
				/* translators: %s: Theme name. */
				printf( esc_html__( 'Enjoying %s?', 'hypermarket' ), esc_html( $hypermarket->name ) ); 
				?>
			</span>
			<p>
				<?php
				/* translators: 1: Emoji unicode, 2: Open anchor tag, 3: Close anchor tag, 4: Br tag. */
				printf( esc_html__( 'Why not leave us a %1$s review on %2$sWordPress.org%3$s?%4$sWe&rsquo;d really appreciate it!', 'hypermarket' ), '⭐⭐⭐⭐⭐', sprintf( '<a href="https://wordpress.org/support/theme/%s/reviews/#new-post" target="_blank" rel="noopener noreferrer nofollow">', esc_html( $hypermarket->slug ) ), '</a>', '<br/>' ); 
				?>
			</p>
			<hr />
			<span class="customize-control-title">
				<?php
				/* translators: %s: Theme name. */
				printf( esc_html__( 'Contribute to %s?', 'hypermarket' ), esc_html( $hypermarket->name ) ); 
				?>
			</span>
			<p>
				<?php 
				/* translators: 1: Emoji unicode, 2: Open anchor tag, 3: Close anchor tag. */
				printf( esc_html__( 'If you&rsquo;ve stumbled upon an issue (bug) %1$s with the functionality (and you do not know how to fix it), have trouble following the documentation or have a question about hooks (filters and actions) used in the theme &mdash; %2$screate an issue%3$s!', 'hypermarket' ), '🐛🐞', sprintf( '<a href="https://github.com/mypreview/%s" target="_blank" rel="noopener noreferrer nofollow">', esc_html( $hypermarket->slug ) ), '</a>' ); 
				?>
			</p>
			<?php
		}
	}
endif;
