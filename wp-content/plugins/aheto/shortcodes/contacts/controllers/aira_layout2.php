<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contacts_register', 'aira_contacts_layout2' );


/**
 * Contacts Shortcode
 */
function aira_contacts_layout2( $shortcode ) {
    $dir = '//assets.aheto.co/contacts/previews/';


    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Light', 'aira' ),
        'image' => $dir . 'aira_layout2.jpg',
    ] );


    $shortcode->add_dependecy( 'aira_add_phone', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_icon_space', 'template', 'aira_layout2' );

    aheto_demos_add_dependency([
        's_heading',
        'address',
        'phone',
        'email',
        't_heading',
        'use_heading',
        't_content',
        'use_content'
    ], ['aira_layout2'], $shortcode);


    $shortcode->add_params( [
        'aira_icon_space'          => [
            'type'      => 'slider',
            'heading'   => esc_html__('Set icons space in pixels', 'aira'),
            'grid'      => 12,
            'range'     => [
                'px' => [
                    'min'  => 0,
                    'max'  => 50,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .aheto-contact__info i' => 'margin-right: {{SIZE}}px;',
            ],
        ],
        'aira_add_phone'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Additional Phone', 'aira' ),
        ],

    ] );
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add address icon?', 'aira' ),
        'prefix'     => 'aira_address_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout2'] ]
    ]);
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add phone icon?', 'aira' ),
        'prefix'     => 'aira_phone_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout2'] ]
    ]);
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add additional phone icon?', 'aira' ),
        'prefix'     => 'aira_add_phone_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout2'] ]
    ]);
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add email icon?', 'aira' ),
        'prefix'     => 'aira_email_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout2'] ]
    ]);
}

function aira_contacts_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_icon_space'] ) ) {
        $css['global']['%1$s .aheto-contact__info i']['margin-right'] = Sanitize::size( $shortcode->atts['aira_icon_space'] );
    }
    return $css;
}
add_filter( 'aheto_contacts_dynamic_css', 'aira_contacts_layout2_dynamic_css', 10, 2 );