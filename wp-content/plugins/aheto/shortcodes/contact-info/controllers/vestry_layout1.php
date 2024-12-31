<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'vestry_contact_info_layout1');

/**
 * Contact Info Type Shortcode
 */

function vestry_contact_info_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Contact Info 13', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
	]);

	$shortcode->add_dependecy('vestry_description', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_use_description_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_description_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_description_typo', 'vestry_use_description_typo', 'true');

	$shortcode->add_dependecy('vestry_address', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_email', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_phone', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_phone2', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_phone3', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_time', 'template', 'vestry_layout1');

	$shortcode->add_dependecy('vestry_use_info_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_info_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_info_typo', 'vestry_use_info_typo', 'true');

	$shortcode->add_params([
		'vestry_description' => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'vestry'),
		],
		'vestry_use_description_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'vestry'),
			'grid'    => 4,
		],
		'vestry_description_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__desc',
		],
		'vestry_address'     => [
			'type'    => 'textarea',
			'heading' => esc_html__('Address', 'vestry'),
		],
		'vestry_email'       => [
			'type'    => 'text',
			'heading' => esc_html__('Email', 'vestry'),
		],
		'vestry_phone'       => [
			'type'    => 'text',
			'heading' => esc_html__('Phone', 'vestry'),
		],
		'vestry_phone2'       => [
			'type'    => 'text',
			'heading' => esc_html__('Phone 2', 'vestry'),
		],
		'vestry_phone3'       => [
			'type'    => 'text',
			'heading' => esc_html__('Phone 3', 'vestry'),
		],
		'vestry_time'       => [
			'type'    => 'text',
			'heading' => esc_html__('Time', 'vestry'),
		],
		'vestry_use_info_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for info items?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_info_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Info Items Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__info-item'
		],
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add email icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'email_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout1']]
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add phone icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'phone_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout1']]
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add time icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'time_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout1']]
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add address icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'address_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout1']]
	]);
}


function vestry_contact_info_layout1_dynamic_css($css, $shortcode) {
	if ( !empty($shortcode->atts['vestry_use_info_typo']) && !empty($shortcode->atts['vestry_info_typo']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__info-item'], $shortcode->parse_typography($shortcode->atts['vestry_info_typo']));
	}
  
	return $css;
}

add_filter('aheto_contact_info_dynamic_css', 'vestry_contact_info_layout1_dynamic_css', 10, 2);