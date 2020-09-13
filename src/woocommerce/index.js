import './style.css';
import { handheld } from './handheld';

/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	forEach( [ handheld ], ( component ) => {
		component.ready();
	} );
} );