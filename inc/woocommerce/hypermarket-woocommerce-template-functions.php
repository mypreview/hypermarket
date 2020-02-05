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

if ( ! function_exists( 'hypermarket_woocommerce_pagination' ) ) :
	/**
	 * Hypermarket WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the `woocommerce_product_subcategories()` function
	 * but since Hypermarket adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @return  void
	 */
	function hypermarket_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		} // End If Statement
	}
endif;

if ( ! function_exists( 'hypermarket_promoted_products' ) ) :
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @param 	integer 	$per_page 			Total products to display.
	 * @param 	integer 	$columns 			Columns to arrange products in to.
	 * @param 	boolean 	$recent_fallback 	Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @return 	void
	 */
	function hypermarket_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( hypermarket_is_woocommerce_activated() ) {
			if ( wc_get_featured_product_ids() ) {
				printf( esc_html__( '%sFeatured Products%s', 'hypermarket' ), '<h2>', '</h2>' );

				echo hypermarket_do_shortcode(
					'featured_products', array(
						'per_page' => $per_page,
						'columns'  => $columns
					)
				); // WPCS: XSS ok.
			} elseif ( wc_get_product_ids_on_sale() ) {
				printf( esc_html__( '%sOn Sale Now%s', 'hypermarket' ), '<h2>', '</h2>' );

				echo hypermarket_do_shortcode(
					'sale_products', array(
						'per_page' => $per_page,
						'columns'  => $columns
					)
				); // WPCS: XSS ok.
			} elseif ( $recent_fallback ) {
				printf( esc_html__( '%sNew In Store%s', 'hypermarket' ), '<h2>', '</h2>' );

				echo hypermarket_do_shortcode(
					'recent_products', array(
						'per_page' => $per_page,
						'columns'  => $columns
					)
				); // WPCS: XSS ok.
			}
		}
	}
endif;

if ( ! function_exists( 'hypermarket_handheld_footer_bar' ) ) :
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @return 	void
	 */
	function hypermarket_handheld_footer_bar() {
		$links = array(
			'my-account' => array(
				'priority' => 10,
				'callback' => 'hypermarket_handheld_footer_bar_account_link'
			),
			'search'     => array(
				'priority' => 20,
				'callback' => 'hypermarket_handheld_footer_bar_search'
			),
			'cart'       => array(
				'priority' => 30,
				'callback' => 'hypermarket_handheld_footer_bar_cart_link'
			),
		);

		if ( wc_get_page_id( 'myaccount' ) === -1 ) {
			unset( $links['my-account'] );
		} // End If Statement

		if ( wc_get_page_id( 'cart' ) === -1 ) {
			unset( $links['cart'] );
		} // End If Statement

		$links = apply_filters( 'hypermarket_handheld_footer_bar_links', $links );

		?><div class="hypermarket-handheld-footer-bar">
			<ul class="columns-<?php echo count( $links ); ?>"><?php 
				foreach ( $links as $key => $link ) : 
					?><li class="<?php echo esc_attr( $key ); ?>"><?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						} // End If Statement
					?></li><?php 
				endforeach; 
			?></ul>
		</div><?php
	}
endif;

if ( ! function_exists( 'hypermarket_handheld_footer_bar_search' ) ) :
	/**
	 * The search callback function for the handheld footer bar
	 *
	 * @return 	void
	 */
	function hypermarket_handheld_footer_bar_search() {
		printf( __( '%sSearch%s', 'hypermarket' ), '<a href="#">', '</a>' );
		hypermarket_product_search();
	}
endif;

if ( ! function_exists( 'hypermarket_handheld_footer_bar_cart_link' ) ) :
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @return 	void
	 */
	function hypermarket_handheld_footer_bar_cart_link() {
		?><a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hypermarket' ); ?>">
			<span class="count"><?php 
				echo wp_kses_data( WC()->cart->get_cart_contents_count() ); // WPCS: XSS ok.
			?></span>
		</a><?php
	}
endif;

if ( ! function_exists( 'hypermarket_handheld_footer_bar_account_link' ) ) :
	/**
	 * The account callback function for the handheld footer bar
	 *
	 * @return 	void
	 */
	function hypermarket_handheld_footer_bar_account_link() {
		printf( __( '%sMy Account%s', 'hypermarket' ), sprintf( '<a href="%s">', esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ), '</a>' );
	}
endif;