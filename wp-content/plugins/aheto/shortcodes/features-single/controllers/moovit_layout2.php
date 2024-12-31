<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'moovit_features_single_layout2' );

/**
 * Features Single
 */

function moovit_features_single_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Features Single 35', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_title_tag', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_align_mobile', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_use_dot', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_dot_color', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );


	$shortcode->add_params( [
		'moovit_use_dot'   => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot in the end title?', 'moovit' ),
			'grid'    => 12,
		],
		'moovit_dot_color' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Color for dot', 'moovit' ),
			'options' => [
				'primary' => esc_html__( 'Primary', 'moovit' ),
				'dark'    => esc_html__( 'Dark', 'moovit' ),
				'white'   => esc_html__( 'White', 'moovit' ),
			],
			'default' => 'primary',
		],
		'moovit_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for mobile', 'moovit' ),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],
        'moovit_title_tag' => [
            'type'    => 'select',
            'heading' => esc_html__('Title tag', 'moovit'),
            'options' => [
                'h1'  => 'h1',
                'h2'  => 'h2',
                'h3'  => 'h3',
                'h4'  => 'h4',
                'h5'  => 'h5',
                'h6'  => 'h6',
                'p'   => 'p',
                'div' => 'div',
            ],
            'default' => 'h5',
            'grid'    => 1,
        ],
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', ['moovit_layout2']]
	]);

}