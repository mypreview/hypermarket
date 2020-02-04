<?php
/**
 * The sidebar containing the main widget area
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! is_active_sidebar( 'sidebar-1' ) || apply_filters( 'hypermarket_disable_sidebar', FALSE ) ) {
	return;
} // End If Statement

?><div id="secondary" class="widget-area" role="complementary"><?php

	dynamic_sidebar( 'sidebar-1' ); 

?></div><!-- #secondary -->