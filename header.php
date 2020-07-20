<?php
/**
 * The header for our theme.
 * This is the template that displays all of the `<head>` section and everything up until `<div id="content">`
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="no-js no-svg" itemscope="itemscope" itemtype="http://schema.org/Website">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page" class="hfeed site">

		<?php do_action( 'hypermarket_before_header' ); ?>

		<header id="masthead" class="site-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader" role="banner">
			<div class="col-full">
				<?php
					/**
					 * Functions hooked into `hypermarket_header` action
					 *
					 * @hooked hypermarket_skip_links              - 5
					 * @hooked hypermarket_div                    - 10
					 * @hooked hypermarket_site_branding          - 20
					 * @hooked hypermarket_div                    - 45
					 * @hooked hypermarket_myaccount_link         - 50
					 * @hooked hypermarket_cart                   - 60
					 * @hooked hypermarket_div_close              - 65
					 * @hooked hypermarket_primary_menu           - 80
					 */
					do_action( 'hypermarket_header' ); 

				?>
			</div>
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
