/**
 * External dependencies
 */
import tippy from 'tippy.js';

export const tooltip = {
	cache() {
		tooltip.vars = {};
		tooltip.vars.selector = '[data-tippy-content]';
	},
	// Execute callback after the DOM is loaded.
	ready() {
		tooltip.cache();
		tooltip.initTooltip();
	},
	// Initialize tooltip.
	initTooltip() {
		tippy( tooltip.vars.selector, {
			arrow: true,
		} );
	},
};
