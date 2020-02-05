<?php
/**
 * Hypermarket WooCommerce template functions.
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! function_exists( 'hypermarket_before_content' ) ) :
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return 	void
	 */
	function hypermarket_before_content() {
		?><div id="primary" class="content-area">
			<main id="main" class="site-main" role="main"><?php
	}
endif;

if ( ! function_exists( 'hypermarket_after_content' ) ) :
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 */
	function hypermarket_after_content() {
			?></main><!-- #main -->
		</div><!-- #primary --><?php

		do_action( 'hypermarket_sidebar' );
	}
endif;

if ( ! function_exists( 'hypermarket_cart_link_fragment' ) ) :
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  	array 		$fragments 		Fragments to refresh via AJAX.
	 * @return 	array            			Fragments to refresh via AJAX
	 */
	function hypermarket_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		hypermarket_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		ob_start();
		hypermarket_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}
endif;

if ( ! function_exists( 'hypermarket_cart_link' ) ) :
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return 	void
	 */
	function hypermarket_cart_link() {
		?><a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hypermarket' ); ?>"><?php 
			echo wp_kses_post( WC()->cart->get_cart_subtotal() ); // WPCS: XSS ok.
			?><span class="count"><?php 
				/* translators: %d: number of items in cart */
				echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'hypermarket' ), WC()->cart->get_cart_contents_count() ) ); // WPCS: XSS ok.
			?></span>
		</a><?php
	}
endif;

if ( ! function_exists( 'hypermarket_header_cart' ) ) :
	/**
	 * Display Header Cart
	 *
	 * @return 	void
	 */
	function hypermarket_header_cart() {
		if ( hypermarket_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			} // End If Statement
			?><ul id="site-header-cart" class="site-header-cart menu">
				<li class="<?php echo esc_attr( $class ); ?>"><?php 
					hypermarket_cart_link(); 
				?></li>
				<li><?php 
					the_widget( 'WC_Widget_Cart', 'title=' );
				?></li>
			</ul><?php
		}
	}
endif;

if ( ! function_exists( 'hypermarket_upsell_display' ) ) :
	/**
	 * Upsells
	 * Replace the default upsell function with our own which displays the correct number product columns
	 *
	 * @return  void
	 */
	function hypermarket_upsell_display() {
		$columns = apply_filters( 'hypermarket_upsells_columns', 3 );
		woocommerce_upsell_display( -1, $columns );
	}
endif;

if ( ! function_exists( 'hypermarket_sorting_wrapper' ) ) :
	/**
	 * Sorting wrapper
	 *
	 * @return  void
	 */
	function hypermarket_sorting_wrapper() {
		echo '<div class="hypermarket-sorting">';
	}
endif;

if ( ! function_exists( 'hypermarket_sorting_wrapper_close' ) ) :
	/**
	 * Sorting wrapper close
	 *
	 * @return  void
	 */
	function hypermarket_sorting_wrapper_close() {
		echo '</div>';
	}
endif;

if ( ! function_exists( 'hypermarket_shop_messages' ) ) :
	/**
	 * WooCommerce shop messages
	 *
	 * @return  void
	 */
	function hypermarket_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( hypermarket_do_shortcode( 'woocommerce_messages' ) ); // WPCS: XSS ok.
		}
	}
endif;