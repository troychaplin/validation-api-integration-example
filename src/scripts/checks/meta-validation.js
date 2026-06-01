/**
 * Meta Validation for Band Post Type
 *
 * Provides client-side validation for band meta fields.
 */

import { addFilter } from '@wordpress/hooks';

/**
 * Validate band meta fields
 *
 * This filter integrates with the Validation API plugin
 * to validate post meta fields in real-time.
 */
const BAND_META_KEYS = new Set(['band_origin', 'band_record_label', 'band_first_album']);

addFilter(
	'editor.validateMeta',
	'validation-api-example/validation',
	(isValid, value, postType, metaKey, checkName) => {
		if (postType !== 'band' || !BAND_META_KEYS.has(metaKey) || checkName !== 'required') {
			return isValid;
		}
		return !!(value && value.trim());
	}
);
