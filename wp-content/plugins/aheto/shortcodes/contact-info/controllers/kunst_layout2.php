<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-info_register', 'kunst_contact_info_layout2' );

/**
* Kunst Contact Info Shortcode
*/

function kunst_contact_info_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout( 'kunst_layout2', [
        'title' => esc_html__( 'Kunst Contact Info Single', 'kunst' ),
        'image' => $preview_dir . 'kunst_layout2.jpg',
    ]);

	aheto_demos_add_dependency( 'use_typo_text', [ 'kunst_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_address', 'template', [ 'kunst_layout2' ] );
    $shortcode->add_dependecy( 'kunst_phone', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_email', 'template', [ 'kunst_layout2' ] );

    $shortcode->add_dependecy( 'kunst_use_typo_address_name', 'template', [ 'kunst_layout2' ] );
    $shortcode->add_dependecy( 'kunst_text_typo_address_name', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_text_typo_address_name', 'kunst_use_typo_address_name', 'true' );

    $shortcode->add_dependecy( 'kunst_use_typo_tel_name', 'template', [ 'kunst_layout2' ] );
    $shortcode->add_dependecy( 'kunst_text_typo_tel_name', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_text_typo_tel_name', 'kunst_use_typo_tel_name', 'true' );

    $shortcode->add_dependecy( 'kunst_use_typo_email_name', 'template', [ 'kunst_layout2' ] );
    $shortcode->add_dependecy( 'kunst_text_typo_email_name', 'template', [ 'kunst_layout2' ] );
    $shortcode->add_dependecy( 'kunst_text_typo_email_name', 'kunst_use_typo_email_name', 'true' );

    $shortcode->add_params( [

        'kunst_address'     => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Address', 'kunst' ),
        ],
        'kunst_phone'       => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Phone', 'kunst' ),
        ],
        'kunst_email'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Email', 'kunst' ),
		],

        'kunst_use_typo_address_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Address Name?', 'kunst' ),
            'grid'    => 6,
        ],
        'kunst_text_typo_address_name'   => [
            'type'     => 'typography',
            'group'    => 'Address Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .widget_kunst--info__modern .widget_kunst--info__modern--link-address',
        ],

        'kunst_use_typo_tel_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Telephone Name?', 'kunst' ),
            'grid'    => 6,
        ],
        'kunst_text_typo_tel_name'   => [
            'type'     => 'typography',
            'group'    => 'Telephone Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .widget_kunst--info__modern .widget_kunst--info__modern--link-tel',
        ],

        'kunst_use_typo_email_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Email Name?', 'kunst' ),
            'grid'    => 6,
        ],
        'kunst_text_typo_email_name'   => [
            'type'     => 'typography',
            'group'    => 'Email Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .widget_kunst--info__modern .widget_kunst--info__modern--link-email, {{WRAPPER}} .widget_kunst--info__modern--content span',
        ],

	]);

}

function kunst_contact_info_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['kunst_use_typo_address_name'] ) && ! empty( $shortcode->atts['kunst_text_typo_address_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .widget_kunst--info__modern .widget_kunst--info__modern--link-address'], $shortcode->parse_typography( $shortcode->atts['kunst_text_typo_address_name'] ) );
    }

    if ( ! empty( $shortcode->atts['kunst_use_typo_tel_name'] ) && ! empty( $shortcode->atts['kunst_text_typo_tel_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .widget_kunst--info__modern .widget_kunst--info__modern--link-tel'], $shortcode->parse_typography( $shortcode->atts['kunst_text_typo_tel_name'] ) );
    }

    if ( ! empty( $shortcode->atts['kunst_use_typo_email_name'] ) && ! empty( $shortcode->atts['kunst_text_typo_email_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .widget_kunst--info__modern .widget_kunst--info__modern--link-email, %1$s .widget_kunst--info__modern--content span'], $shortcode->parse_typography( $shortcode->atts['kunst_text_typo_email_name'] ) );
    }

    return $css;

}

add_filter( 'aheto_dynamic_css_contact_info', 'kunst_contact_info_layout2_dynamic_css', 10, 2 );
