/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { PluginSidebar } from '@wordpress/editor';
import { useSelect, useDispatch } from '@wordpress/data';
import { registerPlugin } from '@wordpress/plugins';
import {
	PanelBody,
	TextControl,
	__experimentalToolsPanel as ToolsPanel,
	__experimentalToolsPanelItem as ToolsPanelItem,
} from '@wordpress/components';

/**
 * Local Shim for Validation API
 */
import { useMetaField } from '../helpers/useMetaField';

const BandDetailsSidebar = () => {
	// Get post type first
	// Note: We can't conditional return yet because we have hooks to call
	const { postType } = useSelect(select => {
		const editor = select('core/editor');
		const currentPostType = editor.getCurrentPostType();
		return { postType: currentPostType };
	}, []);

	const { editPost } = useDispatch('core/editor');

	// Get validated props for each field (UNCONDITIONAL)
	// This hook handles state management regardless of whether the plugin is active
	const originProps = useMetaField(
		'band_origin',
		__(
			'Where the band originated from (e.g., "Los Angeles, CA", "London, UK")',
			'validation-api-example'
		)
	);

	const labelProps = useMetaField(
		'band_record_label',
		__(
			'The record label of the band (e.g., "Record Label Inc.", "Record Label LLC")',
			'validation-api-example'
		)
	);

	const albumProps = useMetaField(
		'band_first_album',
		__(
			'The first album of the band (e.g., "Album Title", "Album Title 2")',
			'validation-api-example'
		)
	);

	// Early return if not the band post type
	// Now safe because hooks are called above
	if (postType !== 'band') {
		return null;
	}

	return (
		<PluginSidebar name="band-details-sidebar" title={__('Band Details')} icon={'format-audio'}>
			<ToolsPanel
				label="ToolsPanel Example"
				resetAll={() =>
					editPost({
						meta: {
							band_origin: '',
						},
					})
				}
			>
				<ToolsPanelItem
					hasValue={() => originProps.value !== ''}
					label={__('City of Origin')}
					onDeselect={() => originProps.onChange('')}
					isShownByDefault
				>
					<TextControl label={__('City of Origin')} {...originProps} />
				</ToolsPanelItem>
			</ToolsPanel>

			<PanelBody title={__('PanelBody Example', 'validation-api-example')}>
				<TextControl
					label={__('Record Label', 'validation-api-example')}
					{...labelProps}
				/>
				<TextControl
					label={__('First Album', 'validation-api-example')}
					{...albumProps}
				/>
			</PanelBody>
		</PluginSidebar>
	);
};

// Register the plugin.
registerPlugin('band-details-sidebar', { render: BandDetailsSidebar });
