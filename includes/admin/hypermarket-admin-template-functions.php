<?php
/**
 * Hypermarket admin template functions.
 *
 * @since       2.0.0
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! function_exists( 'hypermarket_welcome_header' ) ) :
	/**
	 * Display page header.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_welcome_header() {
		global $hypermarket;
		$classname = (string) Hypermarket_Admin::$welcome_slug;
		?>
		<div class="wrap__col">
			<h1 class="<?php echo sanitize_html_class( $classname ); ?>__title">
				<strong>
					<?php echo esc_html( $hypermarket->name ); ?>
				</strong>
				<sup class="version">
					<?php echo esc_html( $hypermarket->version ); ?>
				</sup>
			</h1>
			<p class="<?php echo sanitize_html_class( $classname ); ?>__tagline">
				<?php echo esc_html_x( 'Minimal, fast, and free!', 'theme tagline', 'hypermarket' ); ?>
			</p>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_welcome_tabs' ) ) :
	/**
	 * Display tabs.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_welcome_tabs() {
		$classname = (string) Hypermarket_Admin::$welcome_slug;
		?>
		<div class="nav-tab-wrapper <?php echo sanitize_html_class( $classname ); ?>__tabs">
			<a href="#" class="nav-tab nav-tab-active" data-tab="welcome">
				<?php echo esc_html_e( 'Welcome', 'hypermarket' ); ?>
			</a>
			<a href="#" class="nav-tab" data-tab="extensions">
				<?php echo esc_html_e( 'Recommended Extensions', 'hypermarket' ); ?>
			</a>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_welcome_extensions' ) ) :
	/**
	 * Display `Recommended Extensions` tab content.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_welcome_extensions() {
		$classname = (string) Hypermarket_Admin::$welcome_slug;
		?>
		<div class="<?php echo sanitize_html_class( $classname ); ?>__extensions">
			<ul></ul>
			<div class="spinner is-active alignleft"></div>
		</div>
		<?php
	}
endif;
