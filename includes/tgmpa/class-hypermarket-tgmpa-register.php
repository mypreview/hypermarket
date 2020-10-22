<?php
/**
 * This file represents of the code that Hypermarket theme 
 * would use to register the recommended plugins.
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/tgmpa
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

if ( ! class_exists( 'Hypermarket_TGMPA_Register' ) ) :

	/**
	 * The TGMPA Register class
	 */
	final class Hypermarket_TGMPA_Register {

		/**
		 * Setup class.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'tgmpa_register', array( $this, 'tgmpa_register' ) );
		}

		/**
		 * Registers the required plugins to be installed with Conj theme.
		 *
		 * @since   2.0.0
		 * @return  void
		 */
		public function tgmpa_register() {
			$plugins = apply_filters( 
				'hypermarket_tgmpa_plugins',
				array(
					array(
						'name'    => 'WooCommerce',
						'slug'    => 'woocommerce',
						'version' => '3.4.0',
					),
				) 
			);

			/*
			 * Array of configuration settings. Amend each line as needed.
			 */
			$config = array(
				'id'           => 'hypermarket',           // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.       
				//phpcs:ignore Squiz.PHP.CommentedOutCode.Found, Squiz.Commenting.BlockComment.NoEmptyLineBefore        
				/*
				'strings'      => array(
					'page_title'                      => __( 'Install Required Plugins', 'hypermarket' ),
					'menu_title'                      => __( 'Install Plugins', 'hypermarket' ),
					/* translators: %s: plugin name. * /
					'installing'                      => __( 'Installing Plugin: %s', 'hypermarket' ),
					/* translators: %s: plugin name. * /
					'updating'                        => __( 'Updating Plugin: %s', 'hypermarket' ),
					'oops'                            => __( 'Something went wrong with the plugin API.', 'hypermarket' ),
					'notice_can_install_required'     => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme requires the following plugin: %1$s.',
						'This theme requires the following plugins: %1$s.',
						'hypermarket'
					),
					'notice_can_install_recommended'  => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme recommends the following plugin: %1$s.',
						'This theme recommends the following plugins: %1$s.',
						'hypermarket'
					),
					'notice_ask_to_update'            => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
						'hypermarket'
					),
					'notice_ask_to_update_maybe'      => _n_noop(
						/* translators: 1: plugin name(s). * /
						'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						'hypermarket'
					),
					'notice_can_activate_required'    => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						'hypermarket'
					),
					'notice_can_activate_recommended' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						'hypermarket'
					),
					'install_link'                    => _n_noop(
						'Begin installing plugin',
						'Begin installing plugins',
						'hypermarket'
					),
					'update_link' 					  => _n_noop(
						'Begin updating plugin',
						'Begin updating plugins',
						'hypermarket'
					),
					'activate_link'                   => _n_noop(
						'Begin activating plugin',
						'Begin activating plugins',
						'hypermarket'
					),
					'return'                          => __( 'Return to Required Plugins Installer', 'hypermarket' ),
					'plugin_activated'                => __( 'Plugin activated successfully.', 'hypermarket' ),
					'activated_successfully'          => __( 'The following plugin was activated successfully:', 'hypermarket' ),
					/* translators: 1: plugin name. * /
					'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'hypermarket' ),
					/* translators: 1: plugin name. * /
					'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'hypermarket' ),
					/* translators: 1: dashboard link. * /
					'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'hypermarket' ),
					'dismiss'                         => __( 'Dismiss this notice', 'hypermarket' ),
					'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'hypermarket' ),
					'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'hypermarket' ),

					'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
				),
				*/
			);

			tgmpa( $plugins, $config );
		}
	}

endif;
// End Class.

return new Hypermarket_TGMPA_Register();
