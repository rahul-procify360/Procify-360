<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'hryzantema_contacts_layout2');

/**
 * Contacts Shortcode
 */

function hryzantema_contacts_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'Contacts 7', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );

	aheto_demos_add_dependency(['use_heading','use_content', 't_heading', 't_content' ], ['hryzantema_layout2'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_light_version', 'template', ['hryzantema_layout2'] );
	$shortcode->add_dependecy( 'hryzantema_contacts_group', 'template', ['hryzantema_layout2' ] );

	$shortcode->add_params([
		'hryzantema_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light version?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Contacts', 'hryzantema' ),
			'params'  => [
				'hryzantema_heading_tag' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Element tag for Heading', 'hryzantema' ),
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
				'hryzantema_heading' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading', 'hryzantema' ),
				],
				'hryzantema_address' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Address', 'hryzantema' ),
				],
				'hryzantema_phone'   => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'hryzantema' ),
				],

				'hryzantema_email' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'hryzantema' ),
				],
			]
		],

	]);
}
