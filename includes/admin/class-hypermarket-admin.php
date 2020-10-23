<?php
/**
 * Hypermarket Admin Class.
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_Admin' ) ) :

	/**
	 * The Hypermarket admin class
	 */
	final class Hypermarket_Admin {

		/**
		 * The slug name to refer to this menu by.
		 *
		 * @access  public
		 * @var     string      $welcome_slug       The slug name.
		 */
		public static $welcome_slug = 'hypermarket-welcome';

		/**
		 * Setup class.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'register_welcome_page' ) );
		}

		/**
		 * Adds submenu page to the Appearance main menu.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function register_welcome_page() {
			add_theme_page( 'Hypermarket', 'Hypermarket', 'activate_plugins', self::$welcome_slug, array( $this, 'welcome_screen' ) );
		}

		/**
		 * Outputs the content for the welcome screen page.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function welcome_screen() {
			global $hypermarket;
			$embed = new WP_Embed();
			?>
			<section class="wrap about-wrap <?php echo sanitize_html_class( self::$welcome_slug ); ?>" role="complementary">
				<?php
					/**
					 * Functions hooked into `hypermarket_welcome_top` action
					 *
					 * @hooked  hypermarket_welcome_header         - 10
					 */
					do_action( 'hypermarket_welcome_top' );

					/**
					 * Functions hooked into `hypermarket_welcome_content` action
					 *
					 * @hooked  hypermarket_welcome_tabs           - 10
					 */
					do_action( 'hypermarket_welcome_content' );

					do_action( 'hypermarket_welcome_bottom' );
				?>
			</section>
			<?php
		}
	}
endif;
