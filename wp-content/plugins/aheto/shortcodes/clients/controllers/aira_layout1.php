<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_clients_register', 'aira_clients_layout1' );


/**
 * Clients Shortcode
 */
function aira_clients_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/clients/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira main', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_hover_style', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_zoom-color', 'aira_hover_style', ['zoom', 'gray_zoom'] );

    aheto_demos_add_dependency(['clients', 'item_per_row'], ['aira_layout1'], $shortcode);

    $shortcode->add_params( [
        'aira_hover_style'  => [
            'type'    => 'select',
            'heading' => esc_html__('Hover Style', 'aira' ),
            'default' => 'default',
            'options' => [
                'default'   => esc_html__('Default', 'aira' ),
                'grayscale' => esc_html__('Grayscale', 'aira' ),
                'darkness'  => esc_html__('Darkness', 'aira' ),
                'opacity_d'  => esc_html__('Opacity decrease', 'aira' ),
                'zoom'  => esc_html__('Zoom', 'aira' ),
                'gray_zoom'  => esc_html__('Grayscale Zoom', 'aira' ),
            ],
        ],
        'aira_zoom-color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Zoom color', 'aira' ),
            'grid'      => 6,
            'default' => '#ff6138',
            'selectors' => ['{{WRAPPER}} .aheto-clients--aira.gray_zoom a:after, .aheto-clients--aira.gray_zoom a:before' => 'border-color: {{VALUE!important}}!important',
                '{{WRAPPER}} .aheto-clients--aira.zoom a:after, .aheto-clients--aira.zoom a:before' => 'border-color: {{VALUE!important}}!important']
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'    => 'aira_',
        'dependency' => ['template', 'aira_layout1']
    ]);
}