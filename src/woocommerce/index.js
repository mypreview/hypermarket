/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Custom scripts.
 */
import { cart } from './cart';
import { handheld } from './handheld';
import { quantity } from './quantity';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ cart, handheld, quantity ], ( component ) => {
		component.ready();
	} );
} );
