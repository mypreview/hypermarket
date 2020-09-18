import './style.css';
import { handheld } from './handheld';
import { quantity } from './quantity';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ handheld, quantity ], ( component ) => {
		component.ready();
	} );
} );
