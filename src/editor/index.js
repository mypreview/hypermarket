/**
 * External dependencies
 */
import forEach from 'lodash/forEach';
import domReady from '@wordpress/dom-ready';
import PREFIX from './../utils/prefix';

/**
 * Stylesheet dependencies.
 */
import './style.css';

/**
 * Fluid-template specific script.
 */
import fluidTemplateSubscribe from './fluid-template';

/**
 * WordPress dependencies
 */
const { registerPlugin } = wp.plugins;

/**
 * Custom scripts.
 */
import * as metas from './metas';

/**
 * Register custom plugin module(s) for WordPress editor.
 */
export function registerPlugins() {
	forEach( [ metas ], ( plugin ) => {
		if ( ! plugin ) {
			return;
		}

		const { name, settings } = plugin;

		registerPlugin( `${ PREFIX }-${ name }`, {
			...settings,
		} );
	} );
}

registerPlugins();

domReady( () => {
	fluidTemplateSubscribe();
} );
