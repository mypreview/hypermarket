/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Custom scripts.
 */
import { range } from './range';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';

// Bail early, in case the Customizer JavaScript API is not present!
if ( !! wp && !! wp.customize ) {
	// Trigger the custom scripts once the Customizer is ready and fully loaded.
	window.wp.customize.bind( 'ready', () => {
		forEach( [ range ], ( component ) => {
			component.ready();
		} );
	} );
}
