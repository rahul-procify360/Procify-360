<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_contents_register', 'bizy_contents_layout2' );


/**
 * Contents
 */

function bizy_contents_layout2 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode -> add_layout ( 'bizy_layout2', [
		'title' => esc_html__ ( 'Bizy Yellow', 'Bizy' ),
		'image' => $preview_dir . 'bizy_layout2.jpg',
	] );

	$shortcode -> add_dependecy('bizy_size', 'template', 'bizy_layout2');
	$shortcode -> add_dependecy('bizy_color', 'template', 'bizy_layout2');

	$shortcode -> add_dependecy ( 'bizy_use_text_typo', 'template', 'bizy_layout2' );
	$shortcode -> add_dependecy ( 'bizy_text_typo', 'template', 'bizy_layout2' );
	$shortcode -> add_dependecy ( 'bizy_text_typo', 'bizy_use_text_typo', 'true' );

	aheto_demos_add_dependency ( ['faqs', 'first_is_opened'], [ 'bizy_layout2' ], $shortcode );

	$shortcode -> add_params ( [
		'bizy_use_text_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for description?', 'bizy' ),
			'grid' => 3,
		],
		'bizy_text_typo' => [
			'type' => 'typography',
			'group' => 'bizy Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__desc',
		],
		'bizy_size'     => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Size icon', 'bizy' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-contents__title i' => 'font-size: {{VALUE}}px' ],
			'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
		],
		'bizy_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Color icon', 'bizy' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__title i' => 'color: {{VALUE}}'
			],
		],

	] );


}

function bizy_contents_layout2_dynamic_css ( $css, $shortcode )
{

	if ( !empty( $shortcode -> atts['bizy_use_title_typo'] ) && !empty( $shortcode -> atts['bizy_title_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-contents__desc'], $shortcode -> parse_typography ( $shortcode -> atts['bizy_title_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['bizy_color'] ) ) {
		$color = Sanitize::color( $shortcode->atts['bizy_color'] );
		$css['global']['%1$s .aheto-contents__title i']['color'] = $color;
	}
	if ( ! empty( $shortcode->atts['bizy_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['bizy_size'] );
		$css['global']['%1$s .aheto-contents__title i']['size'] = $size;
	}

	return $css;
}

add_filter ( 'aheto_contents_dynamic_css', 'bizy_contents_layout2_dynamic_css', 10, 2 );

