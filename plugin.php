<?php
/**
 * Plugin Name:       Multi-Block Check Example
 * Description:       An example of an external multi-block with accessibility & validation checks
 * Version:           2.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Troy Chaplin
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ba11y-checks-example
 *
 * @package Ba11y_Checks_Example
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include Composer's autoload file.
if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
} else {
	wp_trigger_error( 'BA11Y Multi-Block Example Plugin: Composer autoload file not found. Please run `composer install`.', E_USER_ERROR );
	return;
}

// Instantiate the classes.
$ba11y_checks_example_classes = array(
	\Ba11y_Checks_Example\Plugin_Paths::class,
	\Ba11y_Checks_Example\Register_Blocks::class,
	\Ba11y_Checks_Example\Enqueues::class,
	\Ba11y_Checks_Example\Post_Type::class,
	\Ba11y_Checks_Example\Check_Album_Cards::class,
	\Ba11y_Checks_Example\Check_Content_Editor::class,
);

foreach ( $ba11y_checks_example_classes as $ba11y_checks_example_class ) {
	new $ba11y_checks_example_class();
}
