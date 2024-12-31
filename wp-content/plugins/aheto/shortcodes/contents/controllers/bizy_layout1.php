<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'bizy_contents_layout1' );


/**
 * Contents
 */

function bizy_contents_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'bizy_layout1', [
		'title' => esc_html__( 'Bizy Creative', 'bizy' ),
		'image' => $preview_dir . 'bizy_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'bizy_image', 'template', 'bizy_layout1' );
	$shortcode->add_dependecy( 'bizy_item_image', 'template', 'bizy_layout1' );
	$shortcode->add_dependecy( 'bizy_creative_items', 'template', 'bizy_layout1' );
	$shortcode->add_dependecy( 'bizy_breakpoint', 'template', 'bizy_layout1' );


	$shortcode->add_params( [
		'bizy_image'      => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Main Image', 'bizy' ),
		],
		'bizy_item_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Point Image', 'bizy' ),
		],
		'bizy_creative_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Points', 'bizy' ),
			'params'  => [
				'bizy_item_location'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Location', 'bizy' ),
				],
				'bizy_item_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Text', 'bizy' ),
				],
				'bizy_top' => [
					'type'    => 'slider',
					'heading' => esc_html__('Top position', 'bizy'),
					'grid'    => 12,
					'size_units' => [ '%' ],
					'range'   => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
				],
				'bizy_left' => [
					'type'    => 'slider',
					'heading' => esc_html__('Left position', 'bizy'),
					'grid'    => 12,
					'size_units' => [ '%' ],
					'range'   => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
				],
			]
		],
		'bizy_breakpoint' => [
			'type'    => 'slider',
			'heading' => esc_html__('Breakpoint for mobile version', 'bizy'),
			'grid'    => 12,
			'size_units' => [ 'px' ],
			'range'   => [
				'px' => [
					'min'  => 0,
					'max'  => 2000,
					'step' => 1,
				],
			],
		],

	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Bizy Image size', 'aheto' ),
		'prefix'     => 'bizy_',
		'dependency' => ['template', [ 'bizy_layout1'] ]
	]);


}


