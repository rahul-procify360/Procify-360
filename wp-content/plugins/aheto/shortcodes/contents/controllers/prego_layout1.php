<?php

use Aheto\Helper;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Settings;

add_action( 'aheto_before_aheto_contents_register', 'prego_contents_layout1' );



/**
 * Contacts
 */

function prego_contents_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/contents/previews/';

    $shortcode->add_layout( 'prego_layout1', [
        'title' => esc_html__( 'Prego Contents', 'prego' ),
        'image' => $preview_dir . 'prego_layout1.jpg',
    ] );


    $shortcode->add_dependecy( 'prego_subheading', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_heading', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_image', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_items', 'template', 'prego_layout1' );

    $shortcode->add_dependecy('prego_use_title_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_title_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_title_typo', 'prego_use_title_typo', 'true');

    $shortcode->add_dependecy('prego_use_subtitle_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_subtitle_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_subtitle_typo', 'prego_use_subtitle_typo', 'true');

    $shortcode->add_dependecy('prego_use_items_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_items_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_items_typo', 'prego_use_items_typo', 'true');

    $shortcode->add_params( [
        'prego_subheading'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Subheading', 'prego' ),
        ],
        'prego_heading'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Heading', 'prego' ),
        ],
        'prego_image'         => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Image', 'prego' ),
        ],
        'prego_items' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Items', 'prego' ),
            'params'  => [
                'prego_item_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'prego' ),
                ],
                'prego_item_text'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Text', 'prego' ),
                ],
                'prego_point_top'    => [
                    'type'      => 'slider',
                    'heading'   => esc_html__('Point position top', 'prego'),
                    'size_units' => [ '%' ],
                    'range'     => [
                        '%' => [
                            'min'  => 0,
                            'max'  => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.aheto-contents__point' => 'top: {{SIZE}}%;',
                    ],
                ],
                'prego_point_left'    => [
                    'type'      => 'slider',
                    'heading'   => esc_html__('Point position left', 'prego'),
                    'size_units' => [ '%' ],
                    'range'     => [
                        '%' => [
                            'min'  => 0,
                            'max'  => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.aheto-contents__point' => 'left: {{SIZE}}%;',
                    ],
                ],
            ]
        ],
        'prego_use_subtitle_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for subtitle?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_subtitle_typo' => [
            'type'     => 'typography',
            'group'    => 'Subtitle Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__content h6',
        ],
        'prego_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for title?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__content h2',
        ],
        'prego_use_items_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for items?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_items_typo' => [
            'type'     => 'typography',
            'group'    => 'Items Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__item',
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'         => 'prego_',
        'dependency' => ['template',  ['prego_layout1']]
    ]);

}
