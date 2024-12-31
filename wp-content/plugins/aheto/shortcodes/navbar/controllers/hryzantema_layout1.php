<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'hryzantema_navbar_layout1');

/**
 * Navbar Shortcode
 */

function hryzantema_navbar_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Navbar 7', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_center_links', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_align_items', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_dark_style', 'template', 'hryzantema_layout1' );

	$shortcode->add_dependecy( 'hryzantema_label', 'hryzantema_type_link', ['hryzantema_custom', 'hryzantema_phone', 'hryzantema_email', 'hryzantema_text'] );
	$shortcode->add_dependecy( 'hryzantema_phone', 'hryzantema_type_link', 'hryzantema_phone' );
	$shortcode->add_dependecy( 'hryzantema_email', 'hryzantema_type_link', 'hryzantema_email' );
	$shortcode->add_dependecy( 'hryzantema_add_icon', 'hryzantema_type_link', ['hryzantema_phone','hryzantema_email'] );
	$shortcode->add_dependecy( 'hryzantema_type_icon', 'hryzantema_add_icon', 'true' );

	$shortcode->add_dependecy('hryzantema_icon_use_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_icon_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_icon_typo', 'hryzantema_icon_use_typo', 'true');

	$shortcode->add_params( [
		'hryzantema_center_links' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Nvabar links', 'hryzantema' ),
			'params'  => [
				'hryzantema_type_link'      => [
					'type'    => 'select',
					'heading' => esc_html__('Type of link', 'hryzantema'),
					'options' => [
						'hryzantema_phone' => esc_html__('Phone', 'hryzantema'),
						'hryzantema_email'   => esc_html__('Email', 'hryzantema'),
						'hryzantema_text'   => esc_html__('Just text', 'hryzantema'),
						'hryzantema_searchbox'   => esc_html__('Searchbox', 'hryzantema'),
					],
				],
				'hryzantema_add_icon'        => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Add icon before label?', 'hryzantema' ),
					'grid'    => 6,
					'default' => '',
				],
				'hryzantema_type_icon'      => [
					'type'    => 'select',
					'heading' => esc_html__('Type of icon', 'hryzantema'),
					'options' => [
						'' => esc_html__('Solid', 'hryzantema'),
						'-outline'   => esc_html__('Outline', 'hryzantema'),
					],
				],
				'hryzantema_label'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Label', 'hryzantema' ),
				],
				'hryzantema_phone'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'hryzantema' ),
				],
				'hryzantema_email'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'hryzantema' ),
				],

			],
		],
		'hryzantema_align_items'      => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'hryzantema'),
			'options' => [
				'flex-start' => esc_html__('Left', 'hryzantema'),
				'center'   => esc_html__('Center', 'hryzantema'),
				'flex-end'   => esc_html__('Right', 'hryzantema'),
			],
		],
		'hryzantema_dark_style' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark style?', 'hryzantema' ),
			'grid'    => 6,
		],
		'hryzantema_icon_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for icon?', 'hryzantema'),
			'grid'    => 3,
		],
		'hryzantema_icon_typo'     => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Icon Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--item i',
		],
	] );
}

function hryzantema_navbar_layout1_dynamic_css( $css, $shortcode ) {
	if ( isset( $shortcode->atts['hryzantema_icon_use_typo'] ) && $shortcode->atts['hryzantema_icon_use_typo'] && isset( $shortcode->atts['hryzantema_icon_typo'] ) && ! empty( $shortcode->atts['hryzantema_icon_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-navbar--item i'], $shortcode->parse_typography( $shortcode->atts['hryzantema_icon_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'hryzantema_navbar_layout1_dynamic_css', 10, 2 );
