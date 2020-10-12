/**
 * External dependencies
 */
import $ from 'jquery';

export const sidebar = {
	cache() {
		sidebar.els = {};
		sidebar.vars = {};
		sidebar.vars.selector = 'widget-area';
		sidebar.vars.className = 'has-sidebar--open';
		sidebar.els.$body = $( 'body' );
		sidebar.els.$toggle = $( `.${ sidebar.vars.selector }-toggle` );
		sidebar.els.$close = $( `.${ sidebar.vars.selector }__close` );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		sidebar.cache();
		sidebar.onOpen();
		sidebar.onClose();
	},
	// Open the collapsible sidebar on click.
	onOpen() {
		sidebar.els.$toggle.on( 'click', ( event ) => {
			event.preventDefault();
			sidebar.els.$body.addClass( sidebar.vars.className );
		} );
	},
	// Close the sidebar area on click.
	onClose() {
		sidebar.els.$close.on( 'click', ( event ) => {
			event.preventDefault();
			sidebar.els.$body.removeClass( sidebar.vars.className );
		} );
	},
};
