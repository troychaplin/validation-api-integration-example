/**
 * WordPress dependencies
 */
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * useMetaField Hook
 *
 * Provides standard WordPress meta field handling with validation-aware
 * border styling when the Validation API plugin is active. Reads per-meta
 * validation state from the `core/validation` store and applies an
 * error/warning wrapper class so the field gets the expected left border.
 *
 * When the Validation API plugin is not active the `core/validation` store
 * is not registered — the shim degrades gracefully to plain meta handling
 * with no wrapper class.
 *
 * USAGE:
 * Copy this file to your plugin and import it in your sidebars.
 * const props = useMetaField('my_meta_key', 'My help text');
 * <TextControl {...props} />
 *
 * @param {string} metaKey        - The meta key to manage
 * @param {string} [originalHelp] - Optional help text
 * @return {Object} Props for TextControl (value, onChange, help, className)
 */
export function useMetaField(metaKey, originalHelp = '') {
	const { value, wrapperClassName } = useSelect(
		select => {
			const editor = select('core/editor');
			const validation = select('core/validation');

			const meta = editor ? editor.getEditedPostAttribute('meta') : null;
			const currentValue = meta ? meta[metaKey] : '';

			let className = '';
			if (validation && typeof validation.getInvalidMeta === 'function') {
				const invalidMeta = validation.getInvalidMeta() || [];
				const thisField = invalidMeta.find(m => m.metaKey === metaKey);
				if (thisField?.hasErrors) {
					className = 'validation-api-meta-error';
				} else if (thisField?.hasWarnings) {
					className = 'validation-api-meta-warning';
				}
			}

			return { value: currentValue, wrapperClassName: className };
		},
		[metaKey]
	);

	const { editPost } = useDispatch('core/editor');

	return {
		value: value || '',
		onChange: newValue => {
			if (editPost) {
				editPost({ meta: { [metaKey]: newValue } });
			}
		},
		help: originalHelp,
		className: wrapperClassName ? `validation-api-field ${wrapperClassName}` : '',
	};
}
