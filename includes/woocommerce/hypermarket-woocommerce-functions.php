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
	 * Checks if the current page is a product archive
	 *
	 * @since   1.0.0
	 * @return  bool
	 */
	function hypermarket_is_product_archive() {
		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			return true;
		}
			
		return false;
	}
endif;

if ( ! function_exists( 'hypermarket_get_previous_product' ) ) :
	/**
	 * Retrieves the previous product.
	 *
	 * @since   1.0.0
	 * @param   bool         $in_same_term       Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param   array|string $excluded_terms     Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param   string       $taxonomy           Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @return  WC_Product|false                            Product object if successful. False if no valid product is found.
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
	 * @since   1.0.0
	 * @param   bool         $in_same_term       Optional. Whether post should be in a same taxonomy term. Default false.
	 * @param   array|string $excluded_terms     Optional. Comma-separated list of excluded term IDs. Default empty.
	 * @param   string       $taxonomy           Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
	 * @return  WC_Product|false                            Product object if successful. False if no valid product is found.
	 */
	function hypermarket_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
		$product = new Hypermarket_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
		return $product->get_product();
	}
endif;
