<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'moovit_contacts_layout1' );



/**
 * Contacts
 */

function moovit_contacts_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Contacts 10', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'moovit_text', 'template', 'moovit_layout1' );


	aheto_demos_add_dependency( ['s_heading', 'use_heading', 't_heading', 'use_content', 't_content'], [ 'moovit_layout1'], $shortcode );


	$shortcode->add_params( [
		'moovit_text'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Text', 'moovit' ),
			'description' => esc_html__( 'Add some text for contacts', 'moovit' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for contacts', 'moovit' ),
		],

	] );
}