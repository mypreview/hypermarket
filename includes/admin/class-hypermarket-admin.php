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
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_action( 'admin_menu', array( $this, 'register_welcome_page' ) );
		}

		/**
		 * Enqueue scripts for admin pages.
		 *
		 * @since   2.0.0
		 * @param   string $hook_suffix      Hook suffix for the current admin page.
		 * @return  void
		 * @phpcs:disable WordPress.NamingConventions.ValidHookName.UseUnderscores, WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
		 */
		public function enqueue( $hook_suffix ) {
			$asset_name    = 'admin';
			$asset         = hypermarket_get_file_assets( $asset_name );
			$style_handle  = hypermarket_get_asset_handle( $asset_name, 'style' );
			$script_handle = hypermarket_get_asset_handle( $asset_name, 'script' );
			$l10n          = apply_filters(
				sprintf( 'hypermarket_%s_l10n_args', $asset_name ),
				array(
					'install_uri'  => wp_nonce_url( hypermarket_get_admin_url( 'plugin-install.php' ) ),
				) 
			);

			// Styles.
			wp_register_style( $style_handle, get_theme_file_uri( sprintf( '/dist/%s.css', $asset_name ) ), '', $asset['version'], 'all' );
			wp_style_add_data( $style_handle, 'rtl', 'replace' );
			// Scripts.
			wp_register_script( $script_handle, get_theme_file_uri( sprintf( '/dist/%s.js', $asset_name ) ), $asset['dependencies'], $asset['version'], true );
			wp_localize_script( $script_handle, sprintf( 'hypermarket_%s', $asset_name ), $l10n );

			if ( sprintf( 'appearance_page_%s', self::$welcome_slug ) === $hook_suffix ) {
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_style( $style_handle );
				wp_enqueue_script( $script_handle );
			}
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
