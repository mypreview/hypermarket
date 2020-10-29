/**
 * External dependencies
 */
import $ from 'jquery';
import moment from 'moment';
import { map, join, forEach, isEmpty, escape, truncate, isPlainObject } from 'lodash';
import { __ } from '@wordpress/i18n';
import { addQueryArgs } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';
import striptags from 'striptags';
import windowFetch from './../../utils/fetch';
import { l10n } from './../l10n';
const API = 'https://api.wordpress.org/plugins/info/1.2/';

export const plugins = {
	cache() {
		plugins.els = {};
		plugins.vars = {};
		plugins.vars.selector = 'hypermarket-welcome';
		plugins.vars.extension = `${ plugins.vars.selector }__extension`;
		plugins.vars.$extensions = $( `.${ plugins.vars.selector }__extensions ul` );
	},
	// Execute callback after the DOM is loaded.
	ready() {
		plugins.cache();
		plugins.list();
	},
	// Retrieve information of the given plugin list.
	async list() {
		let template = '';
		const results = await windowFetch(
			`https://api.wordpress.org/plugins/info/1.2/${ plugins._api( plugins._list() ) }`
		);
		console.log(results);
		if ( isPlainObject( results ) ) {
			forEach( results, ( post, key ) => {
				const title = decodeEntities( post.name );
				template += '<li>';
				template += plugins._figure( key, post.banners.low, title );
				template += `<div class="${ plugins.vars.extension }-meta">`;
				template += plugins._uri( key, title );
				template += plugins._author( post.author );
				template += plugins._lastUpdated( post.last_updated );
				template += plugins._excerpt( key, post.sections.description );
				template += plugins._uri( key, __( 'Get the plugin' ), true );
				template += '</div>';
				template += '</li>';
			} );

			plugins.vars.$extensions.append( template );
		}
	},
	// Create a fetchable API address. 
	_api( extensions, key = 'request[slugs]' ) {
		extensions = map( extensions, encodeURIComponent );
		return `?action=plugin_information&${ key }[]=${ join( extensions, `&${ key }[]=` ) }`;
	},
	// URI.
	_uri( key, content = '', isFrame = false ) {
		const uri = `https://wordpress.org/plugins/${ key }`;
		if ( ! isEmpty( content ) ) {
			let template = '';
			if ( !! isFrame ) {
				template += `<a href="${ plugins._installUri( key ) }" target="_blank" class="thickbox button-primary" data-plugin="${ key }" rel="nofollow">`;
			} else {
				template += `<a href="${ uri }" target="_blank" data-plugin="${ key }" rel="nofollow">`;
			}
			template += content;
			template += '</a>';
			return template;
		}
		return uri;
	},
	// Thumbnail.
	_figure( key, src, title ) {
		const image = `<img src="${ src }" width="772" height="250" alt="${ title }" />`;
		let template = `<figure class="${ plugins.vars.extension }-banner">`;
		template += plugins._uri( key, image );
		template += '</figure>';
		return template;
	},
	// Author.
	_author( author ) {
		let template = `<span class="${ plugins.vars.extension }-byline">`;
		template += __( 'by', 'hypermarket' );
		template += ` ${ author }`;
		template += '</span>';
		return template;
	},
	// Short description.
	_excerpt( key, content ) {
		let template = `<div class="${ plugins.vars.extension }-excerpt"><p>`;
		template += truncate( striptags( content ), { length: 200 } );
		template += `<small>${ plugins._uri( key, __( 'Read more', 'hypermarket' ) ) }</small>`;
		template += '</p></div>';
		return template;
	},
	// Plugin install URI.
	_installUri( slug ) {
		return addQueryArgs( l10n( 'install_uri' ), {
			tab: 'plugin-information',
			plugin: slug,
			TB_iframe: 'true',
			width: '744',
			height: '800',
		} );
	},
	_lastUpdated( date ) {
		let template = `<div class="${ plugins.vars.extension }-updated"><p>`;
		template += __( 'Last Updated:', 'hypermarket' );
		template += moment(date, 'YYYY-MM-DDTHH:mm:ss').fromNow();
		template += '</p></div>';
		return template;
	},
	// List of plugins/extensions.
	_list() {
		return [ 'woocommerce', 'woo-store-vacation', 'woo-additional-terms', 'block-data-attribute', 'seo-ready', 'jetpack' ];
	},
};
