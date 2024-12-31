<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'azyn_media_layout1' );


/**
 * media
 */

function azyn_media_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'azyn_layout1', [
		'title' => esc_html__( 'Azyn Masonry', 'azyn' ),
		'image' => $preview_dir . 'azyn_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['image_popup'], ['azyn_layout1'], $shortcode );

	$shortcode->add_dependecy( 'azyn_images', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_spaces', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_tablet_spaces', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_mobile_spaces', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_overlay_bg', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_lines', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_use_text_typo', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_text_typo', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_text_typo', 'azyn_use_text_typo', 'true' );


	$shortcode->add_params( [
		'azyn_images'     => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Add images', 'azyn' ),
		],
		'azyn_overlay_bg' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Overlay background color', 'azyn' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-media__overlay' => 'background: {{VALUE}}' ],
		],
		'azyn_lines' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Lines color for caption on hover', 'azyn' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-media__overlay span' => 'border-color: {{VALUE}}' ],
		],
		'azyn_use_text_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for caption?', 'funero'),
			'grid'    => 3,
		],
		'azyn_text_typo'       => [
			'type'     => 'typography',
			'group'    => 'Caption Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-media__overlay span',
		],
		'azyn_spaces' => [
			'type'    => 'slider',
			'heading' => esc_html__('Spaces for desktop version', 'azyn'),
			'grid'    => 12,
			'size_units' => [ 'px' ],
			'range'   => [
				'px' => [
					'min'  => 0,
					'max'  => 300,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-media__wrapper' => '--spaces: {{SIZE}}{{UNIT}}'
			],
		],
		'azyn_tablet_spaces' => [
			'type'    => 'slider',
			'heading' => esc_html__('Spaces for tablet version', 'azyn'),
			'grid'    => 12,
			'size_units' => [ 'px' ],
			'range'   => [
				'px' => [
					'min'  => 0,
					'max'  => 300,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-media__wrapper' => '--spaces-tab: {{SIZE}}{{UNIT}}'
			],
		],
		'azyn_mobile_spaces' => [
			'type'    => 'slider',
			'heading' => esc_html__('Spaces for mobile version', 'azyn'),
			'grid'    => 12,
			'size_units' => [ 'px' ],
			'range'   => [
				'px' => [
					'min'  => 0,
					'max'  => 300,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-media__wrapper' => '--spaces-mob: {{SIZE}}{{UNIT}}'
			],
		],
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Azyn Image size', 'azyn' ),
		'prefix'     => 'azyn_',
		'dependency' => ['template', [ 'azyn_layout1'] ]
	]);

}
