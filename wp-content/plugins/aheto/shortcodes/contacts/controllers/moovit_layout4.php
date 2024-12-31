<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'moovit_contacts_layout4' );


/**
 * Contacts
 */

function moovit_contacts_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'moovit_layout4', [
		'title' => esc_html__( 'Contacts 13', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_light_version', 'template', [ 'moovit_layout4' ] );
	$shortcode->add_dependecy( 'moovit_contacts_group', 'template', [ 'moovit_layout4' ] );

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
}
