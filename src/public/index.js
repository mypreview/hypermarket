import './style.css';
import { navbar } from './navbar';
import { skipLinkFocus } from './skip-link-focus';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ navbar, skipLinkFocus ], ( component ) => {
		component.ready();
	} );
} );
