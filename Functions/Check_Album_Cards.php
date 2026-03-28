<?php
/**
 * Block Checks Integration
 *
 * This class integrates with the Validation API plugin to register validation checks for custom blocks.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

use ValidationAPI\Block\Registry as BlockChecksRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Checks Integration Class
 *
 * This class integrates with the Validation API plugin to register validation checks for custom blocks.
 */
class Check_Album_Cards {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_checks' ) );
	}

	/**
	 * Register all checks for this plugin
	 *
	 * @return void
	 */
	public function register_checks() {
		if ( ! function_exists( 'validation_api_register_plugin' ) ) {
			return;
		}

		\validation_api_register_plugin(
			array( 'name' => 'Validation API Example - Album Cards' ),
			function () {
				$this->register_album_card_checks();
			}
		);
	}

	/**
	 * Register checks for album cards
	 *
	 * @return void
	 */
	private function register_album_card_checks() {
		$registry = BlockChecksRegistry::get_instance();

		$registry->register_check(
			'validation-api-example/album-card',
			'check_album_heading_text',
			array(
				'level'       => 'error',
				'error_msg'   => __( 'A title is required for each album card.', 'validation-api-example' ),
				'warning_msg' => __( 'Consider adding an album title for better accessibility.', 'validation-api-example' ),
				'description' => __( 'Set the requirements for the album title attribute', 'validation-api-example' ),
			)
		);

		$registry->register_check(
			'validation-api-example/album-card',
			'check_album_release_date',
			array(
				'level'       => 'warning',
				'error_msg'   => __( 'A release date is required for each album card.', 'validation-api-example' ),
				'warning_msg' => __( 'Consider adding an album release date for better user experience.', 'validation-api-example' ),
				'description' => __( 'Set the requirements for the album release date attribute', 'validation-api-example' ),
			)
		);

		$registry->register_check(
			'validation-api-example/album-card',
			'check_album_source_link',
			array(
				'level'       => 'error',
				'error_msg'   => __( 'A link is required for each album card.', 'validation-api-example' ),
				'warning_msg' => __( 'Consider adding a link for better credibility.', 'validation-api-example' ),
				'description' => __( 'Set the requirements for the album link attribute', 'validation-api-example' ),
			)
		);

		$registry->register_check(
			'validation-api-example/album-card',
			'check_album_innerblock_count',
			array(
				'level'       => 'error',
				'error_msg'   => __( 'One paragraph is required for each album card to a maximum of two paragraphs. One button group is allowed per album card.', 'validation-api-example' ),
				'warning_msg' => __( 'Consider adding a paragraph for better user experience. One button group is allowed per album card.', 'validation-api-example' ),
				'description' => __( 'Ensure each album card has at least one paragraph, with a maximum of two paragraphs. Button groups are limited to one per album card.', 'validation-api-example' ),
			)
		);
	}
}
