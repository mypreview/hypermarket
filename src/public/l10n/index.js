/* global hypermarket */

/**
 * External dependencies
 */
import { has, isPlainObject } from 'lodash';

export const l10n = ( path ) => ( isPlainObject( hypermarket ) & has( hypermarket, path ) ? hypermarket[ path ] : '' );
