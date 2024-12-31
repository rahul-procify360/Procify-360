<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'djo_contacts_layout1');

/**
 * Contacts shortcode
 */

function djo_contacts_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Contacts 4', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'djo_dark_version', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_contacts_group', 'template', 'djo_layout1' );

	$shortcode->add_dependecy( 'djo_use_heading', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_use_content', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_heading_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_heading_typo', 'djo_use_heading', 'true' );
	$shortcode->add_dependecy( 'djo_content_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_content_typo', 'djo_use_content', 'true' );


	$shortcode->add_params( [
		'djo_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Djo Contacts', 'djo' ),
			'params'  => [
				'djo_heading' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading', 'djo' ),
				],
				'djo_address' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Address', 'djo' ),
				],
				'djo_phone'   => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'djo' ),
				],

				'djo_email' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'djo' ),
				],
			]
		],
		'djo_dark_version' => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable dark version', 'djo'),
			'grid'    => 3,
		],
		'djo_use_heading' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for heading?', 'djo' ),
			'grid'    => 6,
		],
		'djo_use_content' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for content?', 'djo' ),
			'grid'    => 6,
		],
		'djo_heading_typo' => [
			'type'     => 'typography',
			'group'    => 'Contacts Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contact__title',
		],
		'djo_content_typo' => [
			'type'     => 'typography',
			'group'    => 'Contacts Content Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contact__info a, {{WRAPPER}} .aheto-contact__info p',
		],
	] );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'djo_contacts_',
		'include'        => [ 'arrows', 'loop', 'autoplay', 'speed', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'djo_layout1' ] ]
	] );
}
function djo_contacts_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_heading']) && $shortcode->atts['djo_use_heading'] && isset($shortcode->atts['djo_heading_typo']) && !empty($shortcode->atts['djo_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contact__title'], $shortcode->parse_typography($shortcode->atts['djo_subtitle_typo']));
	}

	if ( isset($shortcode->atts['djo_use_content']) && $shortcode->atts['djo_use_content'] && isset($shortcode->atts['djo_content_typo']) && !empty($shortcode->atts['djo_content_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contact__info a, %1$s .aheto-contact__info p'], $shortcode->parse_typography($shortcode->atts['djo_content_typo']));
	}

	return $css;
}

add_filter('aheto_contacts_dynamic_css', 'djo_contacts_layout1_dynamic_css', 10, 2);
