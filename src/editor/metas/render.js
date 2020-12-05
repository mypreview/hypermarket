/**
 * External dependencies
 */
import { isPlainObject, toUpper, slice, join, includes } from 'lodash';
import PREFIX from './../../utils/prefix';

/**
 * WordPress dependencies
 */
const { __, sprintf } = wp.i18n;
const { useState } = wp.element;
const { compose, ifCondition } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { PanelBody, ToggleControl } = wp.components;
const ALLOWED_POST_TYPES = [ 'post', 'page' ];

const Render = ( { postType, getMeta, setMeta } ) => {
	const [ defaults ] = useState( {
			title: false,
			breadcrumbs: false,
			featured_media: false,
		} ),
		{ hypermarket_metas: hmMetas } = getMeta,
		metas = isPlainObject( hmMetas ) ? hmMetas : defaults,
		{ title, breadcrumbs, featured_media: featuredMedia } = metas,
		target = sprintf( '%1$s-%1$s-settings', PREFIX, postType ),
		// Makes the first letter of the post-type name uppercase.
		postTypeLbl = toUpper( postType.charAt( 0 ) ) + join( slice( postType, 1 ), '' );

	return (
		<>
			<PluginSidebarMoreMenuItem target={ target }>
				{ sprintf(
					/* translators: %s: Post type name */
					__( '%s Settings', 'hypermarket' ),
					postTypeLbl
				) }
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name={ target }
				title={ sprintf(
					/* translators: %s: Post type name */
					__( '%s Settings', 'hypermarket' ),
					postTypeLbl
				) }
			>
				<PanelBody initialOpen={ true }>
					<ToggleControl
						label={
							/* translators: %s: Post type name */
							sprintf( __( 'Hide %s title?', 'hypermarket' ), postType )
						}
						checked={ !! title }
						onChange={ () =>
							setMeta( 'hypermarket_metas', {
								...metas,
								title: ! title,
							} )
						}
					/>
					<ToggleControl
						label={ __( 'Hide breadcrumbs?', 'hypermarket' ) }
						checked={ !! breadcrumbs }
						onChange={ () =>
							setMeta( 'hypermarket_metas', {
								...metas,
								breadcrumbs: ! breadcrumbs,
							} )
						}
					/>
					<ToggleControl
						label={ __( 'Hide featured image?', 'hypermarket' ) }
						checked={ !! featuredMedia }
						onChange={ () =>
							setMeta( 'hypermarket_metas', {
								...metas,
								featured_media: ! featuredMedia,
							} )
						}
					/>
				</PanelBody>
			</PluginSidebar>
		</>
	);
};

export default compose(
	withSelect( ( select ) => {
		const { getCurrentPostType, getEditedPostAttribute } = select( 'core/editor' );
		return {
			postType: getCurrentPostType(),
			getMeta: getEditedPostAttribute( 'meta' ),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			setMeta: ( key, value ) => {
				dispatch( 'core/editor' ).editPost( {
					meta: { [ key ]: value },
				} );
			},
		};
	} ),
	ifCondition( ( props ) => {
		const { postType } = props;
		return postType && includes( ALLOWED_POST_TYPES, postType );
	} )
)( Render );
