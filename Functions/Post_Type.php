<?php
/**
 * Post Type
 *
 * This class is responsible for enqueuing the plugin's assets.
 *
 * @package Ba11y_Checks_Example
 */

namespace Ba11y_Checks_Example;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure WordPress functions are available.
if ( ! function_exists( 'add_action' ) ) {
	return;
}

/**
 * Post Type Class
 *
 * This class is responsible for enqueuing the plugin's assets.
 */
class Post_Type {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_band_post_type' ) );
		add_action( 'init', array( $this, 'register_genre_taxonomy' ) );
		add_action( 'init', array( $this, 'register_band_meta' ) );
		add_action( 'rest_api_init', array( $this, 'register_band_meta' ) );
	}

	/**
	 * Registers the custom post type for FAQs.
	 *
	 * This method defines and registers a custom post type specifically for
	 * Frequently Asked Questions (FAQs). It sets up the necessary labels,
	 * arguments, and configurations to integrate the post type into WordPress.
	 *
	 * @return void
	 */
	public function register_band_post_type() {
		$labels = array(
			'name'                  => 'Bands',
			'singular_name'         => 'Band',
			'menu_name'             => 'Bands',
			'name_admin_bar'        => 'Bands',
			'archives'              => 'Band Archives',
			'attributes'            => 'Band Attributes',
			'parent_item_colon'     => 'Parent File:',
			'all_items'             => 'All Bands',
			'add_new_item'          => 'Add New Band',
			'add_new'               => 'Add New',
			'new_item'              => 'New Band',
			'edit_item'             => 'Edit Band',
			'update_item'           => 'Update Band',
			'view_item'             => 'View Band',
			'view_items'            => 'View Bands',
			'search_items'          => 'Search Bands',
			'not_found'             => 'Not found',
			'not_found_in_trash'    => 'Not found in Trash',
			'featured_image'        => 'Featured Image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'insert_into_item'      => 'Insert into band',
			'uploaded_to_this_item' => 'Uploaded to this band',
			'items_list'            => 'Band list',
			'items_list_navigation' => 'Band list navigation',
			'filter_items_list'     => 'Filter Band list',
		);

		$rewrite = array(
			'slug'       => 'band',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'Band',
			'description'         => 'Band custom post type',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
			'taxonomies'          => array( 'band_genre' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-format-audio',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
		);

		register_post_type( 'band', $args );
	}

	/**
	 * Registers the custom taxonomy for the FAQ post type.
	 *
	 * This function is responsible for creating and registering a taxonomy
	 * specifically for the FAQ custom post type. It defines the taxonomy's
	 * labels, settings, and associations with the FAQ post type.
	 *
	 * @return void
	 */
	public function register_genre_taxonomy() {
		$labels = array(
			'name'                       => 'Genres',
			'singular_name'              => 'Genre',
			'menu_name'                  => 'Genres',
			'all_items'                  => 'All Genres',
			'parent_item'                => 'Parent Genre',
			'parent_item_colon'          => 'Parent Genre:',
			'new_item_name'              => 'New Genre Name',
			'add_new_item'               => 'Add New Genre',
			'edit_item'                  => 'Edit Genre',
			'update_item'                => 'Update Genre',
			'view_item'                  => 'View Genre',
			'separate_items_with_commas' => 'Separate genres with commas',
			'add_or_remove_items'        => 'Add or remove genres',
			'choose_from_most_used'      => 'Choose from the most used',
			'popular_items'              => 'Popular genres',
			'search_items'               => 'Search Genres',
			'not_found'                  => 'Not Found',
			'no_terms'                   => 'No genres',
			'items_list'                 => 'Genres list',
			'items_list_navigation'      => 'Genres list navigation',
		);

		$rewrite = array(
			'slug'         => 'genre',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'rewrite'           => $rewrite,
			'show_in_rest'      => true,
		);
		register_taxonomy( 'band_genre', array( 'band' ), $args );
	}

	/**
	 * Registers meta fields for the band post type.
	 *
	 * This method is responsible for registering the meta fields for the band post type.
	 * It registers the meta fields for the band post type and sets the necessary settings.
	 *
	 * @return void
	 */
	public function register_band_meta() {
		// Check if Validator class is available.
		$validator_class     = '\BlockAccessibility\Meta\Validator';
		$validator_available = class_exists( $validator_class );

		register_meta(
			'post',
			'band_origin',
			array(
				'single'            => true,
				'type'              => 'string',
				'show_in_rest'      => true,
				'object_subtype'    => 'band',
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => $validator_available
					? call_user_func(
						array( $validator_class, 'required' ),
						'band',
						'band_origin',
						array(
							'namespace'    => 'ba11y-checks-example',
							'error_msg'    => __( 'City of Origin is required.', 'ba11y-checks-example' ),
							'warning_msg'  => __( 'City of Origin is recommended.', 'ba11y-checks-example' ),
							'description'  => __( 'The city where the band originated', 'ba11y-checks-example' ),
							'level'        => 'error',
							'configurable' => true,
						)
					)
					: null,
			)
		);
		register_meta(
			'post',
			'band_record_label',
			array(
				'single'            => true,
				'type'              => 'string',
				'show_in_rest'      => true,
				'object_subtype'    => 'band',
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => $validator_available
					? call_user_func(
						array( $validator_class, 'required' ),
						'band',
						'band_record_label',
						array(
							'namespace'    => 'ba11y-checks-example',
							'error_msg'    => __( 'Record Label is required.', 'ba11y-checks-example' ),
							'warning_msg'  => __( 'Record Label is recommended.', 'ba11y-checks-example' ),
							'description'  => __( 'The record label of the band', 'ba11y-checks-example' ),
							'level'        => 'error',
							'configurable' => true,
						)
					)
					: null,
			)
		);
		register_meta(
			'post',
			'band_first_album',
			array(
				'single'            => true,
				'type'              => 'string',
				'show_in_rest'      => true,
				'object_subtype'    => 'band',
				'sanitize_callback' => 'sanitize_text_field',
				'validate_callback' => $validator_available
					? call_user_func(
						array( $validator_class, 'required' ),
						'band',
						'band_first_album',
						array(
							'namespace'    => 'ba11y-checks-example',
							'error_msg'    => __( 'First Album is required.', 'ba11y-checks-example' ),
							'warning_msg'  => __( 'First Album is recommended.', 'ba11y-checks-example' ),
							'description'  => __( 'The first album of the band', 'ba11y-checks-example' ),
							'level'        => 'error',
							'configurable' => true,
						)
					)
					: null,
			)
		);
	}
}
