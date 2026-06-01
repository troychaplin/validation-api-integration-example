<?php
/**
 * Register Blocks
 *
 * This class is responsible for registering the blocks for the plugin.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

use Validation_API_Example\Plugin_Paths;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Blocks Class
 *
 * This class is responsible for registering the blocks for the plugin.
 */
class Register_Blocks {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	/**
	 * Register the blocks
	 *
	 * @return void
	 */
	public function register_blocks() {
		if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
			wp_register_block_types_from_metadata_collection( Plugin_Paths::plugin_path() . 'build/blocks', Plugin_Paths::plugin_path() . 'build/blocks-manifest.php' );
			return;
		}

		if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
			wp_register_block_metadata_collection( Plugin_Paths::plugin_path() . 'build/blocks', Plugin_Paths::plugin_path() . 'build/blocks-manifest.php' );
		}

		$manifest_data = include Plugin_Paths::plugin_path() . 'build/blocks-manifest.php';
		foreach ( array_keys( $manifest_data ) as $block_type ) {
			register_block_type( Plugin_Paths::plugin_path() . "build/blocks/{$block_type}" );
		}
	}
}
