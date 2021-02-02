/**
 * External dependencies
 */
import $ from 'jquery';
import { eq, map } from 'lodash';

const handheld = {
	cache() {
		handheld.els = {};
		handheld.els.$body = $( 'body' );
		handheld.els.$elm = $( '.site-handheld-toolbar' );
		handheld.els.$forms = handheld.els.$body.find( 'form' );
		handheld.els.$searchLink = $( '.site-handheld-toolbar__search a' );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		handheld.cache();
		handheld.toggleSearch();
		handheld.formFocus();
	},
	// Add class to footer search when clicked.
	toggleSearch() {
		handheld.els.$searchLink.on( 'click', ( event ) => {
			event.preventDefault();

			const $this = $( event.target );
			$this.parent().toggleClass( 'shown' );
		} );
	},
	// This is used to hide the Handheld Toolbar when an input is focused.
	formFocus() {
		if ( !! handheld.els.$forms ) {
			const $forms = handheld.els.$forms; // Remove the last item in the array.
			map( $forms, ( item ) => {
				if ( !!! handheld.els.$elm[ 0 ].contains( item ) ) {
					item.addEventListener( 'focus', handheld.isFocused( true ), true );
					item.addEventListener( 'blur', handheld.isFocused( false ), true );
				}
			} );
		}
	},
	// Add focus class to body when an input field is focused.
	isFocused( focused ) {
		return ( event ) => {
			if ( !! focused && ! eq( -1, event.target.tabIndex ) ) {
				handheld.els.$body.addClass( 'input-focused' );
			} else {
				handheld.els.$body.removeClass( 'input-focused' );
			}
		};
	},
};

export default handheld;
