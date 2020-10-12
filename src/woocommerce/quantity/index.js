/**
 * External dependencies
 */
import $ from 'jquery';
import numeric from 'jquery.numeric'; /* eslint-disable-line no-unused-vars */
import { gte, gt, lte, add, subtract, isEmpty, isNull, isEqual, isNaN, isUndefined } from 'lodash';

export const quantity = {
	cache() {
		quantity.els = {};
		quantity.vars = {};
		quantity.vars.buttons = '.quantity button';
		quantity.vars.input = 'input.qty';
		quantity.els.$body = $( 'body' );
		quantity.els.$elm = $( '.quantity' );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		quantity.cache();
		quantity.onClick();
		quantity.forceNumeric();
	},
	// Handles plus (+) and minus (-) button clicks.
	onClick() {
		quantity.els.$body.on( 'click', quantity.vars.buttons, ( event ) => {
			const $this = $( event.target ),
				$input = $this.closest( 'div' ).find( quantity.vars.input );

			let value = parseFloat( $input.val() ),
				min = parseFloat( $input.attr( 'min' ) ),
				max = parseFloat( $input.attr( 'max' ) ),
				step = $input.attr( 'step' );

			if ( isNull( min ) || isNaN( min ) ) min = 0;
			if ( isNull( max ) || isNaN( max ) ) max = '';
			if ( ! value || isNull( value ) || isNaN( value ) ) value = 0;
			if ( isEqual( step, 'any' ) || isEmpty( step ) || isUndefined( step ) || isNaN( parseFloat( step ) ) )
				step = 1;

			// Add to the existing value.
			if ( $this.hasClass( 'qty-plus' ) ) {
				if ( max && gte( value, max ) ) {
					$input.val( max );
				} else {
					$input.val( add( value, parseFloat( step ) ).toFixed( quantity._getDecimals( step ) ) );
				}
				// Subtract from the existing value.
			} else if ( $this.hasClass( 'qty-minus' ) ) {
				if ( min && lte( value, min ) ) {
					$input.val( min );
				} else if ( gt( value, 0 ) ) {
					$input.val( subtract( value, parseFloat( step ) ).toFixed( quantity._getDecimals( step ) ) );
				}
			}

			$input.trigger( 'change' ).trigger( 'qtyUpdated' );
		} );
	},
	// Allows only valid numbers to be typed into the quantity field.
	forceNumeric() {
		quantity.els.$elm.find( quantity.vars.input ).each( ( index, elm ) => {
			$( elm ).numeric( { negative: false } );
		} );
	},
	// Extract decimal points from a float number.
	_getDecimals( number ) {
		const match = ( '' + number ).match( /(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/ );
		if ( ! match ) {
			return 0;
		}
		return Math.max( 0, ( match[ 1 ] ? match[ 1 ].length : 0 ) - ( match[ 2 ] ? +match[ 2 ] : 0 ) );
	},
};
