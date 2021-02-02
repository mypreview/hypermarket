/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Vendor (third-party) dependencies
 */
import './vendor';

/**
 * Custom scripts.
 */
import plugins from './plugins';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ plugins ], ( component ) => {
		component.ready();
	} );
} );
