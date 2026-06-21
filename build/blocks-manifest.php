<?php
// This file is generated. Do not modify it manually.
return array(
	'album-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'validation-api-example/album-card',
		'version' => '1.0.0',
		'title' => 'Album Card',
		'description' => 'An example block for displaying album cards with accessibility checks in place.',
		'category' => 'text',
		'icon' => 'universal-access',
		'parent' => array(
			'validation-api-example/card-grid'
		),
		'usesContext' => array(
			'validation-api-example/card-grid-radius'
		),
		'supports' => array(
			'html' => false
		),
		'attributes' => array(
			'headingText' => array(
				'type' => 'string',
				'default' => ''
			),
			'headingLevel' => array(
				'type' => 'number',
				'default' => 2
			),
			'sourceUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'releaseDate' => array(
				'type' => 'string',
				'default' => ''
			),
			'description' => array(
				'type' => 'string',
				'default' => ''
			),
			'radius' => array(
				'type' => 'number',
				'default' => 6
			)
		),
		'textdomain' => 'validation-api-example',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'card-grid' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'validation-api-example/card-grid',
		'title' => 'Card Grid',
		'description' => 'A grid of cards with customizable columns, gap, and aspect ratio.',
		'version' => '0.1.0',
		'category' => 'text',
		'providesContext' => array(
			'validation-api-example/card-grid-radius' => 'radius'
		),
		'supports' => array(
			'align' => array(
				'full',
				'wide'
			),
			'alignWide' => true,
			'html' => false
		),
		'attributes' => array(
			'columns' => array(
				'type' => 'number',
				'default' => 2
			),
			'gap' => array(
				'type' => 'number',
				'default' => 25
			),
			'radius' => array(
				'type' => 'number',
				'default' => 6
			)
		),
		'textdomain' => 'validation-api-example',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'example' => array(
			'attributes' => array(
				'columns' => 2,
				'gap' => 10,
				'radius' => 6
			),
			'innerBlocks' => array(
				array(
					'name' => 'validation-api-example/album-card',
					'attributes' => array(
						'headingText' => 'Album Title',
						'headingLevel' => 2,
						'releaseDate' => '2025-01-01',
						'description' => 'This is a description of the album.',
						'radius' => 4
					)
				),
				array(
					'name' => 'validation-api-example/album-card',
					'attributes' => array(
						'headingText' => 'Album Title',
						'headingLevel' => 2,
						'releaseDate' => '2025-01-01',
						'description' => 'This is a description of the album.',
						'radius' => 4
					)
				),
				array(
					'name' => 'validation-api-example/album-card',
					'attributes' => array(
						'headingText' => 'Album Title',
						'headingLevel' => 2,
						'releaseDate' => '2025-01-01',
						'description' => 'This is a description of the album.',
						'radius' => 4
					)
				),
				array(
					'name' => 'validation-api-example/album-card',
					'attributes' => array(
						'headingText' => 'Album Title',
						'headingLevel' => 2,
						'releaseDate' => '2025-01-01',
						'description' => 'This is a description of the album.',
						'radius' => 4
					)
				)
			)
		)
	)
);
