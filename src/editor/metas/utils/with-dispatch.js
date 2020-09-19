/**
 * WordPress dependencies
 */
const { withDispatch } = wp.data;

/**
 * Higher-order component used to add dispatch props using registered action creators.
 */
const applyWithDispatchMeta = withDispatch( ( dispatch ) => {
	return {
		setMeta: ( key, value ) => {
			dispatch( 'core/editor' ).editPost( {
				meta: { [ key ]: value },
			} );
		},
	};
} );

export default applyWithDispatchMeta;
