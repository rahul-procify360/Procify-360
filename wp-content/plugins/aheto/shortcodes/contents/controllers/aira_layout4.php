<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contents_register', 'aira_contents_layout4' );

/**
 * Contents Shortcode
 */

function aira_contents_layout4( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contents/previews/';


    $shortcode->add_layout( 'aira_layout4', [
        'title' => esc_html__( 'Aira Faq', 'aira' ),
        'image' => $theme_dir . 'aira_layout4.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_box_shadow', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_faq_item_color', 'template', 'aira_layout4' );

    $shortcode->add_dependecy( 'aira_use_title_typo', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_title_typo', 'aira_use_title_typo', 'true' );
    $shortcode->add_dependecy( 'aira_use_text_typo', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_text_typo', 'aira_use_text_typo', 'true' );

    aheto_demos_add_dependency( [
        'faqs',
        'multi_active',
        'first_is_opened'
    ], [ 'aira_layout4' ], $shortcode );

    $shortcode->add_params( [
        'aira_faq_item_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Item background color', 'aira' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-contents__item' => 'background-color: {{VALUE}}' ],
        ],
        'aira_box_shadow'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Turn on items shadow?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_use_title_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_title_typo' => [
            'type' => 'typography',
            'group' => 'Title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__title',
        ],
        'aira_use_text_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_text_typo' => [
            'type' => 'typography',
            'group' => 'Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__desc',
        ],
    ] );

}
function aira_contents_layout4_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['aira_use_title_typo'] ) && ! empty( $shortcode->atts['aira_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography( $shortcode->atts['aira_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_text_typo'] ) && ! empty( $shortcode->atts['aira_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__desc'], $shortcode->parse_typography( $shortcode->atts['aira_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_faq_item_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['aira_faq_item_color'] );
        $css['global']['%1$s .aheto-contents__item']['background-color'] = $color;
    }
    return $css;
}
add_filter( 'aheto_contents_dynamic_css', 'aira_contents_layout4_dynamic_css', 10, 2 );