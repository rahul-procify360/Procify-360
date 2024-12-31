<?php

use Aheto\Helper;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Settings;

add_action( 'aheto_before_aheto_contents_register', 'prego_contents_layout2' );



/**
 * Contacts
 */

function prego_contents_layout2( $shortcode ) {

    $preview_dir = '//assets.aheto.co/contents/previews/';

    $shortcode->add_layout( 'prego_layout2', [
        'title' => esc_html__( 'Prego Cards', 'prego' ),
        'image' => $preview_dir . 'prego_layout2.jpg',
    ] );


    $shortcode->add_dependecy( 'prego_items_cards', 'template', 'prego_layout2' );

    $shortcode->add_dependecy('prego_use_item_title_typo', 'template', 'prego_layout2');
    $shortcode->add_dependecy('prego_item_title_typo', 'template', 'prego_layout2');
    $shortcode->add_dependecy('prego_item_title_typo', 'prego_use_item_title_typo', 'true');

    $shortcode->add_dependecy('prego_use_item_text_typo', 'template', 'prego_layout2');
    $shortcode->add_dependecy('prego_item_text_typo', 'template', 'prego_layout2');
    $shortcode->add_dependecy('prego_item_text_typo', 'prego_use_item_text_typo', 'true');

    $shortcode->add_params( [
        'prego_items_cards' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Items', 'prego' ),
            'params'  => [
                'prego_item_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'prego' ),
                ],
                'prego_item_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'prego' ),
                ],
                'prego_item_text'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Text', 'prego' ),
                ],
            ]
        ],
        'prego_use_item_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for title?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_item_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__content h4',
        ],
        'prego_use_item_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for text?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_item_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__text',
        ],
    ] );

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'group'          => 'Prego Swiper',
        'include'        => ['loop', 'autoplay', 'speed', 'simulate_touch'],
        'prefix'         => 'prego_tm_swiper_',
        'dependency'     => ['template', ['prego_layout2']]
    ]);


}
