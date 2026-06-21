import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	BlockControls,
	InnerBlocks,
	RichText,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import { link, calendar } from '@wordpress/icons';
import { ToolbarGroup, ToolbarButton, Popover } from '@wordpress/components';

import {
	formatDate,
	DateSelector,
	useDateSelector,
	parseDateComponents,
} from '../../scripts/helpers/date-selector';
import { HeadingLevelSelector } from '../../scripts/helpers/heading-selector';

export default function Edit({ attributes, setAttributes, context }) {
	const { headingText, headingLevel, sourceUrl, releaseDate, radius } = attributes;
	const HeadingTag = `h${headingLevel || 2}`;
	const [isLinkOpen, setIsLinkOpen] = useState(false);
	const [isDateOpen, setIsDateOpen] = useState(false);

	// Use the date selector hook
	const {
		selectedMonth,
		selectedDay,
		selectedYear,
		setSelectedMonth,
		setSelectedDay,
		setSelectedYear,
		resetDateSelection,
	} = useDateSelector();

	const blockProps = useBlockProps({
		className: 'validation-api-example-album-card',
		style: {
			'--validation-api-example-card-grid-radius': `${radius}px`,
		},
	});

	// Sync radius from parent block context.
	useEffect(() => {
		const contextRadius = context['validation-api-example/card-grid-radius'];
		if (contextRadius !== radius) {
			setAttributes({ radius: contextRadius });
		}
	}, [context, radius, setAttributes]);

	// Parse existing releaseDate to populate date selector state
	useEffect(() => {
		if (releaseDate) {
			const { year, month, day } = parseDateComponents(releaseDate);
			setSelectedYear(year);
			setSelectedMonth(month);
			setSelectedDay(day);
		} else {
			// Reset date selector when no releaseDate
			resetDateSelection();
		}
	}, [releaseDate, resetDateSelection, setSelectedDay, setSelectedMonth, setSelectedYear]);

	const linkSettings = {
		url: sourceUrl,
		opensInNewTab: true,
	};

	const onLinkChange = value => {
		setAttributes({ sourceUrl: value.url || '' });
	};

	const onDateSet = date => {
		setAttributes({ releaseDate: date });
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<HeadingLevelSelector
						currentLevel={headingLevel}
						onLevelChange={level => setAttributes({ headingLevel: level })}
						availableLevels={[2, 3, 4]}
					/>
					<ToolbarButton
						icon={link}
						label={
							sourceUrl
								? __('Edit link', 'validation-api-example')
								: __('Add link', 'validation-api-example')
						}
						onClick={() => setIsLinkOpen(true)}
						isPressed={!!sourceUrl}
						showTooltip
					/>
					{isLinkOpen && (
						<Popover position="bottom center" onClose={() => setIsLinkOpen(false)}>
							<LinkControl
								value={linkSettings}
								onChange={onLinkChange}
								onRemove={() => {
									setAttributes({ sourceUrl: '' });
									setIsLinkOpen(false);
								}}
							/>
						</Popover>
					)}
					<ToolbarButton
						icon={calendar}
						label={
							releaseDate
								? __('Edit release date', 'validation-api-example')
								: __('Add release date', 'validation-api-example')
						}
						onClick={() => setIsDateOpen(true)}
						isPressed={!!releaseDate}
						showTooltip
					/>
					<DateSelector
						isOpen={isDateOpen}
						onClose={() => setIsDateOpen(false)}
						selectedMonth={selectedMonth}
						selectedDay={selectedDay}
						selectedYear={selectedYear}
						onMonthChange={setSelectedMonth}
						onDayChange={setSelectedDay}
						onYearChange={setSelectedYear}
						onDateSet={onDateSet}
						title="Select Release Date"
						textDomain="validation-api-example"
					/>
				</ToolbarGroup>
			</BlockControls>

			<article {...blockProps}>
				<div>
					{sourceUrl ? (
						<a href={sourceUrl} target="_blank" rel="noopener noreferrer">
							<RichText
								tagName={HeadingTag}
								placeholder="Add a album title..."
								onChange={value => setAttributes({ headingText: value })}
								value={headingText || ''}
								allowedFormats={[]}
							/>
						</a>
					) : (
						<RichText
							tagName={HeadingTag}
							placeholder="Add a album title..."
							onChange={value => setAttributes({ headingText: value })}
							value={headingText || ''}
							allowedFormats={[]}
						/>
					)}
					{releaseDate && <p>Release Date: {formatDate(releaseDate)}</p>}
					<InnerBlocks
						allowedBlocks={['core/paragraph', 'core/button', 'core/buttons']}
						template={[['core/paragraph']]}
						templateLock={false}
					/>
				</div>
			</article>
		</>
	);
}
