<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contact-forms_register', 'aira_contact_forms_layout3' );

/**
 * Contact forms Shortcode
 */
function aira_contact_forms_layout3( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contact-forms/previews/';


    $shortcode->add_layout( 'aira_layout3', [
        'title' => esc_html__( 'Aira Creative', 'aira' ),
        'image' => $theme_dir . 'aira_layout3.jpg',
    ] );

    aheto_demos_add_dependency( [
        'bg_color_fields',
        'border_radius_input',
        'border_radius_button'
    ], ['aira_layout3' ], $shortcode );

    $shortcode->add_dependecy( 'aira_count_input', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_date_icon_size', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_drop_icon_size', 'template', 'aira_layout3');

    $shortcode->add_params( [
        'aira_date_icon_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Date Icon size', 'aira'),
            'description' => esc_html__( 'Enter icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .date:after' => 'font-size: {{VALUE}}'],
        ],
        'aira_drop_icon_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Selector Icon size', 'aira'),
            'description' => esc_html__( 'Enter icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .your-select:after' => 'font-size: {{VALUE}}'],
        ],
        'aira_count_input'    => [
            'type'     => 'select',
            'heading'  => esc_html__( 'Max inputs per row', 'aira' ),
            'options'  => [
                'four'       => esc_html__( 'Four', 'aira' ),
                'three' => esc_html__( 'Three', 'aira' ),
                'two' => esc_html__( 'Two', 'aira' ),
            ],
            'grid'     => 6,
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => false,
        'prefix'     => 'aira_',
        'layouts' => 'layout1',
        'link' => false,
        'include'    => [
            'style',
            'underline',
        ],
        'dependency' => [ 'template', ['aira_layout3'] ]
    ] );
}