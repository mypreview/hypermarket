/* global hypermarket_customize */

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
		wp.customize.section( catalog.vars.section, ( section ) => {
			section.expanded.bind( ( isExpanded ) => {
				if ( !! isExpanded ) {
					wp.customize.previewer.previewUrl.set( hypermarket_customize.shop_url );
				}
			} );
		} );
	},
};
