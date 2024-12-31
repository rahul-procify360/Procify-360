<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'sterling_list_layout5');

/**
 * List
 */

function sterling_list_layout5($shortcode)
{

	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('sterling_layout5', [
		'title' => esc_html__('Sterling table', 'sterling'),
		'image' => $dir . 'sterling_layout5.jpg',
	]);

	// sterling Table List
	$shortcode->add_dependecy('sterling_first_column', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_second_column', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_third_column', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_table_lists', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_background', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_use_position_typo', 'template', 'sterling_layout5');
	$shortcode->add_dependecy('sterling_position_typo', 'sterling_use_position_typo', 'true');

	$shortcode->add_params([
		'sterling_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('First Column Title', 'sterling'),
		],
		'sterling_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__('Second Column Title', 'sterling'),
		],
		'sterling_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('Third Column Title', 'sterling'),
		],
		'sterling_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists', 'sterling'),
			'params'  => [
				'sterling_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'sterling'),
				],
				'sterling_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'sterling'),
				],
				'sterling_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'sterling'),
				],
			],
		],
		'sterling_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Background color', 'sterling'),
			'grid'      => 6,
			'selectors' => ['{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}'],
		],
		'sterling_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'sterling'),
			'grid'    => 3,
		],

		'sterling_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-list--column h5',
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'sterling_main_',
	], 'sterling_table_lists');
}