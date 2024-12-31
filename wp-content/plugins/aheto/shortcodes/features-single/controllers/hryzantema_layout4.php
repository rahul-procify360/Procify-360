<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout4');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout4($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout4', [
		'title' => esc_html__( 'Features Single 22', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout4.jpg',
	] );
	aheto_demos_add_dependency(['s_image','s_heading','use_heading', 's_description','use_description', 't_heading','t_description'], ['hryzantema_layout4'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_heading_tag', 'template', ['hryzantema_layout4'] );
	$shortcode->add_params( [

		'hryzantema_heading_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for heading', 'hryzantema' ),
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
			'grid'    => 5,
		],
		]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons' => true,
		'dependency' => ['template', ['hryzantema_layout4'] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [  'hryzantema_layout4'] ]
	]);
}

