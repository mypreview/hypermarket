<?php
/**
 * The header for our theme.
 * This is the template that displays all of the `<head>` section and everything up until `<div id="content">`
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg" itemscope="itemscope" itemtype="http://schema.org/Website">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0" />
	<meta name="msapplication-tap-highlight" content="no" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page" class="hfeed site">

		<?php do_action( 'hypermarket_before_header' ); ?>

		<header id="masthead" class="site-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
				<?php
					/**
					 * Functions hooked into `hypermarket_header` action
					 *
					 * @hooked hypermarket_skip_links              - 5
					 * @hooked hypermarket_site_branding          - 10
					 * @hooked hypermarket_primary_menu           - 20
					 * @hooked hypermarket_div                    - 25
					 * @hooked hypermarket_myaccount_link         - 30
					 * @hooked hypermarket_cart                   - 40
					 * @hooked hypermarket_div_close              - 45
					 * @hooked hypermarket_handheld_menu          - 50
					 */
					do_action( 'hypermarket_header' ); 

				?>
		</header><!-- #masthead -->

		<?php do_action( 'hypermarket_before_content' ); ?>

		<div id="content" class="site-content" tabindex="-1"><?php
		
			/**
			 * Functions hooked into `hypermarket_content_top` action
			 *
			 * @hooked  hypermarket_container                - 5
			 * @hooked  hypermarket_shop_messages            - 10
			 */
			do_action( 'hypermarket_content_top' ); ?>
