import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { columns, gap, radius } = attributes;

	const blockProps = useBlockProps.save({
		style: {
			'--validation-api-example-card-grid-cols': String(columns),
			'--validation-api-example-card-grid-gap': `${gap}px`,
			'--validation-api-example-card-grid-radius': `${radius}px`,
		},
	});

	return (
		<div {...blockProps}>
			<InnerBlocks.Content />
		</div>
	);
}
