/**
 * jQuery.
 */
import $ from 'jquery';

/**
 * Utility for libraries from the `Lodash`.
 */
import { get } from 'lodash';

/**
 * Data module to manage application state for both plugins and WordPress itself.
 * The data module is built upon and shares many of the same core principles of Redux.
 *
 * @see https://github.com/WordPress/gutenberg/tree/HEAD/packages/data/README.md
 */
import { subscribe, select } from '@wordpress/data';

/**
 * Constants.
 */
const META_KEY = 'hypermarket_meta';

/**
 * Get current post meta data.
 *
 * @return  {Object} 		    	Current post meta field.
 */
const getEditedPostAttribute = () => {
	return select( 'core/editor' ).getEditedPostAttribute( 'meta' );
};

/**
 * Get current post meta data.
 *
 * @return  {Object} 		    	Extract custom post meta field.
 */
const getEditedPostMeta = () => {
	return get( getEditedPostAttribute(), META_KEY );
};

/**
 * Add background-color CSS style.
 *
 * @return  {void}
 */
const backgroundColorStyle = () => {
	const $editorWrapper = $( '.block-editor-writing-flow' );

	// Bail early, in case the editor wrapper is not present in the DOM.
	if ( ! $editorWrapper.length ) return;

	const backgroundColor = get( getEditedPostMeta(), 'background_color' );

	if ( !! backgroundColor ) {
		$editorWrapper.css( 'backgroundColor', backgroundColor );
	} else {
		$editorWrapper.css( 'backgroundColor', '' );
	}
};

/**
 * Registers the following function(s) to be called any time the value of state changes.
 *
 * @return  {void}
 */
const backgroundColorSubscribe = () => {
	subscribe( () => {
		backgroundColorStyle();
	} );
};

export default backgroundColorSubscribe;
