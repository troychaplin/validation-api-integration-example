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
		// Only handle our block type - FIXED: match the PHP registration
		if (blockType !== 'validation-api-example/album-card') {
			return isValid;
		}

		// Run validation based on the name of the check as defined in the PHP file
		switch (checkName) {
			case 'check_album_heading_text':
				if (attributes.headingText !== undefined && attributes.headingText !== null) {
					return !!(attributes.headingText && attributes.headingText.trim());
				}
				return true;

			// Check if the release date is valid and return true, return false if invalid
			case 'check_album_release_date':
				return !!(attributes.releaseDate && attributes.releaseDate.trim());

			// Check if the source link is valid and return true, return false if invalid
			case 'check_album_source_link':
				return !!(attributes.sourceUrl && attributes.sourceUrl.trim());

			case 'check_album_innerblock_count':
				// Check if the block has inner blocks and count paragraphs and buttons
				let paragraphCount = 0;
				let buttonCount = 0;

				if (block.innerBlocks) {
					block.innerBlocks.forEach(innerBlock => {
						if (innerBlock.name === 'core/paragraph') {
							paragraphCount++;
						} else if (
							innerBlock.name === 'core/button' ||
							innerBlock.name === 'core/buttons'
						) {
							buttonCount++;
						}
					});
				}

				// Check if the inner block count is valid and return true, return false if invalid
				// The inner block count should be between 1 and 2 for paragraphs and 1 for buttons
				return paragraphCount >= 1 && paragraphCount <= 2 && buttonCount <= 1;

			default:
				// If the check name is not recognized, let other filters handle it
				return isValid;
		}
	}
);
