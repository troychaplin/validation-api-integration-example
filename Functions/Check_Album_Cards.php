<?php
/**
 * Block Checks Integration
 *
 * This class integrates with the Block Accessibility Checks plugin to register accessibility checks for custom blocks.
 *
 * @package Ba11y_Checks_Example
 */

namespace Ba11y_Checks_Example;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Checks Integration Class
 *
 * This class integrates with the Block Accessibility Checks plugin to register accessibility checks for custom blocks.
 */
class Check_Album_Cards {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'ba11yc_ready', array( $this, 'register_checks' ) );
	}

	/**
	 * Register all checks for this plugin
	 *
	 * @return void
	 */
	public function register_checks(): void {
		$this->register_album_card_checks();
	}

	/**
	 * Register checks for album card block
	 *
	 * @return void
	 */
	private function register_album_card_checks(): void {
		ba11yc_register_block_check(
			'ba11y-checks-example/album-card',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'check_album_heading_text',
				'error_msg'    => __( 'A title is required for each album card.', 'ba11y-checks-example' ),
				'warning_msg'  => __( 'Consider adding an album title for better accessibility.', 'ba11y-checks-example' ),
				'description'  => __( 'Set the requirements for the album title attribute', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'category'     => 'accessibility',
			)
		);

		ba11yc_register_block_check(
			'ba11y-checks-example/album-card',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'check_album_release_date',
				'error_msg'    => __( 'A release date is required for each album card.', 'ba11y-checks-example' ),
				'warning_msg'  => __( 'Consider adding an album release date for better user experience.', 'ba11y-checks-example' ),
				'description'  => __( 'Set the requirements for the album release date attribute', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'category'     => 'validation',
			)
		);

		ba11yc_register_block_check(
			'ba11y-checks-example/album-card',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'check_album_source_link',
				'error_msg'    => __( 'A link is required for each album card.', 'ba11y-checks-example' ),
				'warning_msg'  => __( 'Consider adding a link for better credibility.', 'ba11y-checks-example' ),
				'description'  => __( 'Set the requirements for the album link attribute', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'category'     => 'validation',
			)
		);

		ba11yc_register_block_check(
			'ba11y-checks-example/album-card',
			array(
				'namespace'    => 'ba11y-checks-example',
				'name'         => 'check_album_innerblock_count',
				'error_msg'    => __( 'One paragraph is required for each album card to a maximum of two paragraphs. One button group is allowed per album card.', 'ba11y-checks-example' ),
				'warning_msg'  => __( 'Consider adding a paragraph for better user experience. One button group is allowed per album card.', 'ba11y-checks-example' ),
				'description'  => __( 'Ensure each album card has at least one paragraph, with a maximum of two paragraphs. Button groups are limited to one per album card.', 'ba11y-checks-example' ),
				'level'        => 'error',
				'configurable' => true,
				'category'     => 'validation',
			)
		);
	}
}
