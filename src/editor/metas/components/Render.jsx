/**
 * External dependencies
 */
import { isPlainObject, toUpper, slice, join } from 'lodash';
import applyWithCondition from './../utils/with-condition';
import applyWithSelect from './../utils/with-select';
import applyWithDispatch from './../utils/with-dispatch';
import PREFIX from './../../../utils/prefix';

/**
 * WordPress dependencies
 */
const { __, sprintf } = wp.i18n;
const { compose } = wp.compose;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { Fragment, Component } = wp.element;
const { PanelBody, ToggleControl } = wp.components;

export default compose(
	applyWithSelect,
	applyWithCondition,
	applyWithDispatch
)(
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
			const { hypermarket_metas: hmMetas } = getMeta;
			const metas = isPlainObject( hmMetas ) ? hmMetas : defaults;
			const { title, breadcrumbs, featured_media: featuredMedia } = metas;
			const target = sprintf( '%1$s-%2$s-settings', PREFIX, postType );
			// Makes the first letter of the post-type name uppercase.
			const postTypeLbl = toUpper( postType.charAt( 0 ) ) + join( slice( postType, 1 ), '' );

			return (
				<Fragment>
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
				</Fragment>
			);
		}
	}
);
