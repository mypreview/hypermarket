<?php
/**
 * Hypermarket WooCommerce functions.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/woocommerce
 */

if ( ! function_exists( 'hypermarket_is_product_archive' ) ) :
	/**
	 * Checks if the current page is a product archive.
	 *
	 * @since   2.0.0
	 * @return  bool
	 */
	function hypermarket_is_product_archive() {
		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_is_cart_available' ) ) {
	/**
	 * Validates whether the WooCommerce Cart instance is available in the request.
	 *
	 * @since   2.0.0
	 * @return  bool
	 */
	function hypermarket_is_cart_available() {
		$woo = WC();
		
		return ( $woo instanceof WooCommerce ) && ( $woo->cart instanceof WC_Cart );
	}
}

if ( ! function_exists( 'hypermarket_get_previous_product' ) ) :
	/**
	 * Retrieves the previous product.
	 *
	 * @since   2.0.0
	 * @param   bool         $in_same_term       Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param   array|string $excluded_terms     Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param   string       $taxonomy           Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @return  WC_Product|false                           Product object if successful. False if no valid product is found.
	 */
	function hypermarket_get_previous_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new Hypermarket_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy, true );
		return $product->get_product();
	}
endif;

if ( ! function_exists( 'hypermarket_get_next_product' ) ) :
	/**
	 * Retrieves the next product.
	 *
	 * @since   2.0.0
	 * @param   bool         $in_same_term       Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param   array|string $excluded_terms     Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param   string       $taxonomy           Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @return  WC_Product|false                           Product object if successful. False if no valid product is found.
	 */
	function hypermarket_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new Hypermarket_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product();
	}
endif;

if ( ! function_exists( 'hypermarket_myaccount_link' ) ) :
	/**
	 * Myaccount page link.
	 * Displayed a link to the myaccount page.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_myaccount_link() {
		/* translators: 1: Open anchor tag, 2: Close anchor tag. */
		printf( esc_html__( '%1$sMy Account%2$s', 'hypermarket' ), sprintf( '<a href="%s" class="%s" title="%s">', esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ), 'site-myaccount', esc_attr__( 'View your account page', 'hypermarket' ) ), '</a>' );
	}
endif;

if ( ! function_exists( 'hypermarket_cart_link' ) ) :
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_cart_link() {
		// Bail early, in case the WooCommerce cart is not available.
		if ( ! hypermarket_is_cart_available() ) {
			return;
		}

		$cart_contents_count = (int) WC()->cart->get_cart_contents_count();

		?><a class="site-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hypermarket' ); ?>">
			<?php 
			echo wp_kses_post( WC()->cart->get_cart_subtotal() );
			if ( $cart_contents_count ) : 
				?>
				<span class="site-cart-contents__count">
					<?php echo intval( WC()->cart->get_cart_contents_count() ); ?>
				</span>
			<?php endif; ?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_product_search' ) ) :
	/**
	 * Display product search
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_product_search() {
		?>
		<div class="site-search">
		<?php 
			/* translators: 1: Open anchor tag, 2: Close anchor tag. */
			printf( esc_html__( '%1$sSearch%2$s', 'hypermarket' ), '<a href="#">', '</a>' );
			the_widget( 'WC_Widget_Product_Search', 'title=' ); 
		?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_cart' ) ) :
	/**
	 * Display Header Cart.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<div class="site-header__cart">
			<ul>
				<li class="<?php echo sanitize_html_class( $class ); ?>">
					<?php hypermarket_cart_link(); ?>
				</li>
				<li>
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</li>
			</ul>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_promoted_products' ) ) :
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @since   2.0.0
	 * @param   integer $per_page           Optional. Total products to display.
	 * @param   integer $columns            Optional. Columns to arrange products in to.
	 * @param   boolean $recent_fallback    Optional. Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @return  void
	 */
	function hypermarket_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( hypermarket_is_woocommerce_activated() ) {
			if ( wc_get_featured_product_ids() ) {
				/* translators: 1: Open h2 tag, Close h2 tag. */
				printf( esc_html__( '%1$sFeatured Products%2$s', 'hypermarket' ), '<h2>', '</h2>' );

				//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo hypermarket_do_shortcode(
					'featured_products',
					array(
						'per_page' => $per_page,
						'columns'  => $columns,
					)
				); 
			} elseif ( wc_get_product_ids_on_sale() ) {
				/* translators: 1: Open h2 tag, Close h2 tag. */
				printf( esc_html__( '%1$sOn Sale Now%2$s', 'hypermarket' ), '<h2>', '</h2>' );

				//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo hypermarket_do_shortcode(
					'sale_products',
					array(
						'per_page' => $per_page,
						'columns'  => $columns,
					)
				); 
			} elseif ( $recent_fallback ) {
				/* translators: 1: Open h2 tag, Close h2 tag. */
				printf( esc_html__( '%1$sNew In Store%2$s', 'hypermarket' ), '<h2>', '</h2>' );

				//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo hypermarket_do_shortcode(
					'recent_products',
					array(
						'per_page' => $per_page,
						'columns'  => $columns,
					)
				); 
			}
		}
	}
endif;

if ( ! function_exists( 'hypermarket_customer_fullname' ) ) :
	/**
	 * Display customer’s full-name.
	 *
	 * @since   2.0.0
	 * @param   integer $user_id    Optional. The current user’s ID.
	 * @param   bool    $echo       Optional. Echo the string or return it.
	 * @return  string
	 */
	function hypermarket_customer_fullname( $user_id = null, $echo = true ) {
		$user_id    = is_null( $user_id ) ? get_current_user_id() : $user_id;
		$first_name = get_user_meta( $user_id, 'billing_first_name', true );
		$last_name  = get_user_meta( $user_id, 'billing_last_name', true );
		$return     = sprintf( '%s %s', esc_html( $first_name ), esc_html( $last_name ) );

		if ( $echo ) {
			//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $return; 
		}

		return $return;
	}
endif;

if ( ! function_exists( 'hypermarket_get_gallery_image_ids' ) ) :
	/**
	 * Get product gallery image ids.
	 *
	 * @param   object $product    Current product object.
	 * @return  array
	 */
	function hypermarket_get_gallery_image_ids( $product ) {
		// Bail out if the current parameter is NOT a product.
		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}

		if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
			return $product->get_gallery_image_ids();
		} else {
			return $product->get_gallery_attachment_ids();
		}
	}
endif;
