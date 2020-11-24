/**
 * External dependencies
 */
import { isPlainObject, toUpper, slice, join, includes } from 'lodash';
import PREFIX from './../../utils/prefix';

/**
 * WordPress dependencies
 */
const { __, sprintf } = wp.i18n;
const { compose, ifCondition } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { Fragment, Component } = wp.element;
const { PanelBody, ToggleControl } = wp.components;
const ALLOWED_POST_TYPES = [ 'post', 'page' ];

class Render extends Component {
	state = {
		defaults: {
			title: false,
			breadcrumbs: false,
			featured_media: false,
		},
	};

	render() {
		const { defaults } = this.state;
		const { postType, getMeta, setMeta } = this.props;
		const { keysearch_metas: hmMetas } = getMeta;
		const metas = isPlainObject( hmMetas ) ? hmMetas : defaults;
		const { title, breadcrumbs, featured_media: featuredMedia } = metas;
		const target = sprintf( '%1$s-%1$s-settings', PREFIX, postType );
		// Makes the first letter of the post-type name uppercase.
		const postTypeLbl = toUpper( postType.charAt( 0 ) ) + join( slice( postType, 1 ), '' );

		return (
			<Fragment>
				<PluginSidebarMoreMenuItem target={ target }>
					{ sprintf(
						/* translators: %s: Post type name */
						__( '%s Settings', 'keysearch' ),
						postTypeLbl
					) }
				</PluginSidebarMoreMenuItem>
				<PluginSidebar
					name={ target }
					title={ sprintf(
						/* translators: %s: Post type name */
						__( '%s Settings', 'keysearch' ),
						postTypeLbl
					) }
				>
					<PanelBody initialOpen={ true }>
						<ToggleControl
							label={
								/* translators: %s: Post type name */
								sprintf( __( 'Hide %s title?', 'keysearch' ), postType )
							}
							checked={ !! title }
							onChange={ () =>
								setMeta( 'keysearch_metas', {
									...metas,
									title: ! title,
								} )
							}
						/>
						<ToggleControl
							label={ __( 'Hide breadcrumbs?', 'keysearch' ) }
							checked={ !! breadcrumbs }
							onChange={ () =>
								setMeta( 'keysearch_metas', {
									...metas,
									breadcrumbs: ! breadcrumbs,
								} )
							}
						/>
						<ToggleControl
							label={ __( 'Hide featured image?', 'keysearch' ) }
							checked={ !! featuredMedia }
							onChange={ () =>
								setMeta( 'keysearch_metas', {
									...metas,
									featured_media: ! featuredMedia,
								} )
							}
						/>
					</PanelBody>
				</PluginSidebar>
			</Fragment>
		);
	}
}

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
