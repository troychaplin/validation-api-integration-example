/**
 * Album Card Validation API
 *
 * Integrates with the Validation API plugin validation system.
 * All validation logic is now handled in JavaScript only.
 */

import { addFilter } from '@wordpress/hooks';

/**
 * Register validation logic for album card block using the unified hook system
 */
addFilter(
	'editor.validateBlock',
	'validation-api-example/validation',
	(isValid, blockType, attributes, checkName, block) => {
		if (blockType !== 'validation-api-example/album-card') {
			return isValid;
		}

		switch (checkName) {
			case 'check_album_heading_text':
				return !!(attributes.headingText && attributes.headingText.trim());

			case 'check_album_release_date':
				return !!(attributes.releaseDate && attributes.releaseDate.trim());

			case 'check_album_source_link':
				return !!(attributes.sourceUrl && attributes.sourceUrl.trim());

			case 'check_album_innerblock_count': {
				const paragraphCount = (block.innerBlocks ?? []).filter(
					b => b.name === 'core/paragraph'
				).length;
				const buttonCount = (block.innerBlocks ?? []).filter(
					b => b.name === 'core/button' || b.name === 'core/buttons'
				).length;
				return paragraphCount >= 1 && paragraphCount <= 2 && buttonCount <= 1;
			}

			default:
				return isValid;
		}
	}
);
