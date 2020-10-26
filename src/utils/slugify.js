/**
 * External dependencies
 */
import striptags from 'striptags';
import slugify from 'slugify';

const slug = ( text ) => {
	return slugify( striptags( text ), {
		replacement: '-',
		remove: /[*_+~()'"!?\/\-—–−:@^|&#.,;%<>{}\/\d-]/g,
		lower: true,
	} );
};

export default slug;
