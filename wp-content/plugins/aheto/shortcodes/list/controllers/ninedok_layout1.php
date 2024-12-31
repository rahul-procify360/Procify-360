<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_list_register', 'ninedok_list_layout1' );

/**
 * List
 */

function ninedok_list_layout1 ( $shortcode )
{
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'List 16', 'ninedok' ),
		'image' => $dir . 'acacio_layout2.jpg',
	] );

	$shortcode -> add_dependecy ( 'ninedok_first_column', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_second_column', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_third_column', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_background', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_table_lists', 'template', 'ninedok_layout1' );


	$shortcode -> add_params ( [
		'ninedok_first_column' => [
			'type' => 'text',
			'heading' => esc_html__ ( 'First Column Title', 'ninedok' ),
		],
		'ninedok_second_column' => [
			'type' => 'text',
			'heading' => esc_html__ ( 'Second Column Title', 'ninedok' ),
		],
		'ninedok_third_column' => [
			'type' => 'text',
			'heading' => esc_html__ ( 'Third Column Title', 'ninedok' ),
		],
		'ninedok_table_lists' => [
			'type' => 'group',
			'heading' => esc_html__ ( 'Table Lists', 'ninedok' ),
			'params' => [
				'ninedok_first_item' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'First Item Text', 'ninedok' ),
				],
				'ninedok_second_item' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Second Item Text', 'ninedok' ),
				],
				'ninedok_third_item' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Third Item Text', 'ninedok' ),
				],
			],
		],
		'ninedok_background' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Background color', 'ninedok' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
		],
	] );

	\Aheto\Params ::add_button_params ( $shortcode, [
		'prefix' => 'ninedok_main_',
		'add_button' => true,
	], 'ninedok_table_lists' );
}

function ninedok_list_layout1_dynamic_css ( $css, $shortcode )
{
	if ( !empty( $shortcode -> atts['ninedok_background'] )) {
		$color = Sanitize ::color ( $shortcode -> atts['ninedok_background'] );
		$css['global']['%1$s .aheto-list--row .aheto-list--column']['color'] = $color;
	}

	return $css;
}

add_filter ( 'aheto_list_dynamic_css', 'ninedok_list_layout1_dynamic_css', 10, 2 );