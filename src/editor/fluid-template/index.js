/**
 * External dependencies
 */
import $ from 'jquery';
import { eq, replace } from 'lodash';

/**
 * WordPress dependencies
 */
const { subscribe, select } = wp.data;
const TEMPLATE_NAME = 'template-fluid';
const CLASSNAME = `page-template-${ TEMPLATE_NAME }`;

/**
 * Get current page template name.
 *
 * @return {string} 	The page template name.
 */
const getCurrentPageTemplate = () => {
	return select( 'core/editor' ).getEditedPostAttribute( 'template' );
};

/**
 * Checks if the current page is the fluid template.
 *
 * @return {boolean} 	Whether the `Fluid` template is being used.
 */
const isFluidTemplate = () => {
	const template = replace( getCurrentPageTemplate(), /\.[^/.]+$/, '' );
	return eq( template, TEMPLATE_NAME );
};

/**
 * Add custom class to editor wrapper if current template is `Fluid`.
 *
 * @return {void} 	Toggle CSS class name.
 */
const fluidTemplateToggleClassName = () => {
	const $editorWrapper = $( '.block-editor-writing-flow' );

	// Bail early, in case the editor wrapper is not present in the DOM.
	if ( ! $editorWrapper.length ) return;

	if ( !! isFluidTemplate() ) {
		$editorWrapper.addClass( CLASSNAME );
	} else {
		$editorWrapper.removeClass( CLASSNAME );
	}
};

/**
 * Register to listen to the editor changes to toggle the CSS class name.
 *
 * @return {void} 	Check for the `Fluid` page template any time the value of state changes.
 */
const fluidTemplateSubscribe = () => {
	subscribe( () => {
		fluidTemplateToggleClassName();
	} );
};

export default fluidTemplateSubscribe;
