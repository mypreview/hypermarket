<?php
/**
 * Hypermarket admin hooks.
 *
 * @link       https://mypreview.github.io/hypermarket
 * @author     MyPreview
 * @since      2.0.0
 *
 * @package    hypermarket
 * @subpackage hypermarket/includes
 */

/**
 * Header
 *
 * @see  hypermarket_welcome_header()
 */
add_action( 'hypermarket_welcome_top', 'hypermarket_welcome_header' );

/**
 * Content
 *
 * @see  hypermarket_welcome_tabs()
 */
add_action( 'hypermarket_welcome_content', 'hypermarket_welcome_tabs' );
add_action( 'hypermarket_welcome_content', 'hypermarket_welcome_extensions', 20 );
