/**
 * Utility for libraries from the `Lodash`.
 */
import { forEach } from 'lodash';

/**
 * Theme prefix.
 */
import PREFIX from './../utils/prefix';

/**
 * Execute callback after the DOM is loaded.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/dom-ready/README.md
 */
import domReady from '@wordpress/dom-ready';

/**
 * Plugins module for WordPress.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/plugins/README.md
 */
import { registerPlugin } from '@wordpress/plugins';

/**
 * Subscribed script.
 */
import fluidTemplateSubscribe from './subscribe/fluid-template';
import backgroundColorSubscribe from './subscribe/background-color';

/**
 * Stylesheet dependencies.
 */
import './index.css';

/**
 * Custom scripts.
 */
import * as meta from './meta';

/**
 * Register custom plugin module(s) for WordPress editor.
 */
function registerPlugins() {
	forEach( [ meta ], ( plugin ) => {
		if ( ! plugin ) {
			return;
		}

		const { name, settings } = plugin;

		registerPlugin( `${ PREFIX }-${ name }`, {
			...settings,
		} );
	} );
}

// Execute the following functions when the DOM is fully loaded.
domReady( () => {
	registerPlugins();
	fluidTemplateSubscribe();
	backgroundColorSubscribe();
} );
