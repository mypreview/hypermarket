/* global hypermarket_admin */

/**
 * External dependencies
 */
import { has, isPlainObject } from 'lodash';

export const l10n = ( path ) =>
	isPlainObject( hypermarket_admin ) && has( hypermarket_admin, path ) ? hypermarket_admin[ path ] : '';
