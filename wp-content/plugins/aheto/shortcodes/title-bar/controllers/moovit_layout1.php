<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_title-bar_register', 'moovit_title_bar_layout1' );

/**
 * Title Bar
 */

function moovit_title_bar_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Title Bar 5', 'moovit' ),
		'image' => $dir . 'moovit_layout1.jpg',
	] );


	aheto_demos_add_dependency( ['background', 'overlay', 'source', 'title', 'title_tag', 'use_title_typo', 'title_typo', 'content_width', 'height', 'content_light', 'title_bar_paddings'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_text', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_searchform', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_sf_placeholder', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_sf_placeholder', 'moovit_searchform', 'true' );
    $shortcode->add_dependecy( 'moovit_use_descr_typo', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_descr_typo', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_descr_typo', 'moovit_use_descr_typo', 'true' );

	$shortcode->add_params( [
		'moovit_searchform'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Search Form', 'moovit' ),
			'grid'    => 6,
		],
		'moovit_sf_placeholder' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Input Placeholder', 'moovit' ),
			'default' => 'Keyword Search...',
			'grid'    => 6,
		],
		'moovit_text'           => [
			'type'    => 'textarea',
			'heading' => esc_html__( 'Description', 'moovit' ),
		],
        'moovit_use_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'outsourceo' ),
            'grid'    => 6,
        ],
        'moovit_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Moovit Description Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-titlebar__description',
        ],
	] );
}

function moovit_title_bar_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['moovit_use_descr_typo'] ) && ! empty( $shortcode->atts['moovit_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-titlebar__description'], $shortcode->parse_typography( $shortcode->atts['moovit_descr_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_title_bar_dynamic_css', 'moovit_title_bar_layout1_dynamic_css', 10, 2 );
