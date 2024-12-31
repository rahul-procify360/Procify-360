<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'bizy_media_layout3' );


/**
 * media
 */

function bizy_media_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'bizy_layout3', [
		'title' => esc_html__( 'Bizy Gradient', 'bizy' ),
		'image' => $preview_dir . 'bizy_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'bizy_creative_items', 'template', 'bizy_layout3' );
	$shortcode->add_dependecy( 'bizy_breakpoint', 'template', 'bizy_layout3' );


	$shortcode->add_params( [
	
		'bizy_creative_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Points', 'bizy' ),
			'params'  => [
				'bizy_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Point Image', 'bizy' ),
				],
				'bizy_top_item' => [
					'type'    => 'slider',
					'heading' => esc_html__('Top position', 'bizy'),
					'grid'    => 12,
					'size_units' => [ 'px', '%' ],
					'range'   => [
						'px' => [
							'min'  => 0,
							'max'  => 5000,
							'step' => 1,
						],
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}.aheto-media__wrapper-point' => 'top: {{SIZE}}{{UNIT}} !important'
					],
				],
				'bizy_left_item' => [
					'type'    => 'slider',
					'heading' => esc_html__('Left position', 'bizy'),
					'grid'    => 12,
					'size_units' => [ 'px', '%' ],
					'range'   => [
						'px' => [
							'min'  => 0,
							'max'  => 5000,
							'step' => 1,
						],
						'%' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.aheto-media__wrapper-point' => 'left: {{SIZE}}{{UNIT}} !important'],
				],
				'bizy_z_index' => [
					'type'    => 'number',
					'heading' => esc_html__('Z-Index position', 'bizy'),
					'grid'    => 12,
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 10,
					'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.aheto-media__wrapper-point' => 'z-index: {{SIZE}} !important'],	
				],
				'bizy_depth' => [
					'type'    => 'number',
					'heading' => esc_html__('Depth value (0 - static position, 5 - max)', 'bizy'),
					'grid'    => 12,
					'min' => 0,
					'max' => 5,
					'step' => 1,
					'default' => 0.4,	
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
		'group'      => esc_html__( 'Bizy Image size', 'bizy' ),
		'prefix'     => 'bizy_',
		'dependency' => ['template', [ 'bizy_layout3'] ]
	]);


}


