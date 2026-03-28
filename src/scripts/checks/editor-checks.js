import { addFilter } from '@wordpress/hooks';

/**
 * Editor Validation Checks
 */

// Check 1: First block must be a heading
addFilter(
	'validation_api_validate_editor',
	'validation-api-example/first-block-heading',
	(isValid, blocks, _postType, checkName) => {
		// Only process this specific check
		if (checkName !== 'first_block_heading') {
			return isValid;
		}

		// The validation system already filters by post type, so we don't need to check it here
		// This check will only run for post types where it's registered (post, page, etc.)

		if (!blocks || blocks.length === 0) {
			return true; // Empty editor is fine? Or maybe not. Let's say fine.
		}

		const firstBlock = blocks[0];
		if (firstBlock.name !== 'core/heading') {
			return false;
		}

		return true;
	}
);

// Check 2: Max 3 paragraphs
addFilter(
	'validation_api_validate_editor',
	'validation-api-example/max-paragraphs',
	(isValid, blocks, _postType, checkName) => {
		// Only process this specific check
		if (checkName !== 'max_paragraphs') {
			return isValid;
		}

		// The validation system already filters by post type, so we don't need to check it here

		const paragraphCount = blocks.reduce((count, block) => {
			if (block.name === 'core/paragraph') {
				return count + 1;
			}
			return count;
		}, 0);

		if (paragraphCount > 3) {
			return false;
		}

		return true;
	}
);
