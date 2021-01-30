/**
 * All of the the JavaScript compile functionality
 * for the "Hypermarket" theme reside in this file.
 *
 * @requires Webpack
 * @package
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config.js' );
const path = require( 'path' );
const chalk = require( 'chalk' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const WebpackNotifierPlugin = require( 'webpack-notifier' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const ProgressBarPlugin = require( 'progress-bar-webpack-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const OptimizeCSSAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const LicenseCheckerWebpackPlugin = require( 'license-checker-webpack-plugin' );

module.exports = {
	...defaultConfig,
	entry: {
		'legacy-editor': path.resolve( process.cwd(), 'src', 'legacy-editor/style.css' ),
		admin: path.resolve( process.cwd(), 'src', 'admin/index.js' ),
		editor: path.resolve( process.cwd(), 'src', 'editor/index.js' ),
		public: path.resolve( process.cwd(), 'src', 'public/index.js' ),
		customize: path.resolve( process.cwd(), 'src', 'customize/index.js' ),
		woocommerce: path.resolve( process.cwd(), 'src', 'woocommerce/index.js' ),
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				test: /\.(png|jpg|gif)$/i,
				use: {
					loader: 'url-loader',
					options: {
						encoding: true,
					},
				},
			},
		],
	},
	optimization: {
		...defaultConfig.optimization,
		splitChunks: {
			automaticNameDelimiter: '--',
		},
		minimizer: [
			...defaultConfig.optimization.minimizer,
			new OptimizeCSSAssetsPlugin( {
				cssProcessorPluginOptions: {
					preset: [ 'default', { discardComments: { removeAll: true } } ],
				},
			} ),
		],
	},
	plugins: [
		...defaultConfig.plugins,
		new FixStyleOnlyEntriesPlugin(),
		new CleanWebpackPlugin( {
			cleanStaleWebpackAssets: false,
		} ),
		new ProgressBarPlugin( {
			format:
				chalk.blue( 'Build core script' ) + ' [:bar] ' + chalk.green( ':percent' ) + ' :msg (:elapsed seconds)',
		} ),
		new WebpackRTLPlugin( {
			filename: '[name]-rtl.css',
		} ),
		new LicenseCheckerWebpackPlugin( {
			outputFilename: './credits.txt',
			ignore: [ 'owl.carousel' ],
		} ),
		new WebpackNotifierPlugin( {
			title: 'Hypermarket',
			emoji: true,
			alwaysNotify: true,
			skipFirstNotification: true,
		} ),
	],
};
