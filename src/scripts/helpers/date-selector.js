import { __ } from '@wordpress/i18n';
import { SelectControl, Popover } from '@wordpress/components';
import { useState, useCallback } from '@wordpress/element';

/**
 * Formats a date string to a human-readable format with ordinal suffixes
 * @param {string} dateString - Date string in YYYY-MM-DD format
 * @return {string} Formatted date string (e.g., "January 1st, 2024")
 */
export const formatDate = dateString => {
	if (!dateString) {
		return '';
	}

	// Use local timezone to avoid day shift issues
	const date = new Date(dateString + 'T00:00:00');
	const month = date.toLocaleDateString('en-US', { month: 'long' });
	const day = date.getDate();
	const year = date.getFullYear();

	// Add ordinal suffix (st, nd, rd, th)
	const getOrdinalSuffix = num => {
		const lastDigit = num % 10;
		const lastTwoDigits = num % 100;

		if (lastTwoDigits >= 11 && lastTwoDigits <= 13) {
			return 'th';
		}

		switch (lastDigit) {
			case 1:
				return 'st';
			case 2:
				return 'nd';
			case 3:
				return 'rd';
			default:
				return 'th';
		}
	};

	return `${month} ${day}${getOrdinalSuffix(day)}, ${year}`;
};

/**
 * Generates month options for select control
 * @return {Array} Array of month options
 */
export const getMonthOptions = () => [
	{ label: 'January', value: '01' },
	{ label: 'February', value: '02' },
	{ label: 'March', value: '03' },
	{ label: 'April', value: '04' },
	{ label: 'May', value: '05' },
	{ label: 'June', value: '06' },
	{ label: 'July', value: '07' },
	{ label: 'August', value: '08' },
	{ label: 'September', value: '09' },
	{ label: 'October', value: '10' },
	{ label: 'November', value: '11' },
	{ label: 'December', value: '12' },
];

/**
 * Generates year options for select control (1900 to current year)
 * @return {Array} Array of year options
 */
export const getYearOptions = () => {
	const currentYear = new Date().getFullYear();
	const yearOptions = [];
	for (let year = currentYear; year >= 1900; year--) {
		yearOptions.push({ label: year.toString(), value: year.toString() });
	}
	return yearOptions;
};

/**
 * Generates day options for select control (1-31)
 * @return {Array} Array of day options
 */
export const getDayOptions = () => {
	const dayOptions = [];
	for (let day = 1; day <= 31; day++) {
		dayOptions.push({ label: day.toString(), value: day.toString().padStart(2, '0') });
	}
	return dayOptions;
};

/**
 * DateSelector component for selecting dates in a popover
 * @param {Object}   props               - Component props
 * @param {boolean}  props.isOpen        - Whether the popover is open
 * @param {Function} props.onClose       - Function to call when closing the popover
 * @param {string}   props.selectedMonth - Currently selected month
 * @param {string}   props.selectedDay   - Currently selected day
 * @param {string}   props.selectedYear  - Currently selected year
 * @param {Function} props.onMonthChange - Function to call when month changes
 * @param {Function} props.onDayChange   - Function to call when day changes
 * @param {Function} props.onYearChange  - Function to call when year changes
 * @param {Function} props.onDateSet     - Function to call when date is set
 * @param {string}   props.title         - Title for the date selector
 * @return {JSX.Element} DateSelector component
 */
