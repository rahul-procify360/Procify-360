<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'hryzantema_list_layout2');

/**
 * HR Consult List
 */

function hryzantema_list_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'List 6', 'hryzantema' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_first_column', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_second_column', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_third_column', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_table_lists', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_links_color', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_background', 'template', 'hryzantema_layout2' );

	$shortcode->add_dependecy( 'hryzantema_use_position_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'hryzantema_use_position_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_col_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_col_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_col_typo', 'hryzantema_use_col_typo', 'true' );

	$shortcode->add_params( [
		'hryzantema_first_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'First Column Title', 'hryzantema' ),
		],
		'hryzantema_second_column' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Second Column Title', 'hryzantema' ),
		],
		'hryzantema_third_column'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Third Column Title', 'hryzantema' ),
		],
		'hryzantema_table_lists'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Table Lists', 'hryzantema' ),
			'params'  => [
				'hryzantema_first_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'First Item Text', 'hryzantema' ),
				],
				'hryzantema_second_item' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Second Item Text', 'hryzantema' ),
				],
				'hryzantema_third_item'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'Third Item Text', 'hryzantema' ),
				],
			],
		],
		'hryzantema_links_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--hr-links li a' => 'color: {{VALUE}}' ],
		],
		'hryzantema_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
		],
		'hryzantema_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-list--column h5',
		],
		'hryzantema_use_col_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for column name?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_col_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Column name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-list--column, {{WRAPPER}} .aheto-list--column p',
		],
	] );
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
	], 'hryzantema_table_lists' );
}
function hryzantema_list_layout2_dynamic_css( $css, $shortcode ) {
	if ( ! empty( $shortcode->atts['hryzantema_links_color'] ) ) {
		$color = Sanitize::color( $shortcode->atts['color'] );
		$css['global']['%1$s li a']['color'] = $color;
	}

	if ( ! empty( $shortcode->atts['hryzantema_background'] ) ) {
		$color = Sanitize::color( $shortcode->atts['hryzantema_background'] );
		$css['global']['%1$s .aheto-list--row .aheto-list--column']['background'] = $color;
	}

	if ( isset( $shortcode->atts['hryzantema_use_position_typo'] ) && $shortcode->atts['hryzantema_use_position_typo'] && isset( $shortcode->atts['hryzantema_position_typo'] ) && ! empty( $shortcode->atts['hryzantema_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-list--column h5'], $shortcode->parse_typography( $shortcode->atts['hryzantema_position_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_col_typo'] ) && $shortcode->atts['hryzantema_use_col_typo'] && isset( $shortcode->atts['hryzantema_col_typo'] ) && ! empty( $shortcode->atts['hryzantema_col_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s  .aheto-list--column, %1$s  .aheto-list--column p'], $shortcode->parse_typography( $shortcode->atts['hryzantema_col_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'hryzantema_list_layout2_dynamic_css', 10, 2 );
