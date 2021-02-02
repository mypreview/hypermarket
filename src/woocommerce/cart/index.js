/**
 * External dependencies
 */
import $ from 'jquery';

const cart = {
	cache() {
		cart.vars = {};
		cart.els = {};
		cart.vars.updateCart = ':input[name="hypermarket-update-cart"]';
		cart.vars.wcUpdateCart = '.woocommerce-cart-form :input[name="update_cart"]';
		cart.els.$document = $( document );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		cart.cache();
		cart.updateCartOnClick();
		cart.updateCartDisableToggle();
		cart.ajaxTrigger();
	},
	// Update cart totals on `Update cart` button clicked.
	updateCartOnClick() {
		cart.els.$document.on( 'click', cart.vars.updateCart, () => {
			const $button = $( cart.vars.wcUpdateCart );
			$( $button )[ 0 ].click();
		} );
	},
	// Toggle disabled state of the `Update cart` button.
	updateCartDisableToggle() {
		const $button = $( cart.vars.wcUpdateCart );

		// Bail early, in case the button is not present on the page.
		if ( !!! $button.length ) return;

		if ( $button.is( ':disabled' ) ) {
			cart._updateCartDisable();
		} else {
			cart._updateCartEnable();
		}
	},
	// Look for the Cart Ajax events and trigger methods if necessary.
	ajaxTrigger() {
		cart.els.$document.on(
			'change input',
			'.woocommerce-cart-form .cart_item :input',
			cart.updateCartDisableToggle
		);
		cart.els.$document.on( 'updated_cart_totals', cart.updateCartDisableToggle );
	},
	// Disable `Update cart` button.
	_updateCartDisable() {
		$( cart.vars.updateCart ).prop( 'disabled', true ).attr( 'aria-disabled', true );
	},
	// Enable `Update cart` button.
	_updateCartEnable() {
		$( cart.vars.updateCart ).prop( 'disabled', false ).attr( 'aria-disabled', false );
	},
};

export default cart;
