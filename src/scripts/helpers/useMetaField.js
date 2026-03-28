/**
 * WordPress dependencies
 */
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * useMetaField Shim
 *
 * This hook provides a safe fallback for handling meta fields.
 * If the Validation API plugin is active, it uses the enhanced validation hook.
 * If not, it falls back to standard WordPress meta handling.
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
	// Always run standard hooks to comply with Rules of Hooks
	const { value } = useSelect(
		select => {
			const editor = select('core/editor');
			if (!editor) {
				return { value: '' };
			}

			const meta = editor.getEditedPostAttribute('meta');
			return {
				value: meta ? meta[metaKey] : '',
			};
		},
		[metaKey]
	);

	const { editPost } = useDispatch('core/editor');

	// 1. Try to use the plugin's hook if available
	if (
		window.ValidationAPI &&
		typeof window.ValidationAPI.useMetaField === 'function'
	) {
		// Note: This conditional hook call is theoretically unsafe if the plugin presence changes,
		// but since it's a global plugin, it's stable for the session.
		// eslint-disable-next-line react-hooks/rules-of-hooks
		return window.ValidationAPI.useMetaField(metaKey, originalHelp);
	}

	// 2. Fallback: Standard WordPress data handling
	return {
		value: value || '',
		onChange: newValue => {
			if (editPost) {
				editPost({ meta: { [metaKey]: newValue } });
			}
		},
		help: originalHelp,
		className: '',
	};
}
