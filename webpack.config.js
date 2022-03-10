/**
 * All of the the JavaScript compile functionality
 * for the "Hypermarket" theme reside in this file.
 *
 * @requires Webpack
 * @author   MyPreview (Github: @mahdiyazdani, @gooklani, @mypreview)
 */
const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const { resolve } = require( 'path' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const WebpackNotifierPlugin = require( 'webpack-notifier' );
const LicenseCheckerWebpackPlugin = require( 'license-checker-webpack-plugin' );

module.exports = {
	...defaultConfig,
	entry: {
		editor: resolve( process.cwd(), 'src', 'editor/index.js' ),
		frontend: resolve( process.cwd(), 'src', 'frontend/index.js' ),
		woocommerce: resolve( process.cwd(), 'src', 'woocommerce/index.js' ),
	},
	plugins: [
		...defaultConfig.plugins,
		new WebpackRTLPlugin( {
			filename: '[name]-rtl.css',
		} ),
		new LicenseCheckerWebpackPlugin( {
			outputFilename: './credits.txt',
		} ),
		new WebpackNotifierPlugin( {
			title: 'Hypermarket',
			emoji: true,
			alwaysNotify: true,
			skipFirstNotification: true,
		} ),
	],
};
