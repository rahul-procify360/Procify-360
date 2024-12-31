<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contact-forms_register', 'aira_contact_forms_layout2' );

/**
 * Contact forms Shortcode
 */
function aira_contact_forms_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    aheto_demos_add_dependency([
        'title',
        'title_typo',
        'use_title_typo',
        'bg_color_fields',
        'border_radius_input',
        'border_radius_button'
        ], ['aira_layout2'], $shortcode);

    $shortcode->add_dependecy( 'aira_title_tag', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_count_input', 'template', 'aira_layout2');
    $shortcode->add_dependecy( 'aira_drop_icon_size', 'template', 'aira_layout2');

    $shortcode->add_params( [
        'aira_drop_icon_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Selector Icon size', 'aira'),
            'description' => esc_html__( 'Enter icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .your-select:after' => 'font-size: {{VALUE}}'],
        ],
        'aira_title_tag' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for Title', 'aira' ),
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
            'default' => 'h5',
            'grid'    => 5,
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
        'dependency' => [ 'template', ['aira_layout2'] ]
    ] );
}