<?php
/**
 * Hypermarket WooCommerce template functions.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes/woocommerce
 */

if ( ! function_exists( 'hypermarket_shop_messages' ) ) :
	/**
	 * WooCommerce shop messages.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( hypermarket_do_shortcode( 'woocommerce_messages' ) );
		}
	}
endif;

if ( ! function_exists( 'hypermarket_breadcrumb' ) ) :
	/**
	 * Outputs WooCommerce breadcrumbs.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_breadcrumb() {
		global $post;
		$breadcrumbs = apply_filters( 'hypermarket_has_breadcrumbs', true );
		
		// Bail early if the breadcrumbs has been removed from the view.
		if ( ! ! ! $breadcrumbs || ! ! hypermarket_get_post_meta( 'breadcrumbs', $post->ID ) ) {
			return;
		}

		woocommerce_breadcrumb();
	}
endif;

if ( ! function_exists( 'hypermarket_before_content' ) ) :
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_before_content() {
		?><div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
			do_action( 'hypermarket_shop_archive_top' );
	}
endif;

if ( ! function_exists( 'hypermarket_after_content' ) ) :
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_after_content() {
		do_action( 'hypermarket_shop_archive_bottom' );
		?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_cart_link_fragment' ) ) :
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @since   2.0.0
	 * @param   array $fragments      Fragments to refresh via AJAX.
	 * @return  array
	 */
	function hypermarket_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		hypermarket_cart_link();
		$fragments['a.site-cart-contents'] = ob_get_clean();

		return $fragments;
	}
endif;

