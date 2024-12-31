<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_features-single_register', 'karma_marketing_features_single_layout2' );


/**
 * Features Single
 */
function karma_marketing_features_single_layout2 ( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout2', [
		'title' => esc_html__ ( 'Features Single 31', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout2.jpg',
	] );

	aheto_demos_add_dependency ( [ 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description' ], [ 'karma_marketing_layout2' ], $shortcode );

    $shortcode -> add_dependecy ( 'karma_marketing_number', 'template', 'karma_marketing_layout2' );

	$shortcode -> add_dependecy ( 'karma_marketing_use_number_typo', 'template', 'karma_marketing_layout2' );
	$shortcode -> add_dependecy ( 'karma_marketing_number_typo', 'template', 'karma_marketing_layout2' );
	$shortcode -> add_dependecy ( 'karma_marketing_number_typo', 'karma_marketing_use_number_typo', 'true' );

	$shortcode -> add_dependecy ( 'karma_marketing_use_desc_typo', 'template', 'karma_marketing_layout2' );
	$shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'template', 'karma_marketing_layout2' );
	$shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'karma_marketing_use_desc_typo', 'true' );

	$shortcode->add_params( [

		'karma_marketing_number'     => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Number', 'karma' ),
			'description' => esc_html__( 'Add some Number', 'karma' ),
			'admin_label' => true,
			'default' => esc_html__ ( '01', 'karma' ),

		],

		'karma_marketing_use_number_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Number?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_number_typo' => [
			'type' => 'typography',
			'group' => 'Number Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__number',
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

}

function karma_marketing_features_single_layout2_dynamic_css ( $css, $shortcode ) {

	if ( !empty( $shortcode -> atts['karma_marketing_use_number_typo'] ) && !empty( $shortcode -> atts['karma_marketing_number_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-content-block__number'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_number_typo'] ) );
	}

	if ( !empty( $shortcode -> atts['karma_marketing_use_desc_typo'] ) && !empty( $shortcode -> atts['karma_marketing_desc_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-content-block__info-text'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_desc_typo'] ) );
	}
	return $css;

}

add_filter ( 'aheto_features_single_dynamic_css', 'karma_marketing_features_single_layout2_dynamic_css', 10, 2 );
