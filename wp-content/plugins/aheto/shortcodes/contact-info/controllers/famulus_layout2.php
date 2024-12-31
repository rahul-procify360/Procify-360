<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'famulus_contact_info_layout2');

/**
 * Contact Info Type Shortcode
 */

function famulus_contact_info_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Contact Info 2', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	$shortcode->add_dependecy('famulus_info', 'template', 'famulus_layout2');

	$shortcode->add_params([
		'advanced'     => true,
		'famulus_info' => [
			'type'    => 'group',
			'heading' => esc_html__('Contacts', 'famulus'),
			'params'  => [
				'famulus_title'    => [
					'type'    => 'editor',
					'heading' => esc_html__('Title', 'famulus'),
				],
				'famulus_desc'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'famulus'),
				],
				'famulus_location' => [
					'type'    => 'text',
					'heading' => esc_html__('Location', 'famulus'),
				],
				'famulus_phone'    => [
					'type'    => 'text',
					'heading' => esc_html__('Phone', 'famulus'),
				],
				'famulus_email'    => [
					'type'    => 'text',
					'heading' => esc_html__('Email', 'famulus'),
				],
			]
		]
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'prefix'    => '',
		'add_icon'  => true,
		'add_label' => esc_html__('Add icon?', 'famulus'),
		'exclude'   => ['align', 'color'],
	], 'famulus_info');
}
