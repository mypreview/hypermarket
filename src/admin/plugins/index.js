/**
 * External dependencies
 */
import $ from 'jquery';
import { map, join, forEach, isEmpty, escape, truncate, isPlainObject } from 'lodash';
import { __ } from '@wordpress/i18n';
import { decodeEntities } from '@wordpress/html-entities';
import striptags from 'striptags';
import slug from './../../utils/slugify';
import windowFetch from './../../utils/fetch';
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
	async list() {
		let template = '';
		const results = await windowFetch(
			`https://api.wordpress.org/plugins/info/1.2/${ plugins._api( plugins._list() ) }`
		);
		console.info( results );
		if ( isPlainObject( results ) ) {
			forEach( results, ( post, key ) => {
				const title = decodeEntities( post.name );
				template += '<li>';
				template += plugins._figure( key, post.banners.low, title );
				template += `<div class="${ plugins.vars.extension }-meta">`;
				template += plugins._uri( key, title );
				template += plugins._author( post.author );
				template += plugins._excerpt( key, post.sections.description );
				template += '</div>';
				template += '</li>';
			} );

			plugins.vars.$extensions.append( template );
		}
	},
	_api( extensions, key = 'request[slugs]' ) {
		extensions = map( extensions, encodeURIComponent );
		return `?action=plugin_information&${ key }[]=${ join( extensions, `&${ key }[]=` ) }`;
	},
	_uri( key, content = '' ) {
		const uri = `https://wordpress.org/plugins/${ key }`;
		if ( ! isEmpty( content ) ) {
			let template = `<a href="${ uri }" target="_blank" data-plugin="${ key }" rel="nofollow">`;
			template += content;
			template += '</a>';
			return template;
		}
		return uri;
	},
	_figure( key, src, title ) {
		const image = `<img src="${ src }" width="772" height="250" alt="${ title }" />`;
		let template = `<figure class="${ plugins.vars.extension }-banner">`;
		template += plugins._uri( key, image );
		template += '</figure>';
		return template;
	},
	_author( author ) {
		let template = `<span class="${ plugins.vars.extension }-byline">`;
		template += __( 'by', 'hypermarket' );
		template += ` ${ author }`;
		template += '</span>';
		return template;
	},
	_excerpt( key, content ) {
		let template = `<div class="${ plugins.vars.extension }-excerpt"><p>`;
		template += truncate( striptags( content ), { length: 200 } );
		template += `<small>${ plugins._uri( key, __( 'Read more', 'hypermarket' ) ) }</small>`;
		template += '</p></div>';
		return template;
	},
	_list() {
		return [ 'woo-store-vacation', 'jetpack' ];
	},
};
