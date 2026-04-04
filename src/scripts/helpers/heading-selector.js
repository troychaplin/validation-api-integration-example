import { __ } from '@wordpress/i18n';
import { ToolbarDropdownMenu } from '@wordpress/components';
import { useState, useCallback } from '@wordpress/element';
import {
	heading,
	headingLevel2,
	headingLevel3,
	headingLevel4,
	headingLevel5,
	headingLevel6,
} from '@wordpress/icons';

/**
 * Generates heading level options for dropdown menu
 * @return {Array} Array of heading level options
 */
export const getHeadingLevelOptions = () => [
	{
		title: __('Heading 2', 'validation-api-example'),
		icon: headingLevel2,
		level: 2,
	},
	{
		title: __('Heading 3', 'validation-api-example'),
		icon: headingLevel3,
		level: 3,
	},
	{
		title: __('Heading 4', 'validation-api-example'),
		icon: headingLevel4,
		level: 4,
	},
	{
		title: __('Heading 5', 'validation-api-example'),
		icon: headingLevel5,
		level: 5,
	},
	{
		title: __('Heading 6', 'validation-api-example'),
		icon: headingLevel6,
		level: 6,
	},
];

/**
 * HeadingLevelSelector component for selecting heading levels in toolbar
 * @param {Object}   props                 - Component props
 * @param {number}   props.currentLevel    - Currently selected heading level
 * @param {Function} props.onLevelChange   - Function to call when heading level changes
 * @param {string}   props.label           - Label for the dropdown menu
 * @param {Array}    props.availableLevels - Array of available heading levels (default: [2, 3, 4, 5, 6])
 * @return {JSX.Element} HeadingLevelSelector component
 */
export const HeadingLevelSelector = ({
	currentLevel = 2,
	onLevelChange,
	label = __('Change heading level', 'validation-api-example'),
	availableLevels = [2, 3, 4, 5, 6],
}) => {
	const allOptions = getHeadingLevelOptions();
	const filteredOptions = allOptions.filter(option => availableLevels.includes(option.level));

	const controls = filteredOptions.map(option => ({
		title: option.title,
		icon: option.icon,
		onClick: () => onLevelChange(option.level),
		isActive: currentLevel === option.level,
	}));

	return <ToolbarDropdownMenu icon={heading} label={label} controls={controls} />;
};

/**
 * Hook for managing heading level state
 * @param {number} initialLevel - Initial heading level (default: 2)
 * @return {Object} Heading level state and handlers
 */
export const useHeadingLevel = (initialLevel = 2) => {
	const [headingLevel, setHeadingLevel] = useState(initialLevel);

	const changeHeadingLevel = useCallback(level => {
		setHeadingLevel(level);
	}, []);

	const resetHeadingLevel = useCallback(() => {
		setHeadingLevel(initialLevel);
	}, [initialLevel]);

	return {
		headingLevel,
		changeHeadingLevel,
		resetHeadingLevel,
	};
};
