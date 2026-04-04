import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes, style }) {
	const { columns, gap, radius, aspectRatio } = attributes;

	const blockProps = useBlockProps({
		className: 'validation-api-example-editor',
		style: {
			...style,
			'--validation-api-example-card-grid-cols': String(columns),
			'--validation-api-example-card-grid-gap': `${gap}px`,
			'--validation-api-example-card-grid-radius': `${radius}px`,
			'--validation-api-example-card-grid-aspect-ratio': aspectRatio,
		},
	});

	const allowedBlocks = ['validation-api-example/album-card'];

	const blockTemplate = [
		['validation-api-example/album-card'],
		['validation-api-example/album-card'],
	];

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Card Grid Settings', 'validation-api-example')}>
					<RangeControl
						label={__('Number of Columns', 'validation-api-example')}
						min={1}
						max={6}
						value={columns}
						onChange={value => setAttributes({ columns: value })}
					/>
					<RangeControl
						label={__('Card Gap', 'validation-api-example')}
						min={0}
						max={50}
						value={gap}
						onChange={value => setAttributes({ gap: value })}
					/>
					<RangeControl
						label={__('Card Radius', 'validation-api-example')}
						min={0}
						max={50}
						value={radius}
						onChange={value => setAttributes({ radius: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<InnerBlocks
					allowedBlocks={allowedBlocks}
					template={blockTemplate}
					orientation="horizontal"
					templateLock={false}
				/>
			</div>
		</>
	);
}
