/**
 * External dependencies
 */
import $ from 'jquery';
import jscroll from 'jscroll'; /* eslint-disable-line no-unused-vars */

export const jScroll = {
	cache() {
		jScroll.els = {};
		jScroll.vars = {};
		jScroll.vars.selector = 'jscroll-div';
		jScroll.vars.$selector = $( `.${ jScroll.vars.selector }` );
		jScroll.vars.inner = `.${ jScroll.vars.selector }__inner`;
		jScroll.vars.next = 'a.next';
	},
	// Execute callback after the DOM is loaded.
	ready() {
		jScroll.cache();
		jScroll.init();
	},
	// Initialize jScroll.
	init() {
		// Bail early, in case the menu is not present on the page.
		if ( !!! jScroll.vars.$selector.length ) return;

		jScroll.vars.$selector.jscroll( {
			autoTrigger: false,
			loadingHtml: `<div class="${ jScroll.vars.selector }__loading"></div>`,
			nextSelector: jScroll.vars.next,
			contentSelector: jScroll.vars.inner,
		} );
	},
};
