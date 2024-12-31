<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'hryzantema_contacts_layout1');

/**
 * Contacts Shortcode
 */

function hryzantema_contacts_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout('hryzantema_layout1', [
		'title' => esc_html__('Contacts 6', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 'use_content', 't_heading', 't_content'], ['hryzantema_layout1'], $shortcode);

	$shortcode->add_dependecy('hr_contacts_group', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_dark_style', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_use_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'hryzantema_use_arrow_typo', 'true');

	$shortcode->add_params([
		'hr_contacts_group'         => [
			'type'    => 'group',
			'heading' => esc_html__('HR Consult Contacts', 'hryzantema'),
			'params'  => [
				'hryzantema_heading_tag' => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Heading', 'hryzantema'),
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
				'hryzantema_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'hryzantema'),
				],
				'hryzantema_address'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Address', 'hryzantema'),
				],
				'hryzantema_phone'       => [
					'type'    => 'text',
					'heading' => esc_html__('Phone', 'hryzantema'),
				],

				'hryzantema_email' => [
					'type'    => 'text',
					'heading' => esc_html__('Email', 'hryzantema'),
				],
			]
		],
		'hryzantema_dark_style'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable dark style for swiper buttons?', 'hryzantema'),
			'grid'    => 3,
		],
		'hryzantema_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for arrows?', 'hryzantema'),
			'grid'    => 3,
		],

		'hryzantema_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'hryzantema_main_',
		'dependency' => ['template', ['hryzantema_layout1']],
		'group'      => esc_html__('Hryzantema Button', 'hryzantema'),
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_contacts_',
		'include'        => ['arrows', 'loop', 'autoplay', 'speed', 'simulate_touch'],
		'dependency'     => ['template', ['hryzantema_layout1']],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),
	]);
}

function hryzantema_contacts_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['hryzantema_use_arrow_typo']) && $shortcode->atts['hryzantema_use_arrow_typo'] && isset($shortcode->atts['hryzantema_arrow_typo']) && !empty($shortcode->atts['hryzantema_arrow_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-button-prev, %1$s .swiper-button-next'], $shortcode->parse_typography($shortcode->atts['hryzantema_arrow_typo']));
	}
	return $css;
}

add_filter('aheto_contacts_dynamic_css', 'hryzantema_contacts_layout1_dynamic_css', 10, 2);

