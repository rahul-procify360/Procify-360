<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_social-networks_register', 'acacio_social_networks_layout1' );

/**
 * Social Networks
 */

function acacio_social_networks_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Social Networks 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['networks', 'style', 'hovercolor_circle', 'hovercolor_default', 'color', 'size', 'socials_align_mob', 'socials_align'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_dark_style', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_use_socials_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_socials_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_socials_typo', 'acacio_use_socials_typo', 'true' );
    $shortcode->add_params( [

        'acacio_dark_style' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable dark style for socials?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_use_socials_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for socials?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_socials_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Socials Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-socials__link',
        ],
    ] );
}


function acacio_social_networks_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_socials_typo'] ) && ! empty( $shortcode->atts['acacio_socials_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-socials__link'], $shortcode->parse_typography( $shortcode->atts['acacio_socials_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_social-networks_dynamic_css', 'acacio_social_networks_layout1_dynamic_css', 10, 2 );