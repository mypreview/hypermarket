/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Custom scripts.
 */
import { buttons } from './buttons';
import { navbar } from './navbar';
import { jScroll } from './pagination/jscroll';
import { skipLinkFocus } from './skip-link-focus';
import { tooltip } from './tooltip';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ buttons, navbar, jScroll, skipLinkFocus, tooltip ], ( component ) => {
		component.ready();
	} );
} );
