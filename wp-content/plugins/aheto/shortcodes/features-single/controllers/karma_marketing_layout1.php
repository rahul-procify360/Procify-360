<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_features-single_register', 'karma_marketing_features_single_layout1' );


/**
 * Heading
 */
function karma_marketing_features_single_layout1 ( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout1', [
		'title' => esc_html__ ( 'Features Single 30', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	] );

	aheto_demos_add_dependency ( [ 's_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description', 'button' ], [ 'karma_marketing_layout1' ], $shortcode );

	$shortcode -> add_dependecy ( 'karma_marketing_overlay', 'template', 'karma_marketing_layout1' );

	$shortcode -> add_dependecy ( 'karma_marketing_use_desc_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'karma_marketing_use_desc_typo', 'true' );

	$shortcode->add_params( [

		'karma_marketing_overlay' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Overlay icon color', 'karma' ),
			'grid'      => 6,
			'default'   => 'transparent',
			'selectors' => [
				'{{WRAPPER}} .aheto-content-block__image:before' => 'background-image: linear-gradient(134deg, {{VALUE}} 0%, #ffffff 65%);',
			],
		],

		'karma_marketing_use_desc_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Description?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_desc_typo' => [
			'type' => 'typography',
			'group' => 'Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
		],

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Karma size for additional image', 'karma' ),
		'prefix'         => 'karma_marketing_',
		'dependency' => ['template',  ['karma_marketing_layout1']]
	]);

}

function karma_marketing_features_single_layout1_dynamic_css ( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['karma_marketing_overlay'] ) ) {
		$color = Sanitize::color( $shortcode->atts['karma_marketing_overlay_overlay'] );
		$css['global']['%1$s .aheto-content-block__image:before']['background-image'] = $color;
	}

	if ( !empty( $shortcode -> atts['karma_marketing_use_desc_typo'] ) && !empty( $shortcode -> atts['karma_marketing_desc_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-content-block__info-text'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_desc_typo'] ) );
	}

	return $css;

}

add_filter ( 'aheto_features_single_dynamic_css', 'karma_marketing_features_single_layout1_dynamic_css', 10, 2 );
