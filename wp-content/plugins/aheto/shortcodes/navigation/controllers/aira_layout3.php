<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_navigation_register', 'aira_navigation_layout3' );



/**
 * Navigation Shortcode
 */
function aira_navigation_layout3( $shortcode ) {

    $theme_dir = '//assets.aheto.co/navigation/previews/';


    $shortcode->add_dependecy( 'aira_icon_size', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_arrows_color', 'template', 'aira_layout3' );

    $shortcode->add_dependecy( 'aira_use_link_typo', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_link_typo', 'aira_use_link_typo', 'true' );

    aheto_demos_add_dependency(['list_space','hovercolor'], ['aira_layout3'], $shortcode);

    $shortcode->add_params( [
        'aira_icon_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Icon size', 'aira'),
            'description' => esc_html__( 'Enter icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .menu-item:before' => 'font-size: {{VALUE}}'],
        ],
        'aira_arrows_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Hover arrows color', 'aira' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .widget-nav-menu__menu li:before' => 'color: {{VALUE}}' ],
        ],
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

function aira_navigation_layout3_dynamic_css( $css, $shortcode ) {
    if ( !empty($shortcode->atts['aira_icon_size']) ) {
        $css['global']['%1$s .aheto-contents__item i']['font-size'] = Sanitize::size( $shortcode->atts['aira_icon_size'] );
    }
    if ( ! empty( $shortcode->atts['aira_arrows_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['aira_arrows_color'] );
        $css['global']['%1$s .widget-nav-menu__menu li:before']['color'] = $color;
    }
    if ( ! empty( $shortcode->atts['aira_use_link_typo'] ) && ! empty( $shortcode->atts['aira_link_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .menu-item a'], $shortcode->parse_typography( $shortcode->atts['aira_link_typo'] ) );
    }
    return $css;
}
add_filter( 'aheto_navigation_dynamic_css', 'aira_navigation_layout3_dynamic_css', 10, 2 );

