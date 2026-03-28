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
addFilter(
	'validation_api_validate_meta',
	'validation-api-example/validation',
	(isValid, value, postType, metaKey, checkName) => {
		// Only validate for band post type
		if (postType !== 'band') {
			return isValid;
		}

		switch (metaKey) {
			case 'band_origin':
				if (checkName === 'required') {
					// Validate that band origin is not empty
					return !!(value && value.trim());
				}
				break;

			case 'band_record_label':
				if (checkName === 'required') {
					// Validate that band record label is not empty
					return !!(value && value.trim());
				}
				break;

			case 'band_first_album':
				if (checkName === 'required') {
					// Validate that band first album is not empty
					return !!(value && value.trim());
				}
				break;
		}

		return isValid;
	}
);
