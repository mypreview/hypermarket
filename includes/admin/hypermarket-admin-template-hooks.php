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
 * @see  hypermarket_welcome_tab()
 * @see  hypermarket_extensions_tab()
 */
add_action( 'hypermarket_welcome_content', 'hypermarket_welcome_tabs' );
add_action( 'hypermarket_welcome_tab_content', 'hypermarket_welcome_tab' );
add_action( 'hypermarket_welcome_tab_content', 'hypermarket_extensions_tab', 20 );
