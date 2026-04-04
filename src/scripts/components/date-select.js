import { __ } from '@wordpress/i18n';
import { SelectControl, TextControl } from '@wordpress/components';

/**
 * Generates month options for select control
 * @return {Array} Array of month options
 */
export const getMonthOptions = () => [
	{ label: __('Select month', 'validation-api-example'), value: '' },
	{ label: __('January', 'validation-api-example'), value: '01' },
	{ label: __('February', 'validation-api-example'), value: '02' },
	{ label: __('March', 'validation-api-example'), value: '03' },
	{ label: __('April', 'validation-api-example'), value: '04' },
	{ label: __('May', 'validation-api-example'), value: '05' },
	{ label: __('June', 'validation-api-example'), value: '06' },
	{ label: __('July', 'validation-api-example'), value: '07' },
	{ label: __('August', 'validation-api-example'), value: '08' },
	{ label: __('September', 'validation-api-example'), value: '09' },
	{ label: __('October', 'validation-api-example'), value: '10' },
	{ label: __('November', 'validation-api-example'), value: '11' },
	{ label: __('December', 'validation-api-example'), value: '12' },
];

/**
 * DateSelect component for selecting month, day, and year
 * @param {Object}   props               - Component props
 * @param {string}   props.month         - Currently selected month
 * @param {string}   props.day           - Currently selected day (1-31)
 * @param {string}   props.year          - Currently selected year
 * @param {Function} props.onMonthChange - Function to call when month changes
 * @param {Function} props.onDayChange   - Function to call when day changes
 * @param {Function} props.onYearChange  - Function to call when year changes
 * @return {JSX.Element} DateSelect component
 */
export const DateSelect = ({
	month = '',
	day = '',
	year = '',
	onMonthChange,
	onDayChange,
	onYearChange,
}) => {
	const monthOptions = getMonthOptions();

	/**
	 * Validates and handles day input (1-31)
	 * @param {string} value - Input value
	 */
	const handleDayChange = value => {
		// Allow empty value
		if (value === '') {
			onDayChange('');
			return;
		}

		// Only allow numbers
		const numValue = parseInt(value, 10);
		if (!isNaN(numValue) && numValue >= 1 && numValue <= 31) {
			onDayChange(value);
		}
	};

	/**
	 * Validates and handles year input (1900-2100)
	 * @param {string} value - Input value
	 */
	const handleYearChange = value => {
		// Allow empty value
		if (value === '') {
			onYearChange('');
			return;
		}

		// Only allow numbers
		const numValue = parseInt(value, 10);
		if (!isNaN(numValue) && numValue >= 1900 && numValue <= 2100) {
			onYearChange(value);
		}
	};

	return (
		<div style={{ display: 'flex', gap: '12px', alignItems: 'flex-start' }}>
			<div style={{ flex: '2' }}>
				<SelectControl
					label={__('Month', 'validation-api-example')}
					value={month}
					options={monthOptions}
					onChange={onMonthChange}
					__nextHasNoMarginBottom
				/>
			</div>
			<div style={{ flex: '1' }}>
				<TextControl
					label={__('Day', 'validation-api-example')}
					value={day}
					type="number"
					min="1"
					max="31"
					onChange={handleDayChange}
					help={__('1–31', 'validation-api-example')}
					__nextHasNoMarginBottom
				/>
			</div>
			<div style={{ flex: '1' }}>
				<TextControl
					label={__('Year', 'validation-api-example')}
					value={year}
					type="number"
					min="1900"
					max="2100"
					onChange={handleYearChange}
					help={__('1900–2100', 'validation-api-example')}
					__nextHasNoMarginBottom
				/>
			</div>
		</div>
	);
};

/**
 * Parses a date string into individual components
 * @param {string} dateString - Date string in YYYY-MM-DD format
 * @return {Object} Object with month, day, year components
 */
export const parseDateComponents = dateString => {
	if (!dateString) {
		return { month: '', day: '', year: '' };
	}
	const match = dateString.match(/^(\d{4})-(\d{2})-(\d{2})$/);
	if (match) {
		return { year: match[1], month: match[2], day: match[3] };
	}
	return { month: '', day: '', year: '' };
};

/**
 * Formats date components into a YYYY-MM-DD string
 * @param {string} year  - Year value
 * @param {string} month - Month value (01-12)
 * @param {string} day   - Day value (1-31)
 * @return {string} Formatted date string or empty string if incomplete
 */
export const formatDateString = (year, month, day) => {
	if (!year || !month || !day) {
		return '';
	}
	const paddedDay = day.padStart(2, '0');
	return `${year}-${month}-${paddedDay}`;
};

/**
 * Hook for managing date component state with a single date string
 * @param {string}   dateString   - Initial date in YYYY-MM-DD format
 * @param {Function} onDateChange - Callback when complete date changes
 * @return {Object} Date component handlers
 */
export const useDateComponents = (dateString, onDateChange) => {
	const components = parseDateComponents(dateString);

	const updateComponent = (component, value) => {
		const updated = { ...components, [component]: value };

		// Only call onChange if all three components are filled
		if (updated.month && updated.day && updated.year) {
			const formattedDate = formatDateString(updated.year, updated.month, updated.day);
			onDateChange(formattedDate);
		} else if (!updated.month && !updated.day && !updated.year) {
			// Clear the date if all fields are empty
			onDateChange('');
		}
	};

	return {
		month: components.month,
		day: components.day,
		year: components.year,
		onMonthChange: value => updateComponent('month', value),
		onDayChange: value => updateComponent('day', value),
		onYearChange: value => updateComponent('year', value),
	};
};
