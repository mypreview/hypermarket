/**
 * External dependencies
 */
import $ from 'jquery';
import eq from 'lodash/eq';
import jump from 'jump.js';
import 'waypoints/lib/jquery.waypoints.js';

export const stickyAddToCart = {
	cache() {
		stickyAddToCart.els = {};
		stickyAddToCart.vars = {};
		stickyAddToCart.vars.showClassName = 'show';
		stickyAddToCart.els.$element = $( '.hypermarket-sticky-add-to-cart' );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		stickyAddToCart.cache();
		stickyAddToCart.onScroll();
		stickyAddToCart.onClick();
	},
	// Reveal the add-to-cart bar as user scrolls down the page.
	onScroll() {
		if ( ! stickyAddToCart._isActivated() ) return;

		/* eslint-disable-next-line no-undef */
		new Waypoint( {
			element: $( 'form.cart' ),
			handler: ( direction ) => {
				if ( eq( direction, 'up' ) ) {
					stickyAddToCart.els.$element.removeClass( stickyAddToCart.vars.showClassName );
				}
				if ( eq( direction, 'down' ) ) {
					stickyAddToCart.els.$element.addClass( stickyAddToCart.vars.showClassName );
				}
			},
		} );
	},
	// Scroll to the product `div` on variable add-to-cart button clicked.
	onClick() {
		if ( ! stickyAddToCart._isActivated() ) return;

		stickyAddToCart.els.$element.find( '.button:not(.ajax_add_to_cart)' ).on( 'click', ( event ) => {
			// Default action of the event should not be triggered.
			event.preventDefault();
			jump( 'div.product', {
				a11y: true,
			} );
		} );
	},
	// Determine whether the sticky add-to-cart bar is enabled.
	_isActivated() {
		if ( !! stickyAddToCart.els.$element.length ) return true;

		return false;
	},
};
