<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_list_register', 'aira_list_layout2' );


/**
 * List Shortcode
 */

function aira_list_layout2( $shortcode ) {
    $dir = '//assets.aheto.co/list/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Styled List', 'aira' ),
        'image' => $dir . 'aira_layout2.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_styled_lists', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_light_theme', 'template', 'aira_layout2' );

    $shortcode->add_dependecy('aira_use_number_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy('aira_number_typo', 'aira_use_number_typo', 'true' );

    $shortcode->add_params( [
        'aira_use_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Number?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_number_typo' => [
            'type'     => 'typography',
            'group'    => 'Number Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list__number',
        ],
        'aira_light_theme'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Turn on light style text?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_styled_lists'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Table Lists', 'aira' ),
            'params'  => [
                'aira_list_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'First Item Text', 'aira' ),
                    'default'    => 'List item',
                ],
            ],
        ],
    ] );
}

function aira_list_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_number_typo'] ) && ! empty( $shortcode->atts['aira_number_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-list__number'], $shortcode->parse_typography( $shortcode->atts['aira_number_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'aira_list_layout2_dynamic_css', 10, 2 );