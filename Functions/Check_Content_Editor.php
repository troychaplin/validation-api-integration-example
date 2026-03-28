<?php
/**
 * Register Editor Checks
 *
 * Registers example editor checks with the Validation API plugin.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

use ValidationAPI\Editor\Registry as EditorChecksRegistry;

/**
 * Register Editor Checks Class
 */
class Check_Content_Editor {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_checks' ) );
	}

	/**
	 * Register editor checks
	 *
	 * @return void
	 */
	public function register_checks(): void {
		if ( ! function_exists( 'validation_api_register_plugin' ) ) {
			return;
		}

		\validation_api_register_plugin(
			array( 'name' => 'Validation API Example - Editor Checks' ),
			function () {
				$registry = EditorChecksRegistry::get_instance();

				// Check 1: First block must be a heading (for multiple post types).
				$registry->register_editor_check(
					'band',
					'first_block_heading',
					array(
						'level'       => 'error',
						'error_msg'   => __( 'The first block must be a Heading block.', 'validation-api-example' ),
						'warning_msg' => __( 'It is recommended that the first block is a Heading block.', 'validation-api-example' ),
						'description' => __( 'Ensures that the content starts with a heading for better accessibility and SEO.', 'validation-api-example' ),
					)
				);

				// Check 2: No more than 3 paragraphs (just as a silly example).
				$registry->register_editor_check(
					'band',
					'max_paragraphs',
					array(
						'level'       => 'error',
						'error_msg'   => __( 'You cannot have more than 3 paragraphs.', 'validation-api-example' ),
						'warning_msg' => __( 'You have more than 3 paragraphs, which might be too long.', 'validation-api-example' ),
						'description' => __( 'Limits the number of paragraph blocks to encourage brevity.', 'validation-api-example' ),
					)
				);
			}
		);
	}
}
