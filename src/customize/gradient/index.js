/**
 * External dependencies
 */
import $ from 'jquery';
import Grapick from 'grapick';
import isEmpty from 'lodash/isEmpty';

export const gradient = {
	cache() {
		gradient.els = {};
		gradient.vars = {};
		gradient.vars.control = '.customize-control-gradient';
		gradient.vars.picker = `${ gradient.vars.control }__picker`;
		gradient.vars.field = `${ gradient.vars.control }__field`;
		gradient.els.$control = $( gradient.vars.control );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		gradient.cache();
		gradient.onInit();
	},
	// Initialize `Gradient` color picker on page load.
	onInit() {
		gradient.els.$control.each( ( index, elm ) => {
			const $this = $( elm ),
				$picker = $this.find( gradient.vars.picker ),
				$field = $this.find( gradient.vars.field ),
				value = $field.val(),
				gp = new Grapick( { el: $picker[ 0 ], direction: '135deg' } );

			// If there is value saved/passed, then set it.
			if ( ! isEmpty( value ) ) {
				gp.setValue( value );
			}

			// Save the value on change of the gradient.
			gp.on( 'change', ( complete ) => {
				if ( complete ) {
					$field.val( gp.getSafeValue() );
					$field.trigger( 'change' );
				}
			} );
		} );
	},
};
