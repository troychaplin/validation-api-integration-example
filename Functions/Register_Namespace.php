<?php
/**
 * Register Namespace
 *
 * Declares the display name for this plugin's validation checks. Without it,
 * the Validation settings screen credits every check to the raw namespace
 * slug ("validation-api-example") instead of a readable plugin name.
 *
 * Only needs calling once, no matter how many checks the plugin registers,
 * and it may run before or after them.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Namespace Class
 */
class Register_Namespace {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_namespace' ) );
	}

	/**
	 * Register the namespace display name
	 *
	 * @return void
	 */
	public function register_namespace(): void {
		if ( ! function_exists( 'validation_api_register_namespace' ) ) {
			return;
		}

		validation_api_register_namespace(
			'validation-api-example',
			array(
				'title' => __( 'Validation API Example', 'validation-api-example' ),
			)
		);
	}
}
