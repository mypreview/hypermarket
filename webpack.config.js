/**
 * All of the the JavaScript compile functionality
 * for the "Hypermarket" theme reside in this file.
 *
 * @requires    Webpack
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const OptimizeCSSAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const { BundleAnalyzerPlugin } = require( 'webpack-bundle-analyzer' );
const ProgressBarPlugin = require( 'progress-bar-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const WebpackNotifierPlugin = require( 'webpack-notifier' );
const LicenseCheckerWebpackPlugin = require( 'license-checker-webpack-plugin' );
const chalk = require( 'chalk' );
const package = 'Hypermarket';
const jsonp = 'webpackHypermarketJsonp';
const NODE_ENV = process.env.NODE_ENV || 'development';

const config = {
	entry: {
		'legacy-editor': './src/legacy-editor/style.css',
		admin: './src/admin',
		editor: './src/editor',
		customize: './src/customize',
		woocommerce: './src/woocommerce',
		public: './src/public',
	},
	output: {
		path: path.resolve( __dirname, './dist/' ),
		filename: '[name].js',
		libraryTarget: 'this',
		// This fixes an issue with multiple webpack projects using chunking
		// See https://webpack.js.org/configuration/output/#outputjsonpfunction
		jsonpFunction: jsonp,
	},
	mode: NODE_ENV,
	performance: {
		hints: false,
	},
	stats: {
		all: false,
		assets: true,
		builtAt: true,
		colors: true,
		errors: true,
		hash: true,
		timings: true,
	},
	watchOptions: {
		ignored: /node_modules/,
	},
	devtool: NODE_ENV === 'development' ? 'source-map' : false,
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				exclude: /node_modules/,
				use: [
					require.resolve( 'thread-loader' ),
					{
						loader: require.resolve( 'babel-loader' ),
						options: {
							cacheDirectory: process.env.BABEL_CACHE_DIRECTORY || true,
						},
					},
				],
			},
			{
				test: /\.css$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							importLoaders: 1,
						},
					},
					'css-loader',
					'postcss-loader',
				],
			},
			{
				test: /\.(ttf|eot|woff|woff2)(\?v=\d+\.\d+\.\d+)?$/,
				use: {
					loader: 'file-loader',
					options: {
						name: '[name].[ext]',
					},
				},
			},
			{
				test: /\.(png|jpg|gif|svg)$/i,
				use: {
					loader: 'url-loader',
					options: {
						encoding: true,
					},
				},
			},
		],
	},
	externals: {
		$: 'jquery',
		jQuery: 'jquery',
		'window.jQuery': 'jquery',
	},
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin( {
				extractComments: false,
			} ),
			new OptimizeCSSAssetsPlugin( {
				cssProcessorPluginOptions: {
					preset: [ 'default', { discardComments: { removeAll: true } } ],
				},
			} ),
		],
	},
	plugins: [
		new CleanWebpackPlugin( {
			cleanStaleWebpackAssets: false,
		} ),
		new BundleAnalyzerPlugin( {
			openAnalyzer: false,
			analyzerPort: 7000,
		} ),
		new FixStyleOnlyEntriesPlugin(),
		new MiniCssExtractPlugin( {
			filename: '[name].css',
		} ),
		new WebpackRTLPlugin( {
			filename: '[name]-rtl.css',
		} ),
		new ProgressBarPlugin( {
			format:
				chalk.blue( 'Build core script' ) + ' [:bar] ' + chalk.green( ':percent' ) + ' :msg (:elapsed seconds)',
		} ),
		new DependencyExtractionWebpackPlugin( {
			injectPolyfill: true,
		} ),
		new LicenseCheckerWebpackPlugin( {
			outputFilename: 'credits.txt',
			ignore: [ 'flickity' ],
		} ),
		new WebpackNotifierPlugin( {
			title: package,
			alwaysNotify: true,
			skipFirstNotification: true,
		} ),
	],
};

// Export the following module
module.exports = config;
