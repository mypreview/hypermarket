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
import { sidebar } from './sidebar';
import { slider } from './slider';
import { tooltip } from './tooltip';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ buttons, navbar, jScroll, sidebar, skipLinkFocus, slider, tooltip ], ( component ) => {
		component.ready();
	} );
} );
