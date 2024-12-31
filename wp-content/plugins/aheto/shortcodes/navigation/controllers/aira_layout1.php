<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_navigation_register', 'aira_navigation_layout1' );



/**
 * Navigation Shortcode
 */
function aira_navigation_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira footer', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_layout( 'aira_layout3', [
        'title' => esc_html__( 'Aira services first', 'aira' ),
        'image' => $theme_dir . 'aira_layout3.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_use_link_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_link_typo', 'aira_use_link_typo', 'true' );


    aheto_demos_add_dependency(['title','title_space','text_typo','list_space','hovercolor'], ['aira_layout1'], $shortcode);

    $shortcode->add_params( [
        'aira_use_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Menu links?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Menu links Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .menu-item a',
        ],
    ] );
}

function aira_navigation_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['aira_use_link_typo'] ) && ! empty( $shortcode->atts['aira_link_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .menu-item a'], $shortcode->parse_typography( $shortcode->atts['aira_link_typo'] ) );
    }
    return $css;
}
add_filter( 'aheto_navigation_dynamic_css', 'aira_navigation_layout1_dynamic_css', 10, 2 );

