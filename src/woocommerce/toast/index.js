/**
 * External dependencies
 */
import $ from 'jquery';
import { l10n } from './../../public/l10n';
import { Notyf } from 'notyf';

const toast = {
	cache() {
		toast.els = {};
		toast.vars = {};
		toast.els.$document = $( document );
		toast.els.notyf = new Notyf();
	},
	// Execute callback after the DOM is loaded.
	ready() {
		toast.cache();
		toast.addedToCart( toast.els.notyf );
		toast.removeFromCart( toast.els.notyf );
	},
	// Trigger a toast message when a product is being added to the cart.
	addedToCart( instance ) {
		toast.els.$document.on( 'added_to_cart', () => {
			instance.open( {
				...toast._args(),
				type: 'success',
				message: l10n( 'i18n_added_to_cart' ),
				background: toast._color( 'success' ),
			} );
		} );
	},
	// Trigger a toast message when a product gets removed from the cart.
	removeFromCart( instance ) {
		toast.els.$document.on( 'removed_from_cart', () => {
			instance.open( {
				...toast._args(),
				type: 'success',
				message: l10n( 'i18n_removed_from_cart' ),
				background: toast._color( 'success' ),
			} );
		} );
	},
	// Default args for the toast message.
	_args() {
		const args = {
			ripple: true,
			dismissible: true,
			duration: 3000,
			position: {
				y: 'top',
				x: l10n( 'isRTL' ) ? 'left' : 'right',
			},
		};
		return args;
	},
	// Toast background color in CSS variable.
	_color( color ) {
		return `var(--hypermarket-alert-${ color })`;
	},
};

export default toast;
