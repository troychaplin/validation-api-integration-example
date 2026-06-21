<?php
/**
 * Register Editor Checks
 *
 * Registers example editor checks with the Validation API plugin.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
				'namespace'    => 'validation-api-example',
				'name'         => 'first_block_heading',
				'error_msg'    => \__( 'The first block must be a Heading block.', 'validation-api-example' ),
				'warning_msg'  => \__( 'It is recommended that the first block is a Heading block.', 'validation-api-example' ),
				'description'  => \__( 'Ensures that the content starts with a heading for better accessibility and SEO.', 'validation-api-example' ),
				'level'        => 'error',
				'configurable' => true,
				'priority'     => 10,
			)
		);

		// Check 2: No more than 3 paragraphs.
		\ba11yc_register_editor_check(
			'band',
			array(
				'namespace'    => 'validation-api-example',
				'name'         => 'max_paragraphs',
				'error_msg'    => \__( 'You cannot have more than 3 paragraphs.', 'validation-api-example' ),
				'warning_msg'  => \__( 'You have more than 3 paragraphs, which might be too long.', 'validation-api-example' ),
				'description'  => \__( 'Limits the number of paragraph blocks to encourage brevity.', 'validation-api-example' ),
				'level'        => 'error',
				'configurable' => true,
				'priority'     => 20,
			)
		);
	}
}
