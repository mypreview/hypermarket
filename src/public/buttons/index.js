/**
 * External dependencies
 */
import $ from 'jquery';
import Waves from 'node-waves';
import { isArray, forEach } from 'lodash';

const buttons = {
	cache() {
		buttons.els = {};
		buttons.vars = {};
		buttons.els.$document = $( document );
		buttons.vars.classNames = [ '.button', '.submit', '.wp-block-button__link' ];
		buttons.vars.wavesEffects = [ 'waves-light' ];
	},
	// Execute callback after the DOM is loaded.
	ready() {
		buttons.cache();
		buttons.initWaves();
		buttons.ajaxTrigger();
	},
	// Initialize Waves.
	initWaves() {
		Waves.init();
		if ( isArray( buttons.vars.classNames ) ) {
			forEach( buttons.vars.classNames, ( item ) => {
				Waves.attach( item, buttons.vars.wavesEffects );
			} );
		}
	},
	// Re-initialize Waves on Ajax event(s) being triggered.
	ajaxTrigger() {
		buttons.els.$document.on( 'updated_checkout updated_cart_totals', buttons.initWaves );
	},
};

export default buttons;
