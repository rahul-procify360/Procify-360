<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'outsourceo_contacts_layout2' );

/**
 * Contacts Shortcode
 */

function outsourceo_contacts_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Contacts 16', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_content', 't_content'], [ 'outsourceo_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_contacts_group', 'template', 'outsourceo_layout2' );

	$shortcode->add_params( [
		'outsourceo_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Outsourceo Contacts', 'outsourceo' ),
			'params'  => [
				'outsourceo_heading_tag' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Element tag for Heading', 'outsourceo' ),
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
					'default' => 'h4',
					'grid'    => 5,
				],
				'outsourceo_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading', 'outsourceo' ),
				],
				'outsourceo_address'     => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Address', 'outsourceo' ),
				],
				'outsourceo_phone'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'outsourceo' ),
				],

				'outsourceo_email' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'outsourceo' ),
				],
			]
		]
	] );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'outsourceo_contacts_',
		'include'        => [
			'effect',
			'arrows',
			'pagination',
			'loop',
			'autoplay',
			'speed',
			'slides',
			'simulate_touch'
		],
		'dependency'     => [ 'template', [ 'outsourceo_layout2' ] ]
	] );
}