<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'sterling_navbar_layout1');

/**
 * Navbar Shortcode
 */
function sterling_navbar_layout1($shortcode)
{
	$dir = '//assets.aheto.co/navbar/previews/';
	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Simple', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_descr', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_left_links', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_use_links_typo', 'template', 'sterling_layout1');
	$shortcode->add_params([
		'sterling_descr'       => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'sterling'),
		],
		'sterling_left_links'  => [
			'type'    => 'group',
			'heading' => esc_html__('Left links', 'sterling'),
			'params'  => [
				'sterling_type_link'   => [
					'type'    => 'select',
					'heading' => esc_html__('Type of link', 'sterling'),
					'options' => [
						'phone'     => esc_html__('Phone', 'sterling'),
						'mail'     => esc_html__('Mail', 'sterling'),
					],
				],
				'sterling_phone'       => [
					'type'    => 'text',
					'heading' => esc_html__('Phone', 'sterling'),
				],
				'sterling_mail'       => [
					'type'    => 'text',
					'heading' => esc_html__('Mail', 'sterling'),
				],
				'sterling_add_icon'    => [
					'type'    => 'switch',
					'heading' => esc_html__('Add icon before label?', 'sterling'),
					'grid'    => 6,
					'default' => '',
				],
			],
		],
		'sterling_use_links_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'sterling'),
			'grid'    => 6,
		],
		'sterling_links_typo'   => [
			'type'     => 'typography',
			'group'    => 'Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--item, {{WRAPPER}} .aheto-navbar--item-link',
		],
	]);
}