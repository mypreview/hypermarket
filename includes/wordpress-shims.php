<?php
/**
 * WordPress shims.
 *
 * @link       https://www.upwork.com/fl/mahdiyazdani
 * @author     Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes
 * @phpcs:ignoreFile
 */

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Adds backwards compatibility for wp_body_open() introduced with WordPress 5.2
	 *
	 * @see 	https://developer.wordpress.org/reference/functions/wp_body_open/
	 * @since   2.0.0
	 * @return  void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
