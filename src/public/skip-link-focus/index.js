/* global navigator, location */
/**
 * Helps with accessibility for keyboard only users.
 * Learn more: https://git.io/vWdr2
 */
export const skipLinkFocus = {
	cache() {
		skipLinkFocus.vars = {};
		skipLinkFocus.vars.isIE = /(trident|msie)/i.test( navigator.userAgent );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		skipLinkFocus.cache();

		if ( skipLinkFocus.vars.isIE && document.getElementById && window.addEventListener ) {
			window.addEventListener(
				'hashchange',
				function () {
					const id = location.hash.substring( 1 );

					if ( ! /^[A-z0-9_-]+$/.test( id ) ) {
						return;
					}

					const element = document.getElementById( id );

					if ( element ) {
						if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
							element.tabIndex = -1;
						}
						element.focus();
					}
				},
				false
			);
		}
	},
};
