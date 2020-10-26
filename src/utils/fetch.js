/**
 * External dependencies
 */
import fetch from 'node-fetch';

const windowFetch = ( url ) => {
	return fetch( url )
		.then( ( data ) => data.json() )
		.catch( ( error ) => error );
};

export default windowFetch;
