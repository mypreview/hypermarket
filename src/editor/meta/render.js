/**
 * Utility for libraries from the `Lodash`.
 */
import { get, isPlainObject, toUpper, slice, join, includes } from 'lodash';

/**
 * Theme prefix.
 */
import PREFIX from './../../utils/prefix';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __, sprintf } from '@wordpress/i18n';

/**
 * Data module to manage application state for both plugins and WordPress itself.
 * The data module is built upon and shares many of the same core principles of Redux.
 *
 * @see https://github.com/WordPress/gutenberg/tree/HEAD/packages/data/README.md
 */
import { withSelect, useSelect, useDispatch } from '@wordpress/data';

/**
 * Edit Post Module for WordPress.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/edit-post/README.md
 */
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';

/**
 * The compose package is a collection of handy Hooks and Higher Order Components (HOCs).
 * The compose function is an alias to `flowRight` from Lodash.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/packages/compose/README.md
 */
import { compose, ifCondition } from '@wordpress/compose';

/**
 * WordPress specific abstraction layer atop React.
 *
 * @see https://github.com/WordPress/gutenberg/tree/HEAD/packages/element/README.md
 */
import { useState } from '@wordpress/element';

/**
 * This packages includes a library of generic WordPress components to be used for
 * creating common UI elements shared between screens and features of the WordPress dashboard.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
 */
import { PanelBody, ToggleControl, ColorPalette } from '@wordpress/components';

/**
 * Constants.
 */
const META_KEY = 'hypermarket_meta';
const ALLOWED_POST_TYPES = [ 'post', 'page' ];

/**
 * Inspector Controls appear in the post settings sidebar when a block is being edited.
 *
 * @see https://github.com/WordPress/gutenberg/blob/master/packages/block-editor/src/components/inspector-controls/README.md
 * @param 	{Object} 	props 					    Plugin meta-data properties.
 * @param 	{Object} 	props.postType 		    	The post type of the current post.
 * @return 	{WPElement} 						    Inspector element to render.
 */
const Render = ( { postType } ) => {
	const [ defaults ] = useState( {
		title: false,
		breadcrumbs: false,
		featured_media: false,
		background_color: '',
	} );
	const { colors, postId, getMeta } = useSelect( ( select ) => {
		const { getSettings } = select( 'core/block-editor' ),
			{ getCurrentPostId, getEditedPostAttribute } = select( 'core/editor' );

		return {
			postId: getCurrentPostId(),
			colors: get( getSettings(), 'colors' ),
			getMeta: getEditedPostAttribute( 'meta' ),
		};
	} );
	const { editEntityRecord } = useDispatch( 'core' );
	const { [ META_KEY ]: data } = getMeta;
	const postMeta = isPlainObject( data ) ? data : defaults;
	const updateMeta = ( key, value ) => {
		editEntityRecord( 'postType', postType, postId, {
			meta: { [ META_KEY ]: { ...postMeta, [ key ]: value } },
		} );
	};
	const { title, breadcrumbs, background_color: backgroundColor, featured_media: featuredMedia } = postMeta;
	const postTypeLabel = toUpper( postType.charAt( 0 ) ) + join( slice( postType, 1 ), '' ); // Makes the first letter of the post-type name uppercase.
	const target = `${ PREFIX }-${ postType }-settings`;

	return (
		<>
			<PluginSidebarMoreMenuItem target={ target }>
				{ sprintf(
					/* translators: %s: Post type name */
					__( '%s Settings', 'hypermarket' ),
					postTypeLabel
				) }
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name={ target }
				title={ sprintf(
					/* translators: %s: Post type name */
					__( '%s Settings', 'hypermarket' ),
					postTypeLabel
				) }
			>
				<PanelBody initialOpen={ true }>
					<ToggleControl
						label={
							/* translators: %s: Post type name */
							sprintf( __( 'Hide %s title?', 'hypermarket' ), postType )
						}
						checked={ !! title }
						onChange={ () => updateMeta( 'title', ! title ) }
					/>
					<ToggleControl
						label={ __( 'Hide breadcrumbs?', 'hypermarket' ) }
						checked={ !! breadcrumbs }
						onChange={ () => updateMeta( 'breadcrumbs', ! breadcrumbs ) }
					/>
					<ToggleControl
						label={ __( 'Hide featured image?', 'hypermarket' ) }
						checked={ !! featuredMedia }
						onChange={ () => updateMeta( 'featured_media', ! featuredMedia ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Background Settings', 'hypermarket' ) } initialOpen={ false }>
					<ColorPalette
						clearable={ true }
						colors={ colors }
						value={ backgroundColor }
						onChange={ ( value ) => updateMeta( 'background_color', value ) }
					/>
				</PanelBody>
			</PluginSidebar>
		</>
	);
};

export default compose(
	withSelect( ( select ) => {
		const { getCurrentPostType } = select( 'core/editor' );
		return {
			postType: getCurrentPostType(),
		};
	} ),
	ifCondition( ( props ) => {
		const { postType } = props;
		return postType && includes( ALLOWED_POST_TYPES, postType );
	} )
)( Render );
