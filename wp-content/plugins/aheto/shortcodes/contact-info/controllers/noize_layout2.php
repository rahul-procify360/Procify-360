<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-info_register', 'noize_contact_info_layout2' );

/**
 * Contact info Shortcode
 */
function noize_contact_info_layout2( $shortcode ) {
    $preview_dir = '//assets.aheto.co/contact-info/previews/';

    $shortcode->add_layout( 'noize_layout2', [
        'title' => esc_html__( 'Contact Info 7', 'noize' ),
        'image' => $preview_dir . 'noize_layout2.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_address', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_phone', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_email', 'template', 'noize_layout2' );

    $shortcode->add_dependecy( 'noize_use_typo_address_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_address_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_address_name', 'noize_use_typo_address_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_tel_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_tel_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_tel_name', 'noize_use_typo_tel_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_email_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_email_name', 'template', [ 'noize_layout2' ] );
    $shortcode->add_dependecy( 'noize_text_typo_email_name', 'noize_use_typo_email_name', 'true' );

    $shortcode->add_params( [
        'noize_address'     => [
            'type'    => 'text',
            'heading' => esc_html__( 'Address', 'noize' ),
        ],
        'noize_phone'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Phone', 'noize' ),
        ],
        'noize_email'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Email', 'noize' ),
        ],
        'noize_use_typo_address_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for address?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_address_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Address Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-ci--noize-lay2--link-address',
        ],
        'noize_use_typo_tel_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for phone?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_tel_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Phone Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-ci--noize-lay2--link-tel',
        ],
        'noize_use_typo_email_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for email?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_email_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Email Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-ci--noize-lay2--link-email',
        ],
    ] );
    
}

function noize_contact_info_layout2_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_address_name'] ) && ! empty( $shortcode->atts['noize_text_typo_address_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-ci--noize-lay2--link-address'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_address_name'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_typo_tel_name'] ) && ! empty( $shortcode->atts['noize_text_typo_tel_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-ci--noize-lay2--link-tel'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_tel_name'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_typo_email_name'] ) && ! empty( $shortcode->atts['noize_text_typo_email_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-ci--noize-lay2--link-email'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_email_name'] ) );
    }

    return $css;
}

add_filter( 'aheto_contact_info_dynamic_css', 'noize_contact_info_layout2_dynamic_css', 10, 2 );