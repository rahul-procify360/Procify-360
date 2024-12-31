<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'moovit_contacts_layout3' );



/**
 * Contacts
 */

function moovit_contacts_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'moovit_layout3', [
		'title' => esc_html__( 'Contacts 12', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout3.jpg',
	] );
	
	aheto_demos_add_dependency(['use_heading', 'use_content', 't_heading', 't_content'], ['moovit_layout3'], $shortcode);

	$shortcode->add_dependecy( 'moovit_light_version', 'template', ['moovit_layout3'] );
	$shortcode->add_dependecy( 'moovit_contacts_group', 'template', ['moovit_layout3'] );

	$shortcode->add_dependecy('moovit_use_arrow_typo', 'template', 'moovit_layout3');
	$shortcode->add_dependecy('moovit_arrow_typo', 'template', 'moovit_layout3');
	$shortcode->add_dependecy('moovit_arrow_typo', 'moovit_use_arrow_typo', 'true');


	$shortcode->add_params( [
		'moovit_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light version?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Moovit Contacts', 'moovit' ),
			'params'  => [
				'moovit_heading' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading', 'moovit' ),
				],
				'moovit_address' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Address', 'moovit' ),
				],
				'moovit_phone'   => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'moovit' ),
				],

				'moovit_email' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'moovit' ),
				],
			]
		],
	] );


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_contacts_',
		'include'        => [ 'arrows', 'arrows_size', 'arrows_color', 'loop', 'autoplay', 'speed', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'moovit_layout3' ] ]
	] );
}