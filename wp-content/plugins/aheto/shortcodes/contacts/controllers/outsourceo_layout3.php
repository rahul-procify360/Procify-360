<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'outsourceo_contacts_layout3' );

/**
 * Contacts Shortcode
 */

function outsourceo_contacts_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'outsourceo_layout3', [
		'title' => esc_html__( 'Contacts 17', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout3.jpg',
	] );


	aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_content', 't_content', 's_heading'], [ 'outsourceo_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_light_version', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_contacts_group', 'template', 'outsourceo_layout3' );


	$shortcode->add_params( [

		'outsourceo_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light version?', 'outsourceo' ),
			'grid'    => 3,
		],

		'outsourceo_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Outsourceo Contacts', 'outsourceo' ),
			'params'  => [
				'outsourceo_heading' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading', 'outsourceo' ),
				],
				'outsourceo_address' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Address', 'outsourceo' ),
				],
				'outsourceo_phone'   => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'outsourceo' ),
				],

				'outsourceo_email' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'outsourceo' ),
				],
			]
		],

	] );
}