<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_contents_register', 'ninedok_contents_layout1' );


/**
 * Contents
 */

function ninedok_contents_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Content 23', 'Ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

	$shortcode -> add_dependecy('ninedok_size', 'template', 'ninedok_layout1');
	$shortcode -> add_dependecy('ninedok_color', 'template', 'ninedok_layout1');

	$shortcode -> add_dependecy ( 'ninedok_use_text_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_text_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_text_typo', 'ninedok_use_text_typo', 'true' );

	aheto_demos_add_dependency ( ['faqs', 'first_is_opened'], [ 'ninedok_layout1' ], $shortcode );

	$shortcode -> add_params ( [
		'ninedok_use_text_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for description?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_text_typo' => [
			'type' => 'typography',
			'group' => 'Ninedok Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__desc',
		],
		'ninedok_size'     => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Size icon', 'ninedok' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-contents__title i' => 'font-size: {{VALUE}}px' ],
			'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
		],
		'ninedok_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Color icon', 'ninedok' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__title i' => 'color: {{VALUE}}'
			],
		],

	] );


}

function ninedok_contents_layout1_dynamic_css ( $css, $shortcode )
{

	if ( !empty( $shortcode -> atts['ninedok_use_title_typo'] ) && !empty( $shortcode -> atts['ninedok_title_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-contents__desc'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_title_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['ninedok_color'] ) ) {
		$color = Sanitize::color( $shortcode->atts['ninedok_color'] );
		$css['global']['%1$s .aheto-contents__title i']['color'] = $color;
	}
	if ( ! empty( $shortcode->atts['ninedok_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['ninedok_size'] );
		$css['global']['%1$s .aheto-contents__title i']['size'] = $size;
	}

	return $css;
}

add_filter ( 'aheto_contents_dynamic_css', 'ninedok_contents_layout1_dynamic_css', 10, 2 );