export const DateSelector = ({
	isOpen,
	onClose,
	selectedMonth,
	selectedDay,
	selectedYear,
	onMonthChange,
	onDayChange,
	onYearChange,
	onDateSet,
	title = 'Select Date',
}) => {
	const isDateComplete = selectedMonth && selectedYear && selectedDay;

	const handleDateSet = () => {
		if (isDateComplete) {
			const date = `${selectedYear}-${selectedMonth}-${selectedDay}`;
			onDateSet(date);
			onClose();
		}
	};

	const handleClose = () => {
		// Reset the date selector state when closing
		onMonthChange('');
		onDayChange('');
		onYearChange('');
		onClose();
	};

	if (!isOpen) {
		return null;
	}

	const monthOptions = getMonthOptions();
	const dayOptions = getDayOptions();
	const yearOptions = getYearOptions();

	return (
		<Popover position="bottom center" onClose={handleClose}>
			<div style={{ padding: '16px', minWidth: '280px' }}>
				<h4
					style={{
						margin: '0 0 16px 0',
						fontSize: '14px',
						fontWeight: '600',
					}}
				>
					{title}
				</h4>

				<div
					style={{
						display: 'grid',
						gridTemplateColumns: '1fr 1fr 1fr',
						gap: '12px',
						marginBottom: '16px',
					}}
				>
					<div>
						<SelectControl
							label={__('Month', 'validation-api-example')}
							value={selectedMonth}
							options={[
								{ label: __('Month', 'validation-api-example'), value: '' },
								...monthOptions,
							]}
							onChange={onMonthChange}
							__nextHasNoMarginBottom
						/>
					</div>
					<div>
						<SelectControl
							label={__('Day', 'validation-api-example')}
							value={selectedDay}
							options={[
								{ label: __('Day', 'validation-api-example'), value: '' },
								...dayOptions,
							]}
							onChange={onDayChange}
							__nextHasNoMarginBottom
						/>
					</div>
					<div>
						<SelectControl
							label={__('Year', 'validation-api-example')}
							value={selectedYear}
							options={[
								{ label: __('Year', 'validation-api-example'), value: '' },
								...yearOptions,
							]}
							onChange={onYearChange}
							__nextHasNoMarginBottom
						/>
					</div>
				</div>

				<div
					style={{
						display: 'flex',
						gap: '8px',
						justifyContent: 'flex-end',
					}}
				>
					<button
						onClick={handleClose}
						style={{
							padding: '6px 12px',
							backgroundColor: 'transparent',
							color: '#646970',
							border: '1px solid #dcdcde',
							borderRadius: '3px',
							cursor: 'pointer',
							fontSize: '13px',
						}}
					>
						{__('Cancel', 'validation-api-example')}
					</button>
					<button
						onClick={handleDateSet}
						disabled={!isDateComplete}
						style={{
							padding: '6px 12px',
							backgroundColor: isDateComplete ? '#007cba' : '#f0f0f1',
							color: isDateComplete ? 'white' : '#a7aaad',
							border: 'none',
							borderRadius: '3px',
							cursor: isDateComplete ? 'pointer' : 'not-allowed',
							fontSize: '13px',
						}}
					>
						{__('Set Date', 'validation-api-example')}
					</button>
				</div>
			</div>
		</Popover>
	);
};

/**
 * Parses a date string and returns individual components
 * @param {string} dateString - Date string in YYYY-MM-DD format
 * @return {Object} Object with year, month, day components
 */
export const parseDateComponents = dateString => {
	if (!dateString) {
		return { year: '', month: '', day: '' };
	}

	// Handle YYYY-MM-DD format specifically - avoid timezone issues
	const dateMatch = dateString.match(/^(\d{4})-(\d{2})-(\d{2})$/);
	if (dateMatch) {
		const [, year, month, day] = dateMatch;
		return { year, month, day };
	}

	// Fallback to Date parsing for other formats
	// Use local timezone to avoid day shift issues
	const date = new Date(dateString + 'T00:00:00');
	if (isNaN(date.getTime())) {
		return { year: '', month: '', day: '' };
	}

	return {
		year: date.getFullYear().toString(),
		month: (date.getMonth() + 1).toString().padStart(2, '0'),
		day: date.getDate().toString().padStart(2, '0'),
	};
};

/**
 * Hook for managing date selector state
 * @return {Object} Date selector state and handlers
 */
export const useDateSelector = () => {
	const [selectedMonth, setSelectedMonth] = useState('');
	const [selectedDay, setSelectedDay] = useState('');
	const [selectedYear, setSelectedYear] = useState('');

	const resetDateSelection = useCallback(() => {
		setSelectedMonth('');
		setSelectedDay('');
		setSelectedYear('');
	}, []);

	return {
		selectedMonth,
		selectedDay,
		selectedYear,
		setSelectedMonth,
		setSelectedDay,
		setSelectedYear,
		resetDateSelection,
	};
};