if ( ! function_exists( 'hypermarket_cart_update_button' ) ) :
	/**
	 * Display `Update cart` button on the cart page.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_cart_update_button() {
		?>
		<button type="submit" class="button" name="hypermarket-update-cart" value="<?php esc_attr_e( 'Update cart', 'hypermarket' ); ?>">
			<?php esc_html_e( 'Update cart', 'hypermarket' ); ?>
		</button>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_button_proceed_to_checkout' ) ) :
	/**
	 * Output the `Proceed to Checkout` button.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_button_proceed_to_checkout() {
		?>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
			<?php echo esc_html_x( 'Checkout', 'proceed to checkout button', 'hypermarket' ); ?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_button_back_to_cart' ) ) :
	/**
	 * Output the `Back to Cart` button.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_button_back_to_cart() {
		?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button place-order__back-to-cart">
			<?php esc_html_e( 'Back to cart', 'hypermarket' ); ?>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_handheld_toolbar' ) ) :
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_handheld_toolbar() {
		$links = array(
			'myaccount' => array(
				'priority' => 10,
				'callback' => 'hypermarket_myaccount_link',
			),
			'search' => array(
				'priority' => 20,
				'callback' => 'hypermarket_product_search',
			),
			'cart' => array(
				'priority' => 30,
				'callback' => 'hypermarket_cart_link',
			),
		);

		if ( -1 === wc_get_page_id( 'myaccount' ) ) {
			unset( $links['myaccount'] );
		}

		if ( -1 === wc_get_page_id( 'cart' ) ) {
			unset( $links['cart'] );
		}

		$links = apply_filters( 'hypermarket_handheld_toolbar_links', $links );

		?>
		<div class="site-handheld-toolbar sticky sticky--bottom">
			<ul class="columns-<?php echo count( $links ); ?>">
				<?php 
				foreach ( $links as $key => $link ) : 
					?>
					<li class="site-handheld-toolbar__<?php echo esc_attr( $key ); ?>">
						<?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						}
						?>
					</li>
					<?php 
				endforeach; 
				?>
			</ul>
		</div>
		<?php
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

if ( ! function_exists( 'hypermarket_quantity_minus_btn' ) ) :
	/**
	 * Quantity minus (decrement) button.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_quantity_minus_btn() {
		?>
		<button type="button" class="qty-minus bx-minus" aria-label="<?php esc_attr_e( 'Remove from the quantity', 'hypermarket' ); ?>"></button>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_quantity_plus_btn' ) ) :
	/**
	 * Quantity plus (increment) button.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_quantity_plus_btn() {
		?>
		<button type="button" class="qty-plus bx-plus" aria-label="<?php esc_attr_e( 'Add to the quantity', 'hypermarket' ); ?>" /></button>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_woocommerce_pagination' ) ) :
	/**
	 * Hypermarket WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the `woocommerce_product_subcategories()` function
	 * but since Hypermarket adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) :
			?>
			<div id="post-navigation" class="navigation pagination" role="navigation" aria-label="<?php esc_html_e( 'Post Navigation', 'hypermarket' ); ?>">
				<h2 class="screen-reader-text">
					<?php esc_html_e( 'Posts Navigation', 'hypermarket' ); ?>
				</h2>
				<div class="nav-links">
					<?php woocommerce_pagination(); ?>
				</div>
				<?php hypermarket_navigation_pager( true ); ?>
			</div>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'hypermarket_single_product_navigation' ) ) :
	/**
	 * Single product navigation.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_single_product_navigation() {
		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_details_navigation', Hypermarket_Customize::$setting_prefix ), false );

		// Bail early, in case the module is not being activated.
		if ( ! $is_activated ) {
			return;
		}

		// Show only products in the same category?
		$in_same_term   = apply_filters( 'hypermarket_single_product_navigation_same_category', true );
		$excluded_terms = apply_filters( 'hypermarket_single_product_navigation_excluded_terms', '' );
		$taxonomy       = apply_filters( 'hypermarket_single_product_navigation_taxonomy', 'product_cat' );

		$previous_product = hypermarket_get_previous_product( $in_same_term, $excluded_terms, $taxonomy );
		$next_product     = hypermarket_get_next_product( $in_same_term, $excluded_terms, $taxonomy );
		$classname        = 'product-navigation';

		if ( ! $previous_product && ! $next_product ) {
			return;
		}

		?>
		<nav class="<?php echo sanitize_html_class( $classname ); ?>" aria-label="<?php esc_attr_e( 'More products', 'hypermarket' ); ?>">
		<?php 
		if ( $previous_product ) : 
			?>
			<a href="<?php echo esc_url( $previous_product->get_permalink() ); ?>" rel="prev" class="<?php echo sanitize_html_class( $classname ); ?>__prev">
			<?php echo wp_kses_post( $previous_product->get_image() ); ?>
				<span>
					<?php 
					/* translators: %s: Medium dash. */
					printf( esc_html__( '%s Prev', 'hypermarket' ), '&mdash;' ); 
					?>
				</span>
			</a>
			<?php 
		endif;

		if ( $next_product ) : 
			?>
			<a href="<?php echo esc_url( $next_product->get_permalink() ); ?>" rel="next" class="<?php echo sanitize_html_class( $classname ); ?>__next">
				<?php echo wp_kses_post( $next_product->get_image() ); ?>
				<span>
					<?php 
					/* translators: %s: Medium dash. */
					printf( esc_html__( 'Next %s', 'hypermarket' ), '&mdash;' ); 
					?>
				</span>
			</a>
			<?php 
		endif; 
		?>
		</nav>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_single_product_share' ) ) :
	/**
	 * Single product share buttons.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_single_product_share() {
		// Retrieve the ID of the current item.
		$post_id   = get_queried_object_id();
		$title     = get_the_title( $post_id );
		$permalink = get_the_permalink( $post_id );

		hypermarket_social_share_buttons( $permalink, $title, true );
	}
endif;

if ( ! function_exists( 'hypermarket_single_sticky_add_to_cart' ) ) :
	/**
	 * Sticky add-to-cart bar.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_single_sticky_add_to_cart() {
		global $product;

		// Bail early, when NOT viewing a single product.
		if ( ! is_product() ) {
			return;
		}

		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_details_sticky_add_to_cart', Hypermarket_Customize::$setting_prefix ), false );

		// Bail early in case:
		// 1- The module is not being activated.
		// 2- The product is not purchasable.
		// 3- The product is out of stock.
		if ( ! $is_activated || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
			return;
		}

		$classname = 'sticky-add-to-cart';
		?>
		<section class="<?php echo sanitize_html_class( $classname ); ?>">

			<?php do_action( 'hypermarket_single_before_sticky_add_to_cart' ); ?>

			<div class="<?php echo sanitize_html_class( $classname ); ?>__content">
				<?php echo wp_kses_post( woocommerce_get_product_thumbnail() ); ?>
				<div class="<?php echo sanitize_html_class( $classname ); ?>__meta">
					<span class="<?php echo sanitize_html_class( $classname ); ?>__title">
						<?php esc_attr_e( 'You&#8217;re viewing:', 'hypermarket' ); ?>
						<strong>
							<?php the_title(); ?>
						</strong>
					</span>
					<span class="<?php echo sanitize_html_class( $classname ); ?>__price">
						<?php echo wp_kses_post( $product->get_price_html() ); ?>
					</span>
					<?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating() ) ); ?>
				</div>
				<?php 
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo hypermarket_do_shortcode(
					'add_to_cart',
					array(
						'id'         => $product->get_id(),
						'show_price' => false,
						'style'      => '',
					) 
				); 
				?>
			</div>

			<?php do_action( 'hypermarket_single_after_sticky_add_to_cart' ); ?>

		</section>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_myaccount_user_info' ) ) :
	/**
	 * Display a user info block above the my-account page menu.
	 *
	 * @since   2.0.0
	 * @return  void
	 * @phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	 */
	function hypermarket_myaccount_user_info() {
		$user_id   = get_current_user_id();
		$classname = 'myaccount-profile';

		?>
		<div class="<?php echo sanitize_html_class( $classname ); ?>">
			<div class="<?php echo sanitize_html_class( $classname ); ?>__meta">
				<div class="<?php echo sanitize_html_class( $classname ); ?>__avatar">
					<?php echo get_avatar( $user_id, 105 ); ?>
				</div>
				<div class="<?php echo sanitize_html_class( $classname ); ?>__data">
					<p>
						<?php hypermarket_customer_fullname( $user_id ); ?>
					</p>
					<span>
						<?php 
							/* translators: %s: Date. */
							printf( esc_html__( 'Joined %s ago', 'hypermarket' ), hypermarket_user_registered_date( $user_id, true, false ) ); 
						?>
					</span>
				</div>
			</div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'hypermarket_product_featured_flash' ) ) :
	/**
	 * Display the "featured" flash (badge).
	 *
	 * @since   2.0.0
	 * @param   bool $ignore_sale    Optional. Whether to bypass the on_sale status.
	 * @param   bool $echo           Optional. Echo the string or return it.
	 * @return  void|html
	 */
	function hypermarket_product_featured_flash( $ignore_sale = false, $echo = true ) {
		global $product;

		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_catalog_featured_flash', Hypermarket_Customize::$setting_prefix ), false );

		if ( ( $product->is_on_sale() && ! $ignore_sale ) || ! $is_activated || ! $product->is_featured() ) {
			return;
		}

		$return = null;
		$is_new = hypermarket_is_product_new( $product );

		// If the product was published within the newness time frame then ignore the `Featured` flash for the time-being.
		if ( ! $is_new ) {
			/* translators: 1: Open span tag, 2: Close span tag. */
			$return = sprintf( esc_html_x( '%1$sFeatured%2$s', 'featured flash', 'hypermarket' ), '<span class="onfeatured">', '</span>' );
		}

		if ( ! $echo ) {
			return $return;
		}

		echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'hypermarket_product_new_flash' ) ) :
	/**
	 * Display the "new" flash (badge).
	 *
	 * @since   2.0.0
	 * @param   bool $ignore_sale    Optional. Whether to bypass the on_sale status.
	 * @param   bool $echo           Optional. Echo the string or return it.
	 * @return  void|null|html
	 */
	function hypermarket_product_new_flash( $ignore_sale = false, $echo = true ) {
		global $product;

		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_catalog_new_flash', Hypermarket_Customize::$setting_prefix ), false );

		if ( ( $product->is_on_sale() && ! $ignore_sale ) || ! $is_activated ) {
			return;
		}

		$return = null;
		$is_new = hypermarket_is_product_new( $product );

		// If the product was published within the newness time frame display the new flash (badge).
		if ( ! ! $is_new ) {
			/* translators: 1: Open span tag, 2: Close span tag. */
			$return = sprintf( esc_html_x( '%1$sNew%2$s', 'new flash', 'hypermarket' ), '<span class="onnew">', '</span>' );
		}

		if ( ! $echo ) {
			return $return;
		}

		echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'hypermarket_product_categories' ) ) :
	/**
	 * Append the product categories to archive products loop.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_product_categories() {
		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_catalog_categories', Hypermarket_Customize::$setting_prefix ), false );

		// Bail early, in case the module is not being activated.
		if ( ! $is_activated ) {
			return;
		}

		// Retrieve the ID of the current item.
		$post_id        = get_queried_object_id();
		$terms_as_links = get_the_term_list( $post_id, 'product_cat', '<small>', ', ', '</small>' );
		printf( '<p class="product-categories">%s</p>', wp_kses_post( $terms_as_links ) );
	}
endif;

if ( ! function_exists( 'hypermarket_product_stock_status' ) ) :
	/**
	 * Display the product stock.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_product_stock_status() {
		global $product;

		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated = get_theme_mod( sprintf( '%s_wc_catalog_stock', Hypermarket_Customize::$setting_prefix ), false );

		// Bail early, in case the module is not being activated.
		if ( ! $is_activated ) {
			return;
		}
		
		// Returns the availability of the product.
		$availability = $product->get_availability();
		$text         = isset( $availability['availability'] ) ? $availability['availability'] : '';
		$classname    = isset( $availability['class'] ) ? $availability['class'] : '';

		if ( ! empty( $text ) && ! empty( $classname ) ) {
			printf( '<p class="stock %s"><small>%s</small></p>', sanitize_html_class( $classname ), esc_html( $text ) );
		}
	}
endif;

if ( ! function_exists( 'hypermarket_product_image_flipper' ) ) :
	/**
	 * Retrieve and append first gallery image of the product to the loop.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_product_image_flipper() {
		global $product;

		// Retrieves theme modification value for the current theme (parent or child).
		$is_activated   = get_theme_mod( sprintf( '%s_wc_catalog_image_flipper', Hypermarket_Customize::$setting_prefix ), false );
		$attachment_ids = hypermarket_get_gallery_image_ids( $product );

		// Bail early, in case the module is not being activated or there is no attachment id found.
		if ( ! $is_activated || ! $attachment_ids ) {
			return;
		}

		$attachment_ids        = array_values( $attachment_ids );
		$flip_image_id         = $attachment_ids['0'];
		$flip_image_alt        = get_post_meta( $flip_image_id, '_wp_attachment_image_alt', true );
		$thumbnail_image_width = apply_filters( 'hypermarket_woocommerce_thumbnail_image_width', 364 );
		$flip_image_srcset     = wp_get_attachment_image_srcset( $flip_image_id, 'woocommerce_thumbnail' );

		echo wp_get_attachment_image(
			$flip_image_id,
			'woocommerce_thumbnail',
			false,
			array(
				'alt'    => esc_attr( $flip_image_alt ),
				'srcset' => esc_attr( $flip_image_srcset ),
				'sizes'  => sprintf( esc_attr( '(max-width: %1$spx) 100vw, %2$spx' ), intval( $thumbnail_image_width ), intval( $thumbnail_image_width ) ),
			)
		);
	}
endif;

if ( ! function_exists( 'hypermarket_products_flkty_div' ) ) :
	/**
	 * Outputs Flickity carousel wrapper.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_products_flkty_div() {
		// Bail early, in case the products flickity module is not being activated.
		if ( ! hypermarket_products_flkty_activated() ) {
			return;
		}

		hypermarket_flkty();
	}
endif;

if ( ! function_exists( 'hypermarket_products_flkty_div_close' ) ) :
	/**
	 * Outputs Flickity carousel wrapper close tag.
	 *
	 * @since   2.0.0
	 * @return  void
	 */
	function hypermarket_products_flkty_div_close() {
		// Bail early, in case the products flickity module is not being activated.
		if ( ! hypermarket_products_flkty_activated() ) {
			return;
		}

		hypermarket_div_close();
	}
endif;
