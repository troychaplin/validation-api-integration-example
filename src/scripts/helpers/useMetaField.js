/**
 * WordPress dependencies
 */
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * useMetaField
 *
 * A hook for binding a post meta field to an editor component with a clean
 * fallback when the Block Accessibility Checks plugin is not active.
 *
 * The BAC plugin's `useMetaField` hook is now a named export from its editor
 * module rather than a global. If your build pipeline resolves
 * `@block-accessibility-checks/editor`, import from there instead:
 *
 *   import { useMetaField } from '@block-accessibility-checks/editor';
 *
 * Otherwise, this shim handles standard WordPress meta binding so your plugin
 * continues to work when BAC is deactivated.
 *
 * @param {string} metaKey        - The meta key to manage
 * @param {string} [originalHelp] - Optional help text
 * @return {Object} Props for TextControl (value, onChange, help, className)
 */
export function useMetaField( metaKey, originalHelp = '' ) {
	const { value } = useSelect(
		select => {
			const editor = select( 'core/editor' );
			if ( ! editor ) {
				return { value: '' };
			}

			const meta = editor.getEditedPostAttribute( 'meta' );
			return {
				value: meta ? meta[ metaKey ] : '',
			};
		},
		[ metaKey ]
	);

	const { editPost } = useDispatch( 'core/editor' );

	return {
		value: value || '',
		onChange: newValue => {
			if ( editPost ) {
				editPost( { meta: { [ metaKey ]: newValue } } );
			}
		},
		help: originalHelp,
		className: '',
	};
}
