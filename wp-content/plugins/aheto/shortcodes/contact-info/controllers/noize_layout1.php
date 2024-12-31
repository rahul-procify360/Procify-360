<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-info_register', 'noize_contact_info_layout1' );

/**
 * Contact info Shortcode
 */
function noize_contact_info_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/contact-info/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Contact Info 6', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_contact_info', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_info_title', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_title', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_title', 'noize_use_info_title', 'true' );

    $shortcode->add_dependecy( 'noize_use_info_address_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_address_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_address_name', 'noize_use_info_address_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_info_tel_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_tel_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_tel_name', 'noize_use_info_tel_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_info_hour_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_hour_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_hour_name', 'noize_use_info_hour_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_info_email_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_email_name', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_text_info_email_name', 'noize_use_info_email_name', 'true' );
    
    $shortcode->add_params( [
        'noize_contact_info'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Contact Info', 'noize' ),
            'params'  => [
                'noize_image'     => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'noize' ),
                ],
                'noize_title' => [
                    'type'        => 'text',
                    'heading'     => esc_html__( 'Title', 'noize' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Add some text for title name', 'noize' ),
                ],
                'noize_info_address'     => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Address', 'noize' ),
                ],
                'noize_info_telephone'       => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Phone', 'noize' ),
                ],
                'noize_info_hour'       => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Hour', 'noize' ),
                ],
                'noize_info_email'       => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Email', 'noize' ),
                ],
            ]
        ],
        'noize_use_info_title'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for title?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_info_title'   => [
            'type'     => 'typography',
            'group'    => 'Noize Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],

            'selector' => '{{WRAPPER}} .aheto-contact-info__title',
        ],
        'noize_use_info_address_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for address?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_info_address_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Address Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],

            'selector' => '{{WRAPPER}} .aheto-contact-info__address',
        ],
        'noize_use_info_tel_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for phone?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_info_tel_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Phone Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact-info__telephone',
        ],
        'noize_use_info_hour_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for hour?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_info_hour_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Hour Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact-info__hour',
        ],
        'noize_use_info_email_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for email?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_info_email_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Email Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact-info__email',
        ],
    ] );
}

function noize_contact_info_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_info_title'] ) && ! empty( $shortcode->atts['noize_text_info_title'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact-info__title'], $shortcode->parse_typography( $shortcode->atts['noize_text_info_title'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_info_address_name'] ) && ! empty( $shortcode->atts['noize_text_info_address_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact-info__address'], $shortcode->parse_typography( $shortcode->atts['noize_text_info_address_name'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_info_tel_name'] ) && ! empty( $shortcode->atts['noize_text_info_tel_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact-info__telephone'], $shortcode->parse_typography( $shortcode->atts['noize_text_info_tel_name'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_info_hour_name'] ) && ! empty( $shortcode->atts['noize_text_info_hour_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact-info__hour'], $shortcode->parse_typography( $shortcode->atts['noize_text_info_hour_name'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_info_email_name'] ) && ! empty( $shortcode->atts['noize_text_info_email_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact-info__email'], $shortcode->parse_typography( $shortcode->atts['noize_text_info_email_name'] ) );
    }

    return $css;
}

add_filter( 'aheto_contact_info_dynamic_css', 'noize_contact_info_layout1_dynamic_css', 10, 2 );