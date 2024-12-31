<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout2' );

/**
 * Features Single
 */

function acacio_features_single_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Features Single 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['use_heading', 't_heading', 's_image' ], [ 'acacio_layout2' ], $shortcode );

    // Acacio Simple with image
    $shortcode->add_dependecy( 'acacio_add_title', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_title', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_description', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_content_orientation', 'template', 'acacio_layout2' );

    $shortcode->add_dependecy( 'acacio_use_description_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_description_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_description_typo', 'acacio_use_description_typo', 'true' );


    $shortcode->add_params( [
        'acacio_title' => [
            'type'     => 'text',
            'heading' => esc_html__( 'Add your title', 'acacio' ),
            'grid' =>  1
        ],
        'acacio_description' => [
            'type'     => 'textarea',
            'heading' => esc_html__( 'Add your description', 'acacio' ),
            'grid' => 3
        ],
        'acacio_use_description_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_description_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__info-text, {{WRAPPER}} .aheto-content-block__info-text',
        ],
        'acacio_content_orientation' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Content orientation', 'acacio' ),
            'options' => [
                ''            => esc_html__( 'Line', 'acacio' ),
                'column'      => esc_html__( 'Column', 'acacio' ),
            ],
        ],

    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout2'] ]
    ]);
}

function acacio_features_single_layout2_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_description_typo'] ) && ! empty( $shortcode->atts['acacio_description_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-features-block__info-text'], $shortcode->parse_typography( $shortcode->atts['acacio_description_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'acacio_features_single_layout2_dynamic_css', 10, 2 );