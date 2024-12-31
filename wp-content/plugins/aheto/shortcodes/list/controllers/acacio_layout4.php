<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'acacio_list_layout4' );

/**
 * List
 */

function acacio_list_layout4( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'acacio_layout4', [
		'title' => esc_html__( 'List 4', 'acacio' ),
		'image' => $dir . 'acacio_layout4.jpg',
	] );

    aheto_demos_add_dependency( 'lists', [ 'acacio_layout4' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_use_list_typo', 'template', 'acacio_layout4' );
    $shortcode->add_dependecy( 'acacio_list_typo', 'template', 'acacio_layout4' );
    $shortcode->add_dependecy( 'acacio_list_typo', 'acacio_use_list_typo', 'true' );

    $shortcode->add_params( [
        'acacio_use_list_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for list?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_list_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio List Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} li, {{WRAPPER}} p',
        ],
    ] );
}

function acacio_list_layout4_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_list_typo'] ) && ! empty( $shortcode->atts['acacio_list_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s li, %1$s p'], $shortcode->parse_typography( $shortcode->atts['acacio_list_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'acacio_list_layout4_dynamic_css', 10, 2 );