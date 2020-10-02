/**
 * External dependencies
 */
import $ from 'jquery';
import tippy from 'tippy.js';

export const tooltip = {
	cache() {
		tooltip.els = {};
		tooltip.vars = {};
		tooltip.els.$document = $( document );
		tooltip.vars.selector = '[data-tippy-content]';
	},
	// Execute callback after the DOM is loaded.
	ready() {
		tooltip.cache();
		tooltip.init();
		tooltip.ajaxTrigger();
	},
	// Initialize tooltip.
	init() {
		tippy( tooltip.vars.selector, {
			arrow: true,
		} );
	},
	// Re-initialize tooltip on Ajax event(s) being triggered.
	ajaxTrigger() {
		tooltip.els.$document.on( 'updated_cart_totals', tooltip.init );
	},
};
