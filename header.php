<?php
/**
 * The header for our theme
 * This is the template that displays all of the `<head>` section and everything up until `<div id="content">`
 *
 * @link 		https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>><?php

	// Fire the `wp_body_open` action.
	wp_body_open();

	?><div id="page" class="hfeed site"><?php

		do_action( 'hypermarket_before_header' ); 
		
		?><header id="masthead" class="site-header" role="banner"><?php

			/**
			 * Functions hooked into `hypermarket_header` action
			 *
			 * @hooked hypermarket_container_open          - 0
			 * @hooked hypermarket_skip_links              - 5
			 * @hooked hypermarket_site_branding          - 10
			 * @hooked hypermarket_primary_nav     		  - 20
			 * @hooked hypermarket_wc_header_cart         - 30
			 * @hooked hypermarket_container_close        - 35
			 */
			do_action( 'hypermarket_header' ); 

		?></header><!-- #masthead --><?php
		
		/**
		 * Functions hooked into `hypermarket_before_content` action
		 *
		 * @hooked 	woocommerce_breadcrumb 				  - 10
		 */
		do_action( 'hypermarket_before_content' ); 

		?><div id="content" class="site-content" tabindex="-1"><?php
		
			/**
			 * Functions hooked into `hypermarket_content_top` action
			 *
			 * @hooked 	hypermarket_container_open		   - 5
			 */
			do_action( 'hypermarket_content_top' ); ?>