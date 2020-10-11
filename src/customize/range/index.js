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
		range.vars.reset = `${ range.vars.control }__reset`;
		range.els.$control = $( range.vars.control );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		range.cache();
		range.onChange();
		range.onReset();
	},
	// Listen to the `Range` input change and update the value accordingly.
	onChange() {
		range.els.$control.each( ( index, elm ) => {
			const $this = $( elm ),
				$field = $this.find( range.vars.field ),
				$value = $this.find( range.vars.value );

			$field.on( 'input', () => {
				$value.text( parseInt( $field.val() ) );
			} );
		} );
	},
	// Click event to restore the value of the range control to its default value.
	onReset() {
		range.els.$control.find( range.vars.reset ).on( 'click', ( event ) => {
			// Default action should not be taken as it normally would be.
			event.preventDefault();

			const $this = $( event.target ),
				$parent = $this.closest( range.vars.control ),
				$field = $parent.find( range.vars.field ),
				$value = $parent.find( range.vars.value ),
				defaultVal = parseInt( $field.data( 'default' ) );

			$field.val( defaultVal ).trigger( 'change' );
			$value.text( defaultVal );
		} );
	},
};
