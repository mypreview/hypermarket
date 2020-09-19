/**
 * WordPress dependencies
 */
const { withSelect } = wp.data;

/**
 * Higher-order component used to inject state-derived props using registered selectors.
 */
const applyWithSelectMeta = withSelect( ( select ) => {
	const { getCurrentPostType, getEditedPostAttribute } = select( 'core/editor' );

	return {
		postType: getCurrentPostType(),
		getMeta: getEditedPostAttribute( 'meta' ),
	};
} );

export default applyWithSelectMeta;
