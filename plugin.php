<?php
/**
 * Plugin Name:       Validation API Integration Example
 * Description:       An example integration plugin demonstrating validation checks with the Validation API
 * Version:           1.4.21
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Troy Chaplin
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       validation-api-example
 *
 * @package Validation_API_Example
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include Composer's autoload file.
if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
} else {
	wp_trigger_error( 'Validation_API_Example', 'Composer autoload file not found. Please run `composer install`.', E_USER_ERROR );
	return;
}

// Instantiate the classes.
$validation_api_example_classes = array(
	\Validation_API_Example\Plugin_Paths::class,
	\Validation_API_Example\Register_Blocks::class,
	\Validation_API_Example\Enqueues::class,
	\Validation_API_Example\Post_Type::class,
	\Validation_API_Example\Check_Album_Cards::class,
	\Validation_API_Example\Check_Content_Editor::class,
	\Validation_API_Example\Check_Band_Meta::class,
);

foreach ( $validation_api_example_classes as $validation_api_example_class ) {
	new $validation_api_example_class();
}
