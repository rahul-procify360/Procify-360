<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'vestry_list_layout1' );

/**
 * List
 */

function vestry_list_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'vestry_layout1', [
		'title' => esc_html__( 'List 23', 'vestry' ),
		'image' => $dir . 'vestry_layout1.jpg',
	] );


	$shortcode->add_dependecy('vestry_use_list_nav_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_list_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_list_typo', 'vestry_use_list_nav_typo', 'true');

	$shortcode->add_dependecy('vestry_first_column', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_second_column', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_third_column', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_fourth_column', 'template', 'vestry_layout1');

	$shortcode->add_dependecy('vestry_table_lists', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_ts', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_w', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_th', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_f', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_st', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_table_lists_sn', 'template', 'vestry_layout1');

	$shortcode->add_params([
		'vestry_use_list_nav_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for days?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_list_nav_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Days Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-list__header-item',
		],
		'vestry_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('First Column Title', 'vestry'),
		],
		'vestry_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__('Second Column Title', 'vestry'),
		],
		'vestry_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('Third Column Title', 'vestry'),
		],
		'vestry_fourth_column'  => [
			'type'    => 'text',
			'heading' => esc_html__('Fourth Column Title', 'vestry'),
		],
		'vestry_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Monday', 'vestry'),
			'params'  => [
				'vestry_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_ts'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Tuesday', 'vestry'),
			'params'  => [
				'vestry_first_item_ts'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_ts' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_ts'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_w'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Wednesday', 'vestry'),
			'params'  => [
				'vestry_first_item_w'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_w' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_w'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_th'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Thursday', 'vestry'),
			'params'  => [
				'vestry_first_item_th'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_th' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_th'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_f'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Friday', 'vestry'),
			'params'  => [
				'vestry_first_item_f'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_f' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_f'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_st'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Saturday', 'vestry'),
			'params'  => [
				'vestry_first_item_st'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_st' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_st'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
		'vestry_table_lists_sn'   => [
			'type'    => 'group',
			'heading' => esc_html__('Table Lists Sunday', 'vestry'),
			'params'  => [
				'vestry_first_item_sn'  => [
					'type'    => 'text',
					'heading' => esc_html__('First Item Text', 'vestry'),
				],
				'vestry_second_item_sn' => [
					'type'    => 'text',
					'heading' => esc_html__('Second Item Text', 'vestry'),
				],
				'vestry_third_item_sn'  => [
					'type'    => 'text',
					'heading' => esc_html__('Third Item Text', 'vestry'),
				],
			],
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_',
	], 'vestry_table_lists');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_ts_',
	], 'vestry_table_lists_ts');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_w_',
	], 'vestry_table_lists_w');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_th_',
	], 'vestry_table_lists_th');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_f_',
	], 'vestry_table_lists_f');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_st_',
	], 'vestry_table_lists_st');
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'vestry_main_sn_',
	], 'vestry_table_lists_sn');
}