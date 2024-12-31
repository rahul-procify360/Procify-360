<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'acacio_progress_bar_layout2' );
/**
 * Progress Bar Shortcode
 */

function acacio_progress_bar_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Progress Bar 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

    aheto_demos_add_dependency( 'heading', [ 'acacio_layout2' ], $shortcode );


    //  Acacio Counter
    $shortcode->add_dependecy( 'acacio_heading_tag', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_use_heading_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_heading_typo', 'acacio_use_heading_typo', 'true' );
    $shortcode->add_dependecy( 'acacio_numbers', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_use_numbers_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_numbers_typo', 'acacio_use_numbers_typo', 'true' );

    $shortcode->add_params([
        'acacio_heading_tag'      => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for heading', 'acacio' ),
            'options' => [
                'h1'  => 'h1',
                'h2'  => 'h2',
                'h3'  => 'h3',
                'h4'  => 'h4',
                'h5'  => 'h5',
                'h6'  => 'h6',
                'p'   => 'p',
                'div' => 'div',
            ],
            'default' => 'h5',
            'grid'    => 5,
        ],
        'acacio_numbers'         => [
            'type'    => 'text',
            'heading' => esc_html__( 'Numbers', 'acacio' ),
        ],
        'acacio_use_heading_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'acacio' ),
            'grid'    => 4,
        ],

        'acacio_heading_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__heading',
        ],

        'acacio_use_numbers_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for numbers?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_numbers_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Numbers Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number',
        ],
    ]);
	
}


function acacio_progress_bar_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_heading_typo'] ) && ! empty( $shortcode->atts['acacio_heading_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-counter__heading'], $shortcode->parse_typography( $shortcode->atts['acacio_heading_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_numbers_typo'] ) && ! empty( $shortcode->atts['acacio_numbers_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['acacio_numbers_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_progress-bar_dynamic_css', 'acacio_progress_bar_layout2_dynamic_css', 10, 2 );
