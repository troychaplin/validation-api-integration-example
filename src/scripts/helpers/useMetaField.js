/**
 * WordPress dependencies
 */
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * useMetaField Hook
 *
 * Provides standard WordPress meta field handling with validation integration.
 * When the Validation API plugin is active, the `useMetaField` and
 * `useMetaValidation` hooks can be imported directly from the plugin's script
 * module for enhanced validation support.
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
