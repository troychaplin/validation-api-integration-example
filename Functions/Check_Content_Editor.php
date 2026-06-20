<?php
/**
 * Register Editor Checks
 *
 * Registers example editor checks with the Block Accessibility Checks plugin.
 *
 * @package Ba11y_Checks_Example
 */

namespace Ba11y_Checks_Example;

/**
 * Register Editor Checks Class
 */
class Check_Content_Editor {

	/**
	 * Constructor
	 */
	public function __construct() {
		\add_action( 'ba11yc_editor_checks_ready', array( $this, 'register_checks' ) );
	}

	/**
	 * Register editor checks
	 *
	 * @return void
	 */
	public function register_checks(): void {
		// Check 1: First block must be a heading.
		\ba11yc_register_editor_check(
			'band',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'first_block_heading',
				'error_msg'    => \__( 'The first block must be a Heading block.', 'ba11y-checks-example' ),
				'warning_msg'  => \__( 'It is recommended that the first block is a Heading block.', 'ba11y-checks-example' ),
				'description'  => \__( 'Ensures that the content starts with a heading for better accessibility and SEO.', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'priority'     => 10,
			)
		);

		// Check 2: No more than 3 paragraphs (just as a silly example).
		\ba11yc_register_editor_check(
			'band',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'max_paragraphs',
				'error_msg'    => \__( 'You cannot have more than 3 paragraphs.', 'ba11y-checks-example' ),
				'warning_msg'  => \__( 'You have more than 3 paragraphs, which might be too long.', 'ba11y-checks-example' ),
				'description'  => \__( 'Limits the number of paragraph blocks to encourage brevity.', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'priority'     => 20,
			)
		);
	}
}
