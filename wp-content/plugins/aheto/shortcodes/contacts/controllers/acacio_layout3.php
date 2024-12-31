<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'acacio_contacts_layout3' );



/**
 * Contacts
 */

function acacio_contacts_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'acacio_layout3', [
		'title' => esc_html__( 'Contacts 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout3.jpg',
	] );

    $shortcode->add_dependecy( 'acacio_contacts_group', 'template', ['acacio_layout3'] );
    $shortcode->add_dependecy( 'acacio_dark_style', 'template', 'acacio_layout3' );
	aheto_demos_add_dependency(['use_heading', 't_heading', 't_content', 'use_content'], ['acacio_layout3'], $shortcode);


    $shortcode->add_params( [
        'acacio_dark_style' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable dark style for swiper buttons?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_contacts_group' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Contacts', 'acacio' ),
            'params'  => [
                'acacio_heading_tag' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for heading', 'acacio' ),
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
        ]

    ] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_contacts_',
        'include'        => [ 'arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout3' ] ]
    ] );
}