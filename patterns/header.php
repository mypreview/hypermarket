<?php
/**
 * Title:          Header
 * Categories:     header
 * Slug:           hypermarket/header
 * Inserter:       no
 * Keywords:       header, navigation
 * Block Types:    core/template-part/header
 * 
 * @since          2.1.0
 * @package        hypermarket
 * @subpackage     hypermarket/patterns
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"30px","right":"clamp(30px, 3vw, 15px)","bottom":"30px","left":"clamp(30px, 3vw, 15px)"},"blockGap":"24px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignfull" style="padding-top:30px;padding-right:clamp(15px, 3vw, 30px);padding-bottom:30px;padding-left:clamp(15px, 3vw, 30px)"><!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":40} /-->

<!-- wp:site-title /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"textColor":"entry","overlayBackgroundColor":"background","overlayTextColor":"entry","className":"is-style-minimal"} /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/customer-account {"displayStyle":"icon_only"} /-->

<!-- wp:woocommerce/mini-cart {"addToCartBehaviour":"open_drawer","hasHiddenPrice":true,"className":"is-style-default"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->