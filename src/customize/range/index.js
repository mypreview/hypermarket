/**
 * External dependencies
 */
import $ from 'jquery';
import parseInt from 'lodash/parseInt';

export const range = {
	cache() {
		range.els = {};
		range.vars = {};
		range.vars.control = '.customize-control-range';
		range.vars.field = `${ range.vars.control }__field`;
		range.vars.value = `${ range.vars.control }__value`;
		range.els.control = $( range.vars.control );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		range.cache();
		range.onChange();
	},
	// Listen to the `Range` input change and update the value accordingly.
	onChange() {
		range.els.control.each( ( index, elm ) => {
			const $this = $( elm ),
				$field = $this.find( range.vars.field ),
				$value = $this.find( range.vars.value );

			$field.on( 'input', () => {
				$value.text( parseInt( $field.val() ) );
			} );
		} );
	},
};
