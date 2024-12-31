<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'moovit_list_layout3' );

/**
 * List
 */

function moovit_list_layout3( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'moovit_layout3', [
		'title' => esc_html__( 'List 15', 'moovit' ),
		'image' => $dir . 'acacio_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_first_column', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_second_column', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_third_column', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_table_lists', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_background', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_use_headings', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_t_headings', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_t_headings', 'moovit_use_headings', 'true' );

	$shortcode->add_params( [
		'moovit_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'First Column Title', 'moovit' ),
		],
		'moovit_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Second Column Title', 'moovit' ),
		],
		'moovit_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Third Column Title', 'moovit' ),
		],
		'moovit_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Table Lists', 'moovit' ),
			'params'  => [
				'moovit_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'First Item Text', 'moovit' ),
				],
				'moovit_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Second Item Text', 'moovit' ),
				],
				'moovit_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'Third Item Text', 'moovit' ),
				],
			],
		],

		'moovit_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
		],
		'moovit_use_headings'    => [
			'type'        => 'switch',
			'heading'     => esc_html__( 'Use custom font for top headings?', 'aheto' ),
			'grid'        => 3,
		],
		'moovit_t_headings'      => [
			'type'     => 'typography',
			'group'    => 'Moovit Top headings Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-list--main-row .aheto-list--column',
		],
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'moovit_main_',
	], 'moovit_table_lists' );

}

function moovit_list_layout3_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s .aheto-list--row .aheto-list--column']['background'] = $color;
	}


	if ( ! empty( $shortcode->atts['moovit_use_headings'] ) && ! empty( $shortcode->atts['moovit_t_headings'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-list--main-row .aheto-list--column'], $shortcode->parse_typography( $shortcode->atts['moovit_t_headings'] ) );
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'moovit_list_layout3_dynamic_css', 10, 2 );