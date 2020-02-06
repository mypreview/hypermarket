/**
 * All of the the JavaScript compile functionality 
 * for Container Block plugin reside in this file.
 *
 * @requires    Webpack
 * @package     hypermarket
 * @author      MyPreview (Github: @mahdiyazdani, @mypreview)
 */
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const ProgressBarPlugin = require( 'progress-bar-webpack-plugin' );
const UglifyJsPlugin = require( 'uglifyjs-webpack-plugin' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const WebpackRTLPlugin = require( 'webpack-rtl-plugin' );
const chalk = require( 'chalk' );
const NODE_ENV = process.env.NODE_ENV || 'development';

const baseConfig = {
    entry: {
        'theme': './assets/src/theme/index.js',
        'editor': './assets/src/editor/index.js',
        'legacy-editor': './assets/src/legacy-editor/index.js',
        'woocommerce': './assets/src/woocommerce/index.js'
    },
    output: {
        path: path.resolve( __dirname, './assets/dist/' ),
        filename: '[name].js',
        libraryTarget: 'this',
        // This fixes an issue with multiple webpack projects using chunking
        // See https://webpack.js.org/configuration/output/#outputjsonpfunction
        jsonpFunction: 'webpackHypermarketJsonp'
    },
    mode: NODE_ENV,
    performance: {
        hints: false
    },
    stats: {
        all: false,
        assets: true,
        builtAt: true,
        colors: true,
        errors: true,
        hash: true,
        timings: true
    },
    watchOptions: {
        ignored: /node_modules/
    },
    devtool: NODE_ENV === 'development' ? 'source-map' : false,
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader?cacheDirectory',
                    options: {
                        presets: [ '@wordpress/babel-preset-default' ]
                    }
                }
            },
            {
                test:/\.css$/,
                use: [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    { 
                        loader: 'css-loader', 
                        options: { 
                            importLoaders: 1 
                        } 
                    }
                ]
            },
            {
                test: /\.(woff|woff2)(\?v=\d+\.\d+\.\d+)?$/,
                use: {
                    loader: 'file-loader',
                    options: { 
                        limit: 50000,
                        mimetype: 'application/font-woff',
                        name: '[name].[ext]',
                        outputPath: './dist/'
                    }
                }
            }
        ],
    },
    externals: {
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery'
    },
    optimization: {
        minimizer: [ 
            new UglifyJsPlugin( {
                cache: true,
                parallel: true,
                uglifyOptions: {
                    output: {
                        ie8: false,
                        comments: false
                    }
                }
            } )
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin( {
            filename: '[name].css'
        } ),
        new WebpackRTLPlugin( {
            filename: '[name]-rtl.css'
        } ),
        new ProgressBarPlugin( {
            format: chalk.blue( 'Build core script' ) + ' [:bar] ' + chalk.green( ':percent' ) + ' :msg (:elapsed seconds)',
        } ),
        new DependencyExtractionWebpackPlugin( { 
            injectPolyfill: true 
        } )
    ]
};

// Export the following module
module.exports = [baseConfig];