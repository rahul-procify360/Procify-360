<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_list_register', 'aira_list_layout1' );


/**
 * List Shortcode
 */

function aira_list_layout1( $shortcode ) {
    $dir = '//assets.aheto.co/list/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Table List', 'aira' ),
        'image' => $dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_first_column', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_second_column', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_third_column', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_table_lists', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_background', 'template', 'aira_layout1' );

    $shortcode->add_params( [
        'aira_first_column'  => [
            'type'    => 'text',
            'heading' => esc_html__( 'First Column Title', 'aira' ),
        ],
        'aira_second_column' => [
            'type'    => 'text',
            'heading' => esc_html__( 'Second Column Title', 'aira' ),
        ],
        'aira_third_column'  => [
            'type'    => 'text',
            'heading' => esc_html__( 'Third Column Title', 'aira' ),
        ],
        'aira_table_lists'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Table Lists', 'aira' ),
            'params'  => [
                'aira_first_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'First Item Text', 'aira' ),
                ],
                'aira_second_item' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Second Item Text', 'aira' ),
                ],
                'aira_third_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Third Item Text', 'aira' ),
                ],
            ],
        ],
        'aira_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color', 'aira' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
        ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'aira_main_',
    ], 'aira_table_lists' );

}

function aira_list_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_links_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['color'] );
        $css['global']['%1$s li a']['color'] = $color;
    }

    if ( ! empty( $shortcode->atts['aira_background'] ) ) {
        $color = Sanitize::color( $shortcode->atts['aira_background'] );
        $css['global']['%1$s .aheto-list--row .aheto-list--column']['background'] = $color;
    }

    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'aira_list_layout1_dynamic_css', 10, 2 );
