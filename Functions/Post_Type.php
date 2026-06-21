<?php
/**
 * Post Type
 *
 * This class is responsible for enqueuing the plugin's assets.
 *
 * @package Validation_API_Example
 */

namespace Validation_API_Example;

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
	}

	/**
	 * Registers the Band custom post type.
	 *
	 * @return void
	 */
	public function register_band_post_type() {
		$labels = array(
			'name'                  => __( 'Bands', 'validation-api-example' ),
			'singular_name'         => __( 'Band', 'validation-api-example' ),
			'menu_name'             => __( 'Bands', 'validation-api-example' ),
			'name_admin_bar'        => __( 'Bands', 'validation-api-example' ),
			'archives'              => __( 'Band Archives', 'validation-api-example' ),
			'attributes'            => __( 'Band Attributes', 'validation-api-example' ),
			'parent_item_colon'     => __( 'Parent Band:', 'validation-api-example' ),
			'all_items'             => __( 'All Bands', 'validation-api-example' ),
			'add_new_item'          => __( 'Add New Band', 'validation-api-example' ),
			'add_new'               => __( 'Add New', 'validation-api-example' ),
			'new_item'              => __( 'New Band', 'validation-api-example' ),
			'edit_item'             => __( 'Edit Band', 'validation-api-example' ),
			'update_item'           => __( 'Update Band', 'validation-api-example' ),
			'view_item'             => __( 'View Band', 'validation-api-example' ),
			'view_items'            => __( 'View Bands', 'validation-api-example' ),
			'search_items'          => __( 'Search Bands', 'validation-api-example' ),
			'not_found'             => __( 'Not found', 'validation-api-example' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'validation-api-example' ),
			'featured_image'        => __( 'Featured Image', 'validation-api-example' ),
			'set_featured_image'    => __( 'Set featured image', 'validation-api-example' ),
			'remove_featured_image' => __( 'Remove featured image', 'validation-api-example' ),
			'use_featured_image'    => __( 'Use as featured image', 'validation-api-example' ),
			'insert_into_item'      => __( 'Insert into band', 'validation-api-example' ),
			'uploaded_to_this_item' => __( 'Uploaded to this band', 'validation-api-example' ),
			'items_list'            => __( 'Band list', 'validation-api-example' ),
			'items_list_navigation' => __( 'Band list navigation', 'validation-api-example' ),
			'filter_items_list'     => __( 'Filter Band list', 'validation-api-example' ),
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
	 * Registers the Genre taxonomy for the Band post type.
	 *
	 * @return void
	 */
	public function register_genre_taxonomy() {
		$labels = array(
			'name'                       => __( 'Genres', 'validation-api-example' ),
			'singular_name'              => __( 'Genre', 'validation-api-example' ),
			'menu_name'                  => __( 'Genres', 'validation-api-example' ),
			'all_items'                  => __( 'All Genres', 'validation-api-example' ),
			'parent_item'                => __( 'Parent Genre', 'validation-api-example' ),
			'parent_item_colon'          => __( 'Parent Genre:', 'validation-api-example' ),
			'new_item_name'              => __( 'New Genre Name', 'validation-api-example' ),
			'add_new_item'               => __( 'Add New Genre', 'validation-api-example' ),
			'edit_item'                  => __( 'Edit Genre', 'validation-api-example' ),
			'update_item'                => __( 'Update Genre', 'validation-api-example' ),
			'view_item'                  => __( 'View Genre', 'validation-api-example' ),
			'separate_items_with_commas' => __( 'Separate genres with commas', 'validation-api-example' ),
			'add_or_remove_items'        => __( 'Add or remove genres', 'validation-api-example' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'validation-api-example' ),
			'popular_items'              => __( 'Popular genres', 'validation-api-example' ),
			'search_items'               => __( 'Search Genres', 'validation-api-example' ),
			'not_found'                  => __( 'Not Found', 'validation-api-example' ),
			'no_terms'                   => __( 'No genres', 'validation-api-example' ),
			'items_list'                 => __( 'Genres list', 'validation-api-example' ),
			'items_list_navigation'      => __( 'Genres list navigation', 'validation-api-example' ),
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
	 * @return void
	 */
	public function register_band_meta() {
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
							'namespace'    => 'validation-api-example',
							'error_msg'    => __( 'City of Origin is required.', 'validation-api-example' ),
							'warning_msg'  => __( 'City of Origin is recommended.', 'validation-api-example' ),
							'description'  => __( 'The city where the band originated', 'validation-api-example' ),
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
							'namespace'    => 'validation-api-example',
							'error_msg'    => __( 'Record Label is required.', 'validation-api-example' ),
							'warning_msg'  => __( 'Record Label is recommended.', 'validation-api-example' ),
							'description'  => __( 'The record label of the band', 'validation-api-example' ),
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
							'namespace'    => 'validation-api-example',
							'error_msg'    => __( 'First Album is required.', 'validation-api-example' ),
							'warning_msg'  => __( 'First Album is recommended.', 'validation-api-example' ),
							'description'  => __( 'The first album of the band', 'validation-api-example' ),
							'level'        => 'error',
							'configurable' => true,
						)
					)
					: null,
			)
		);
	}
}
