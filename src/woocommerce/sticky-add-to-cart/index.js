/**
 * External dependencies
 */
import $ from 'jquery';
import jump from 'jump.js';
import 'waypoints/lib/jquery.waypoints.js';

export const stickyAddToCart = {
	cache() {
		stickyAddToCart.els = {};
		stickyAddToCart.vars = {};
		stickyAddToCart.vars.showClassName = 'show';
		stickyAddToCart.vars.hideClassName = 'hide';
		stickyAddToCart.els.$element = $( '.hypermarket-sticky-add-to-cart' );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		stickyAddToCart.cache();
		stickyAddToCart.toggleVisibility();
		stickyAddToCart.onClickVariable();
	},
	// Reveal the add-to-cart bar as user scrolls down the page.
	toggleVisibility() {
		if ( ! stickyAddToCart._isEnabled() ) return;

		/* eslint-disable-next-line no-undef */
		new Waypoint( {
			element: $( 'form.cart' ),
			handler: ( direction ) => {
				if ( 'up' === direction ) {
					stickyAddToCart.els.$element.removeClass( stickyAddToCart.vars.showClassName );
				}
				if ( 'down' === direction ) {
					stickyAddToCart.els.$element.addClass( stickyAddToCart.vars.showClassName );
				}
			},
		} );
	},
	// Scroll to the product `div` on variable add-to-cart button clicked.
	onClickVariable() {
		if ( ! stickyAddToCart._isEnabled() ) return;

		stickyAddToCart.els.$element.find( '.button.variable' ).on( 'click', ( event ) => {
			// Default action of the event should not be triggered.
			event.preventDefault();
			jump( 'div.product', {
				a11y: true,
			} );
		} );
	},
	// Determine whether the sticky add-to-cart bar is enabled.
	_isEnabled() {
		if ( !! stickyAddToCart.els.$element.length ) return true;

		return false;
	},
};
