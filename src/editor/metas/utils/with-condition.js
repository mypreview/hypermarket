/**
 * External dependencies
 */
import includes from 'lodash/includes';

/**
 * Internal block libraries
 */
const { ifCondition } = wp.compose;

/**
 * Constants
 */
const ALLOWED_POST_TYPES = [ 'post', 'page' ];

/**
 * Generate block data.
 */
const applyWithCondition = ifCondition( ( props ) => {
	const { postType } = props;

	return postType && includes( ALLOWED_POST_TYPES, postType );
} );

export default applyWithCondition;
