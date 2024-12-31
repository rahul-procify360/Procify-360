<?php

use Aheto\Helper;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Settings;

add_action( 'aheto_before_aheto_contacts_register', 'prego_contacts_layout1' );



/**
 * Contacts
 */

function prego_contacts_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'prego_layout1', [
		'title' => esc_html__( 'Prego Contacts', 'prego' ),
		'image' => $preview_dir . 'prego_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'prego_items', 'template', 'prego_layout1' );
	$shortcode->add_dependecy( 'prego_heading', 'template', 'prego_layout1' );
	$shortcode->add_dependecy( 'prego_api_key_notification', 'template', 'prego_layout1' );

    if ( Plugin::$instance->editor->is_edit_mode() ) {
        $api_key = get_option( 'elementor_google_maps_api_key' );

        if ( ! $api_key ) {
            $shortcode->add_params( [
                'prego_api_key_notification' =>  [
                    'type' => 'raw_html',
                    'raw' => sprintf(
                    /* translators: 1: Integration settings link open tag, 2: Create API key link open tag, 3: Link close tag. */
                        esc_html__( 'Set your Google Maps API Key in Elementor\'s %1$sIntegrations Settings%3$s page. Create your key %2$shere.%3$s', 'prego' ),
                        '<a href="' . Settings::get_url() . '#tab-integrations" target="_blank">',
                        '<a href="https://developers.google.com/maps/documentation/embed/get-api-key" target="_blank">',
                        '</a>'
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            ]);
        }
    }

	$shortcode->add_params( [
        'prego_heading'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Heading', 'prego' ),
        ],
        'prego_items' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Items', 'prego' ),
            'params'  => [
                'prego_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Tab Main Icon', 'prego' ),
                ],
                'prego_main_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Tab Main Title', 'prego' ),
                ],
                'prego_main_address'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Tab Main Address', 'prego' ),
                    'admin_label' => true,
                ],
                'prego_office_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Tab Main Icon', 'prego' ),
                ],
                'prego_office_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Tab Office Title', 'prego' ),
                ],
                'prego_office_address'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Tab Office Address', 'prego' ),
                    'admin_label' => true,
                ],
                'prego_schedule_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Tab Main Icon', 'prego' ),
                ],
                'prego_schedule_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Tab Schedule Title', 'prego' ),
                ],
                'prego_schedule'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Tab Schedule', 'prego' ),
                    'admin_label' => true,
                ],
                'prego_phone_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Tab Main Icon', 'prego' ),
                ],
                'prego_phone_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Tab Phone Title', 'prego' ),
                ],
                'prego_phone'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Tab Phone', 'prego' ),
                    'admin_label' => true,
                ],
                'prego_zoom' => [
                    'label' => esc_html__( 'Map Zoom', 'prego' ),
                    'type' => 'slider',
                    'default' => [
                        'size' => 10,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                        ],
                    ],
                    'separator' => 'before',
                ]
            ]
        ],

	] );

}
