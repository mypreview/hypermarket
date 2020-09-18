/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Vendor (third-party) dependencies.
 */
import './../vendor';

/**
 * Custom scripts.
 */
import { buttons } from './buttons';
import { navbar } from './navbar';
import { skipLinkFocus } from './skip-link-focus';
import { tooltip } from './tooltip';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ buttons, navbar, skipLinkFocus, tooltip ], ( component ) => {
		component.ready();
	} );
} );
