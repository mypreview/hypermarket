/**
 * External dependencies
 */
import $ from 'jquery';
import { add, subtract, lte } from 'lodash';
import { l10n } from './../l10n';
import slicknav from 'slicknav/dist/jquery.slicknav.min.js'; /* eslint-disable-line no-unused-vars */

const navbar = {
	cache() {
		navbar.els = {};
		navbar.vars = {};
		navbar.vars.elm = 'site-navigation';
		navbar.els.$submenu = $( `#${ navbar.vars.elm } .menu-item-has-children` );
		navbar.els.$handheld = $( '.site-handheld-menu' );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		navbar.cache();
		navbar.isOffScreen();
		navbar.handheldMenu();
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
					right = subtract( windowWidth, add( left, width ) ),
					isVisible = l10n( 'isRTL' )
						? lte( add( right, width ), windowWidth )
						: lte( add( left, width ), windowWidth );
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
	// Initialize handheld (mobile) menu.
	handheldMenu() {
		// Bail early, in case the menu is not present on the page.
		if ( !!! navbar.els.$handheld.length ) return;

		navbar.els.$handheld.slicknav( {
			label: '',
			duplicate: false,
			allowParentLinks: false,
			prependTo: '#masthead',
		} );
	},
};

export default navbar;
