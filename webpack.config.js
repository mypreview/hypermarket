const { resolve } = require( 'path' );
const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const WebpackNotifierPlugin = require( 'webpack-notifier' );
const LicenseWebpackPlugin = require( 'license-webpack-plugin' ).LicenseWebpackPlugin;

module.exports = {
	...defaultConfig,
	entry: {
		editor: resolve( process.cwd(), process.env.WP_SRC_DIRECTORY, 'editor/index.js' ),
		frontend: resolve( process.cwd(), process.env.WP_SRC_DIRECTORY, 'frontend/index.js' ),
	},
	performance: {
		hints: false,
	},
	plugins: [
		...defaultConfig.plugins,
		new WebpackRTLPlugin( {
			filename: '[name]-rtl.css',
		} ),
		new LicenseWebpackPlugin( {
			outputFilename: '../credits.txt',
			preferredLicenseTypes: [ 'GPL', 'MIT', 'ISC' ],
			stats: {
				warnings: false,
				errors: true,
			},
		} ),
		new WebpackNotifierPlugin( {
			emoji: true,
			alwaysNotify: true,
			skipFirstNotification: true,
		} ),
	],
};
