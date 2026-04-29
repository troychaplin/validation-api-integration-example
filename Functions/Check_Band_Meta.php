<?php
/**
 * Register Meta Checks
 *
 * Registers meta field validation checks with the Validation API plugin.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Meta Checks Class
 */
class Check_Band_Meta {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_checks' ) );
	}

	/**
	 * Register meta checks
	 *
	 * @return void
	 */
	public function register_checks(): void {
		if ( ! function_exists( 'validation_api_register_meta_check' ) ) {
			return;
		}

		validation_api_register_meta_check(
			'band',
			array(
				'namespace'   => 'validation-api-example',
				'name'        => 'required',
				'meta_key'    => 'band_origin',
				'level'       => 'error',
				'description' => __( 'The city where the band originated', 'validation-api-example' ),
				'error_msg'   => __( 'City of Origin is required.', 'validation-api-example' ),
				'warning_msg' => __( 'City of Origin is recommended.', 'validation-api-example' ),
			)
		);

		validation_api_register_meta_check(
			'band',
			array(
				'namespace'   => 'validation-api-example',
				'name'        => 'required',
				'meta_key'    => 'band_record_label',
				'level'       => 'warning',
				'description' => __( 'The record label of the band', 'validation-api-example' ),
				'error_msg'   => __( 'Record Label is required.', 'validation-api-example' ),
				'warning_msg' => __( 'Record Label is recommended.', 'validation-api-example' ),
			)
		);

		validation_api_register_meta_check(
			'band',
			array(
				'namespace'   => 'validation-api-example',
				'name'        => 'required',
				'meta_key'    => 'band_first_album',
				'level'       => 'error',
				'description' => __( 'The first album of the band', 'validation-api-example' ),
				'error_msg'   => __( 'First Album is required.', 'validation-api-example' ),
				'warning_msg' => __( 'First Album is recommended.', 'validation-api-example' ),
			)
		);
	}
}
