<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'outsourceo_navbar_layout1' );

/**
 * Navbar Shortcode
 */

function outsourceo_navbar_layout1( $shortcode ) {
	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Navbar 13', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_navbar_links', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_dark_style', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_align', 'template', 'outsourceo_layout1' );

	$shortcode->add_dependecy( 'outsourceo_label', 'outsourceo_type_link', ['phone', 'email','custom', 'text'] );
	$shortcode->add_dependecy( 'outsourceo_phone', 'outsourceo_type_link', 'phone' );
	$shortcode->add_dependecy( 'outsourceo_email', 'outsourceo_type_link', 'email' );
	$shortcode->add_dependecy( 'outsourceo_add_icon', 'outsourceo_type_link', ['phone','email'] );
	$shortcode->add_dependecy( 'outsourceo_type_icon', 'outsourceo_add_icon', 'true' );
	$shortcode->add_dependecy( 'outsourceo_custom_link', 'outsourceo_type_link', 'custom' );



	$shortcode->add_params( [
		'outsourceo_dark_style'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark style for link?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_navbar_links'  => [
			'type'    => 'group',
			'heading' => esc_html__( 'Navigation Bar links', 'outsourceo' ),
			'params'  => [
				'outsourceo_type_link'   => [
					'type'    => 'select',
					'heading' => esc_html__( 'Type of link', 'outsourceo' ),
					'options' => [
						'phone'     => esc_html__( 'Phone', 'outsourceo' ),
						'email'     => esc_html__( 'Email', 'outsourceo' ),
						'custom'    => esc_html__( 'Custom link', 'outsourceo' ),
						'text'      => esc_html__( 'Just text', 'outsourceo' ),
						'searchbox' => esc_html__( 'Searchbox', 'outsourceo' ),
						'languague' => esc_html__( 'Languague picker', 'outsourceo' ),
					],
				],
				'outsourceo_add_icon'    => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Add icon before label?', 'outsourceo' ),
					'grid'    => 6,
					'default' => '',
				],
				'outsourceo_type_icon'   => [
					'type'    => 'select',
					'heading' => esc_html__( 'Type of icon', 'outsourceo' ),
					'options' => [
						''         => esc_html__( 'Solid', 'outsourceo' ),
						'-outline' => esc_html__( 'Outline', 'outsourceo' ),
					],
				],
				'outsourceo_label'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Label', 'outsourceo' ),
				],
				'outsourceo_phone'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'outsourceo' ),
				],
				'outsourceo_email'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'outsourceo' ),
				],
				'outsourceo_custom_link' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Link', 'outsourceo' ),
				],
			],
		],
		'outsourceo_align'         => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align', 'outsourceo' ),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	] );
}