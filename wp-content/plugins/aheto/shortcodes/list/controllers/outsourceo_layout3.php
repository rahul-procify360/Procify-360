<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'outsourceo_list_layout3' );

/**
 * List Shortcode
 */

function outsourceo_list_layout3( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'outsourceo_layout3', [
		'title' => esc_html__( 'List 21', 'outsourceo' ),
		'image' => $dir . 'acacio_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_first_column', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_second_column', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_third_column', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_table_lists', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_background', 'template', 'outsourceo_layout3' );

	$shortcode->add_params( [
		'outsourceo_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'First Column Title', 'outsourceo' ),
		],
		'outsourceo_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Second Column Title', 'outsourceo' ),
		],
		'outsourceo_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Third Column Title', 'outsourceo' ),
		],
		'outsourceo_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Table Lists', 'outsourceo' ),
			'params'  => [
				'outsourceo_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'First Item Text', 'outsourceo' ),
				],
				'outsourceo_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Second Item Text', 'outsourceo' ),
				],
				'outsourceo_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'Third Item Text', 'outsourceo' ),
				],
			],
		],
		'outsourceo_background'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
		]
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_main_',
		'add_button' => true,
	], 'outsourceo_table_lists' );

}

function outsourceo_list_layout3_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_background'] ) ) {
		$color                                                                    = Sanitize::color( $shortcode->atts['outsourceo_background'] );
		$css['global']['%1$s .aheto-list--row .aheto-list--column']['background'] = $color;
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'outsourceo_list_layout3_dynamic_css', 10, 2 );