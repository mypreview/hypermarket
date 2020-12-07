/**
 * External dependencies
 */
import $ from 'jquery';
import isEmpty from 'lodash/isEmpty';
import owlCarousel from 'owl.carousel'; /* eslint-disable-line no-unused-vars */

export const slider = {
	cache() {
		slider.els = {};
		slider.vars = {};
		slider.vars.selector = `hypermarket-slider`;
		slider.els.$selector = $( `.${ slider.vars.selector }` );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		slider.cache();
		slider.init();
	},
	// Initialize `owlCarousel` library.
	init() {
		if ( ! slider._isActivated() ) return;

		slider.els.$selector.each( ( index, elm ) => {
			let $this = $( elm );
			const selector = $this.data( 'selector' ),
				options = $this.data( 'options' );

			if ( ! isEmpty( selector ) ) {
				$this = $this.find( selector );
			}

			// Call for slider.
			$this.owlCarousel( options );
		} );
	},
	// Determine whether the slider is present.
	_isActivated() {
		if ( !! slider.els.$selector.length ) return true;

		return false;
	},
};
