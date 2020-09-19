/**
 * Internal dependencies & components
 */
import render from './components/Render.jsx';

/**
 * Meta-data for registering plugin
 */
const name = 'meta-settings';

/**
 * Block settings
 */
const settings = {
	render,
	icon: 'admin-tools',
};

export { name, settings };
