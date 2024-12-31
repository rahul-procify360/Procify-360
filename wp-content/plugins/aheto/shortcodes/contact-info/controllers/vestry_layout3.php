<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'vestry_contact_info_layout3');

/**
 * Contact Info Type Shortcode
 */

function vestry_contact_info_layout3($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('vestry_layout3', [
		'title' => esc_html__('Contact Info 15', 'vestry'),
		'image' => $preview_dir . 'vestry_layout3.jpg',
	]);

	$shortcode->add_dependecy('vestry_address', 'template', 'vestry_layout3');

	$shortcode->add_dependecy('vestry_title', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('vestry_use_typo', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('vestry_title_typo', 'vestry_use_typo', 'true');

	$shortcode->add_dependecy('vestry_date', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('vestry_dateEnd', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('text_day', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('text_month', 'template', 'vestry_layout3');
	$shortcode->add_dependecy('vestry_use_reverse', 'template', 'vestry_layout3');

	$shortcode->add_params([
		'vestry_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'vestry'),
		],
		'vestry_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'vestry'),
			'grid'    => 4,
		],
		'vestry_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__title',
		],
		'vestry_date'     => [
			'type'    => 'text',
			'heading' => esc_html__('Start Date', 'vestry'),
		],
		'vestry_dateEnd'     => [
			'type'    => 'text',
			'heading' => esc_html__('End Date', 'vestry'),
		],
		'text_day'        => [
			'type'    => 'text',
			'heading' => esc_html__('Enter Day', 'vestry'),
			'grid'    => 6,
		],
		'text_month'        => [
			'type'    => 'text',
			'heading' => esc_html__('Enter Month', 'vestry'),
			'grid'    => 6,
		],
		'vestry_use_reverse' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use reverse mod?', 'vestry'),
			'grid'    => 3,
		],
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add address icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'address_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout3']]
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'add_label' => esc_html__('Add Date icon?', 'vestry'),
		'group'     => esc_html__('Icons for item', 'vestry'),
		'prefix'    => 'date_',
		'exclude'    => [ 'align' ],
		'dependency' => ['template', ['vestry_layout3']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_',
		'dependency' => ['template', ['vestry_layout3']]
	]);
}

function vestry_contact_info_layout3_dynamic_css($css, $shortcode)
{
	if (!empty($shortcode->atts['vestry_use_typo']) && !empty($shortcode->atts['vestry_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__title'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
	}
	return $css;
}

add_filter('aheto_contact_info_dynamic_css', 'vestry_contact_info_layout3_dynamic_css', 10, 2);
