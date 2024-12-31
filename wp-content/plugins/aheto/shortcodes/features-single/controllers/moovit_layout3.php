<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'moovit_features_single_layout3' );

/**
 * Features Single
 */

function moovit_features_single_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'moovit_layout3', [
		'title' => esc_html__( 'Features Single 36', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout3.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading','use_heading', 't_heading'], [ 'moovit_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_heading_tag', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_add_url', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_heading_tag', 'moovit_add_url', '' );
	$shortcode->add_dependecy( 'moovit_url', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_url', 'moovit_add_url', 'true' );

	$shortcode->add_params( [
        'moovit_add_url' => [
            'type'    => 'switch',
            'heading' => esc_html__('Add link for heading?', 'funero'),
            'grid'    => 3,
        ],
        'moovit_url'   => [
            'type'    => 'text',
            'heading' => esc_html__('Heading URL', 'famulus'),
        ],
		'moovit_heading_tag'    => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for title', 'moovit' ),
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
			'default'    => 'p',
			'grid'    => 6,
		],

	] );


	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'   => true,
		'add_label'  => esc_html__( 'Add icon?', 'moovit' ),
		'prefix'     => 'moovit_',
		'exclude'    => [ 'align' ],
		'dependency' => [ 'template', 'moovit_layout3' ]
	] );
}

