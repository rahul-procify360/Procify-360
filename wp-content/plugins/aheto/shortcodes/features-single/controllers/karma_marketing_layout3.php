<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_features-single_register', 'karma_marketing_features_single_layout3' );

/**
 * Features Single
 */
function karma_marketing_features_single_layout3 ( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout3', [
		'title' => esc_html__ ( 'Features Single 32', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout3.jpg',
	] );

	aheto_demos_add_dependency ( [ 's_heading', 'use_heading', 't_heading', 's_description', 'use_description' ], [ 'karma_marketing_layout3' ], $shortcode );

    $shortcode -> add_dependecy ( 'karma_marketing_image', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_link_title', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_link_url', 'template', 'karma_marketing_layout3' );

    $shortcode -> add_dependecy ( 'karma_marketing_use_desc_typo', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_desc_typo', 'karma_marketing_use_desc_typo', 'true' );

    $shortcode -> add_dependecy ( 'karma_marketing_use_link_typo', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_link_typo', 'template', 'karma_marketing_layout3' );
    $shortcode -> add_dependecy ( 'karma_marketing_link_typo', 'karma_marketing_use_link_typo', 'true' );

	$shortcode->add_params( [

		'karma_marketing_image'     => [
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Icon', 'karma' ),
			'admin_label' => true,
		],
		'karma_marketing_link_title'     => [
			'type'        => 'text',
			'heading'     => esc_html__( 'Link Title', 'karma' ),
			'admin_label' => true,
		],
		'karma_marketing_link_url'     => [
			'type'        => 'text',
			'heading'     => esc_html__( 'Link URL', 'karma' ),
			'admin_label' => true,
		],

		'karma_marketing_use_link_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Link?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_link_typo' => [
			'type' => 'typography',
			'group' => 'Link Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link a',
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

function karma_marketing_features_single_layout3_dynamic_css ( $css, $shortcode ) {

	if ( !empty( $shortcode -> atts['karma_marketing_use_desc_typo'] ) && !empty( $shortcode -> atts['karma_marketing_desc_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-content-block__info-text'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_desc_typo'] ) );
	}

	if ( !empty( $shortcode -> atts['karma_marketing_use_link_typo'] ) && !empty( $shortcode -> atts['karma_marketing_link_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-content-block__link a'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_link_typo'] ) );
	}

	return $css;

}

add_filter ( 'aheto_features_single_dynamic_css', 'karma_marketing_features_single_layout3_dynamic_css', 10, 2 );
