<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_testimonials_register', 'rela_testimonials_layout2' );


/**
 * Testimonials Shortcode
 */
function rela_testimonials_layout2 ( $shortcode )
{

	$shortcode_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode -> add_layout ( 'rela_layout2', [
		'title' => esc_html__ ( 'Testimonials 25', 'rela' ),
		'image' => $shortcode_dir . 'rela_layout2.jpg',
	] );

	$shortcode -> add_dependecy ( 'rela_testimonials_minimal', 'template', 'rela_layout2' );

	$shortcode -> add_dependecy ( 'rela_use_position_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_position_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_position_typo', 'rela_use_position_typo', 'true' );

	$shortcode -> add_dependecy ( 'rela_use_name_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_name_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_name_typo', 'rela_use_name_typo', 'true' );

	$shortcode -> add_dependecy ( 'rela_use_descr_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_descr_typo', 'template', 'rela_layout2' );
	$shortcode -> add_dependecy ( 'rela_descr_typo', 'rela_use_descr_typo', 'true' );


	$shortcode -> add_params ( [
		'rela_testimonials_minimal' => [
			'type' => 'group',
			'heading' => esc_html__ ( 'Minimal Testimonials Items', 'rela' ),
			'params' => [
				'rela_name' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Name', 'rela' ),
					'default' => esc_html__ ( 'Author name', 'rela' ),
				],
				'rela_company' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Position', 'rela' ),
					'default' => esc_html__ ( 'Author position', 'rela' ),
				],
				'rela_testimonial' => [
					'type' => 'textarea',
					'heading' => esc_html__ ( 'Testimonial', 'rela' ),
					'default' => esc_html__ ( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'rela' ),
				],
			],
		],
		'rela_use_position_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for position?', 'rela' ),
			'grid' => 3,
		],
		'rela_position_typo' => [
			'type' => 'typography',
			'group' => 'Rela Position Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'rela_use_name_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for name?', 'rela' ),
			'grid' => 3,
		],
		'rela_name_typo' => [
			'type' => 'typography',
			'group' => 'Rela Name Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'rela_use_descr_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for description?', 'rela' ),
			'grid' => 3,
		],
		'rela_descr_typo' => [
			'type' => 'typography',
			'group' => 'Rela Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],

	] );

	\Aheto\Params ::add_carousel_params ( $shortcode, [
		'custom_options' => true,
		'prefix' => 'rela_swiper_min_',
		'include' => [ 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'pagination' ],
		'dependency' => [ 'template', [ 'rela_layout2' ] ]
	] );
}

function rela_testimonials_layout2_dynamic_css ( $css, $shortcode )
{

	if ( isset( $shortcode -> atts[ 'rela_use_name_typo' ] ) && $shortcode -> atts[ 'rela_use_name_typo' ] && isset( $shortcode -> atts[ 'rela_name_typo' ] ) && !empty( $shortcode -> atts[ 'rela_name_typo' ] ) ) {
		\aheto_add_props ( $css[ 'global' ][ '%1$s .aheto-tm__name' ], $shortcode -> parse_typography ( $shortcode -> atts[ 'rela_name_typo' ] ) );
	}
	if ( isset( $shortcode -> atts[ 'rela_use_position_typo' ] ) && $shortcode -> atts[ 'rela_use_position_typo' ] && isset( $shortcode -> atts[ 'rela_position_typo' ] ) && !empty( $shortcode -> atts[ 'rela_position_typo' ] ) ) {
		\aheto_add_props ( $css[ 'global' ][ '%1$s .aheto-tm__position' ], $shortcode -> parse_typography ( $shortcode -> atts[ 'rela_position_typo' ] ) );
	}
	if ( isset( $shortcode -> atts[ 'rela_use_descr_typo' ] ) && $shortcode -> atts[ 'rela_use_descr_typo' ] && isset( $shortcode -> atts[ 'rela_descr_typo' ] ) && !empty( $shortcode -> atts[ 'rela_descr_typo' ] ) ) {
		\aheto_add_props ( $css[ 'global' ][ '%1$s .aheto-tm__text' ], $shortcode -> parse_typography ( $shortcode -> atts[ 'rela_descr_typo' ] ) );
	}
	if ( isset( $shortcode -> atts[ 'rela_use_bg_typo' ] ) && $shortcode -> atts[ 'rela_use_bg_typo' ] && isset( $shortcode -> atts[ 'rela_bg_typo' ] ) && !empty( $shortcode -> atts[ 'rela_bg_typo' ] ) ) {
		\aheto_add_props ( $css[ 'global' ][ '%1$s .aheto-tm__bg-text' ], $shortcode -> parse_typography ( $shortcode -> atts[ 'rela_bg_typo' ] ) );
	}

	return $css;
}

add_filter ( 'aheto_testimonials_dynamic_css', 'rela_testimonials_layout2_dynamic_css', 10, 2 );