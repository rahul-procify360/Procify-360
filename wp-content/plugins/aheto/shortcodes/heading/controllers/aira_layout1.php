<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_heading_register', 'aira_heading_layout1' );


/**
 * Heading Shortcode
 */
function aira_heading_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/heading/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Simple', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );


    $shortcode->add_dependecy( 'aira_description_tag', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_use_description_typo', 'template', 'aira_layout1' );

    $shortcode->add_dependecy( 'aira_description_typo', 'aira_use_description_typo', 'true' );

    aheto_demos_add_dependency( ['use_typo','text_typo','heading','use_typo_hightlight','description','alignment','text_tag', 'text_typo_hightlight'], [ 'aira_layout1' ], $shortcode );

    $shortcode->add_params( [
        'aira_use_description_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_description_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__description',
        ],
        'aira_description_tag'      => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for Description', 'aira' ),
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
            'default' => 'p',
            'grid'    => 5,
        ],

    ] );

}

function aira_heading_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_description_typo'] ) && ! empty( $shortcode->atts['aira_description_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-heading__description'], $shortcode->parse_typography( $shortcode->atts['aira_description_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'aira_heading_layout1_dynamic_css', 10, 2 );
