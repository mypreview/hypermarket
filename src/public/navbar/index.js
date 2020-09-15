/* global hypermarket */

/**
 * External dependencies
 */
import $ from 'jquery';

export const navbar = {
	cache() {
		navbar.els = {};
		navbar.vars = {};
		navbar.vars.elm = 'site-navigation';
		navbar.els.$submenu = $( `#${ navbar.vars.elm } .menu-item-has-children` );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		navbar.cache();
		navbar.isOffScreen();
	},
	// Avoid sub-menus from going off-screen.
	isOffScreen() {
		const className = 'is-off-screen';
		navbar.els.$submenu.on( 'mouseenter mouseleave', function () {
			if ( $( 'ul', this ).length ) {
				const $window = $( window ),
					windowWidth = $window.innerWidth(),
					$submenu = $( 'ul:first', this ),
					offset = $submenu.offset(),
					width = $submenu.width(),
					left = offset.left,
					right = windowWidth - ( left + width ),
					isVisible = hypermarket.isRTL ? right + width <= windowWidth : left + width <= windowWidth;
				if ( ! isVisible ) {
					$( this ).addClass( className );
				} else {
					setTimeout( () => {
						$( this ).removeClass( className );
					}, 300 );
				}
			}
		} );
	},
};
