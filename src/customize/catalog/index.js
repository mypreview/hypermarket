/* global hypermarket_customize */

/**
 * External dependencies
 */
import $ from 'jquery';

export const catalog = {
	cache() {
		catalog.els = {};
		catalog.vars = {};
		catalog.vars.section = 'hypermarket_customize_wc_catalog';
	},
	// Execute callback after the DOM is loaded.
	ready() {
		catalog.cache();
		catalog.onExpand();
	},
	// Redirect to the `Shop` page when the `Product Catalog` section is expanded.
	onExpand() {
		wp.customize.section( catalog.vars.section, function( section ) {
			section.expanded.bind( function( isExpanded ) {
				if ( !! isExpanded ) {
					wp.customize.previewer.previewUrl.set( hypermarket_customize.shop_url );
				}
			} );
		} );
	},
};
