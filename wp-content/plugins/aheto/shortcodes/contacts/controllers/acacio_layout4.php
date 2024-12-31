<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'acacio_contacts_layout4' );



/**
 * Contacts
 */

function acacio_contacts_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'acacio_layout4', [
		'title' => esc_html__( 'Contacts 3', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'acacio_contacts_group', 'template', ['acacio_layout4'] );
	$shortcode->add_dependecy( 'acacio_light_version', 'template', ['acacio_layout4'] );
	$shortcode->add_dependecy( 'acacio_content_typo', 'template',  'acacio_layout4');
	$shortcode->add_dependecy( 'acacio_use_content_typo', 'template',  'acacio_layout4');
	$shortcode->add_dependecy( 'acacio_content_typo', 'template', 'acacio_layout4' );
	$shortcode->add_dependecy( 'acacio_content_typo', 'acacio_use_content_typo', 'true' );
    $shortcode->add_params( [
        'acacio_light_version' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable light version?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_contacts_group' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Contacts', 'acacio' ),
            'params'  => [
                'acacio_heading_tag' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for Heading', 'acacio' ),
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
                    'default' => 'h4',
                    'grid'    => 5,
                ],
                'acacio_heading' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Heading', 'acacio' ),
                ],
                'acacio_address' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Address', 'acacio' ),
                ],
                'acacio_phone'   => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Phone', 'acacio' ),
                ],

                'acacio_email' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Email', 'acacio' ),
                ],
            ]
        ],
        'acacio_use_content_typo'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Use contacts typography?', 'acacio'),
            'grid'      => 4,
        ],
        'acacio_content_typo' => [
            'type'     => 'typography',
            'group'    => 'Contacts Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact p,{{WRAPPER}} .aheto-contact__mail,{{WRAPPER}} .aheto-contact__tel,{{WRAPPER}} .aheto-contact__info',
        ],

    ] );
    
}

function acacio_contacts_layout4_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_content_typo'] ) && ! empty( $shortcode->atts['acacio_content_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact p, %1$s .aheto-contact__mail, %1$s .aheto-contact__tel, %1$s .aheto-contact__info'], $shortcode->parse_typography( $shortcode->atts['acacio_content_typo'] ) );
    }
    

    return $css;
}

add_filter( 'aheto_contacts_dynamic_css', 'acacio_contacts_layout4_dynamic_css', 10, 2 );