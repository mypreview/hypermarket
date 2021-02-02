/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Custom scripts.
 */
import cart from './cart';
import handheld from './handheld';
import quantity from './quantity';
import stickyAddToCart from './sticky-add-to-cart';
import toast from './toast';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ cart, handheld, quantity, stickyAddToCart, toast ], ( component ) => {
		component.ready();
	} );
} );
