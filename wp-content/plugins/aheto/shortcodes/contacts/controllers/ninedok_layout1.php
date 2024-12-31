<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'ninedok_contacts_layout1');


/**
 * Contacts
 */

function ninedok_contacts_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/contacts/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Contacts 14', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout1.jpg',
    ]);

    $shortcode->add_dependecy('ninedok_contacts_group', 'template', ['ninedok_layout1']);


    $shortcode->add_params([
        'ninedok_contacts_group' => [
            'type' => 'group',
            'heading' => esc_html__('9dok Contacts', 'ninedok'),
            'params' => [
                'ninedok_heading_tag' => [
                    'type' => 'select',
                    'heading' => esc_html__('Element tag for Heading', 'ninedok'),
                    'options' => [
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                        'p' => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h4',
                    'grid' => 5,
                ],
                'ninedok_heading' => [
                    'type' => 'text',
                    'heading' => esc_html__('Heading', 'ninedok'),
                ],
                'ninedok_address' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Address', 'ninedok'),
                ],
                'ninedok_phone' => [
                    'type' => 'text',
                    'heading' => esc_html__('Phone', 'ninedok'),
                ],
                'ninedok_email' => [
                    'type' => 'text',
                    'heading' => esc_html__('Email', 'ninedok'),
                ]
            ]
        ],
    ]);


    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'ninedok_contacts_',
        'include' => ['arrows', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
        'dependency' => ['template', ['ninedok_layout1']]
    ]);
}