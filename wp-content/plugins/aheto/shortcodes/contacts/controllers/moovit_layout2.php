<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'moovit_contacts_layout2' );



/**
 * Contacts
 */

function moovit_contacts_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Contacts 11', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_heading_tag', 'template', 'moovit_layout2' );

	aheto_demos_add_dependency( ['use_heading', 't_heading', 'address', 'email', 'phone', 's_heading'], [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_params( [
		'moovit_heading_tag'   => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Heading', 'moovit' ),
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

	] );

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'   => true,
		'add_label'  => esc_html__( 'Add address icon?', 'moovit' ),
		'prefix'     => 'moovit_address_',
		'exclude'    => [ 'align' ],
		'dependency' => [ 'template', 'moovit_layout2' ]
	] );

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'   => true,
		'add_label'  => esc_html__( 'Add email icon?', 'moovit' ),
		'prefix'     => 'moovit_email_',
		'exclude'    => [ 'align' ],
		'dependency' => [ 'template', 'moovit_layout2' ]
	] );

	\Aheto\Params::add_icon_params( $shortcode, [
		'add_icon'   => true,
		'add_label'  => esc_html__( 'Add phone icon?', 'moovit' ),
		'prefix'     => 'moovit_phone_',
		'exclude'    => [ 'align' ],
		'dependency' => [ 'template', 'moovit_layout2' ]
	] );

}