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
		<div class="tabs nav-tab-wrapper <?php echo sanitize_html_class( $classname ); ?>__tabs" data-toggle="tabslet" data-animation="true" data-autorotate="false">
			<ul class="tab-links">
				<li>
					<a href="#welcome" class="nav-tab nav-tab-active">
						<?php echo esc_html_e( 'Welcome', 'hypermarket' ); ?>
					</a>
				</li>
				<li>
					<a href="#extensions" class="nav-tab">
						<?php echo esc_html_e( 'Recommended Extensions', 'hypermarket' ); ?>
					</a>
				</li>
			</ul>

			<?php 
			
			/**
			 * Functions hooked into `hypermarket_welcome_tab_content` action
			 *
			 * @hooked  hypermarket_welcome_tab            - 10
			 * @hooked  hypermarket_extensions_tab         - 20
			 */
			do_action( 'hypermarket_welcome_tab_content' ); 
			
			?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_welcome_tab' ) ) :
	/**
	 * Display `Recommended Extensions` tab content.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_welcome_tab() {
		$classname = (string) Hypermarket_Admin::$welcome_slug;
		?>
		<div id="welcome" class="<?php echo sanitize_html_class( $classname ); ?>__intro">
			Welcome!
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_extensions_tab' ) ) :
	/**
	 * Display `Recommended Extensions` tab content.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_extensions_tab() {
		$classname = (string) Hypermarket_Admin::$welcome_slug;
		?>
		<div id="extensions" class="<?php echo sanitize_html_class( $classname ); ?>__extensions">
			<ul></ul>
			<div class="spinner is-active alignleft"></div>
		</div>
		<?php
	}
endif;
