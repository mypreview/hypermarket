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
		jScroll.vars.inner = `.${ jScroll.vars.selector }__inner`;
		jScroll.vars.next = 'a.next';
		jScroll.els.$selector = $( `.${ jScroll.vars.selector }` );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		jScroll.cache();
		jScroll.init();
	},
	// Initialize jScroll.
	init() {
		if ( ! jScroll._isActivated() ) return;

		jScroll.els.$selector.jscroll( {
			autoTrigger: false,
			loadingHtml: `<div class="${ jScroll.vars.selector }__loading"></div>`,
			nextSelector: jScroll.vars.next,
			contentSelector: jScroll.vars.inner,
		} );
	},
	// Determine whether the Ajax pagination is enabled.
	_isActivated() {
		if ( !! jScroll.els.$selector.length ) return true;

		return false;
	},
};
