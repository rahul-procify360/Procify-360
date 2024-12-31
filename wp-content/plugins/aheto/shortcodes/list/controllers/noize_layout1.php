<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_list_register', 'noize_list_layout1' );

/**
 * List Shortcode
 */

function noize_list_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/list/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'List 18', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_table_lists', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_align', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_event_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_event_text_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_event_text_typo', 'noize_use_event_typo', 'true' );

    $shortcode->add_dependecy( 'noize_use_location_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_location_text_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_location_text_typo', 'noize_use_location_typo', 'true' );

    $shortcode->add_params( [
        'noize_table_lists'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Table Lists', 'noize' ),
            'params'  => [
                'noize_first_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'First Item Text', 'noize' ),
                ],
                'noize_second_item' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Second Item Text', 'noize' ),
                ],
                'noize_third_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Third Item Text', 'noize' ),
                ],
                'noize_align_item' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Align for First Item Text', 'noize' ),
                    'options' => [
                        'default' => 'Default',
                        'left'    => 'Left',
                        'center'  => 'Center',
                        'right'   => 'Right',
                    ],
                    'default' => 'default',
                ],
            ],
        ],
        'noize_align'         => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align Load Button', 'noize' ),
            'grid'    => 6,
            'options' => \Aheto\Helper::choices_alignment(),
        ],
        'noize_use_event_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for events?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_event_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Events Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--noize--box-white > h5',
        ],
         'noize_use_location_typo'    => [
             'type'    => 'switch',
             'heading' => esc_html__( 'Use custom font for location?', 'noize' ),
             'grid'    => 6,
         ],
         'noize_location_text_typo'   => [
             'type'     => 'typography',
             'group'    => 'Noize Location Typography',
             'settings' => [
                 'tag'        => false,
                 'text_align' => false,
             ],
             'selector' => '{{WRAPPER}} .aheto-list--noize--column',
         ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'noize_main_',
    ], 'noize_table_lists' );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'noize_load_'
    ] );
}

function noize_list_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_event_typo'] ) && ! empty( $shortcode->atts['noize_event_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-list--noize--box-white > h5'], $shortcode->parse_typography( $shortcode->atts['noize_event_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_location_typo'] ) && ! empty( $shortcode->atts['noize_location_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-list--noize--column'], $shortcode->parse_typography( $shortcode->atts['noize_location_text_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_dynamiclist_tabs', 'noize_list_layout1_dynamic_css', 10, 2 );
