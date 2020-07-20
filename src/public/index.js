import './style.css';
import { skipLinkFocus } from './skip-link-focus';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ skipLinkFocus ], ( component ) => {
		component.ready();
	} );
} );
