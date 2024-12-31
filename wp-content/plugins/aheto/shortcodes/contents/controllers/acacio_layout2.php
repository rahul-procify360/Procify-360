<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'acacio_contents_layout2' );


/**
 * Contents
 */

function acacio_contents_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Content 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

    $shortcode->add_dependecy( 'acacio_creative_items', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_creative_version', 'template', 'acacio_layout2' );

    $shortcode->add_dependecy( 'acacio_use_descr_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_descr_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_descr_typo', 'acacio_use_descr_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_title_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'acacio_use_title_typo', 'true' );


    $shortcode->add_params( [
        'acacio_creative_items'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Slides', 'acacio' ),
            'params'  => [
                'acacio_item_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'acacio' ),
                ],
                'acacio_item_title'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'acacio' ),
                ],
                'acacio_item_use_dot'       => [
                    'type'    => 'switch',
                    'heading' => esc_html__( 'Use dot at the end of the title?', 'acacio' ),
                    'grid'    => 12,
                ],
                'acacio_item_dot_color'     => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Color for dot', 'acacio' ),
                    'options' => [
                        'primary' => esc_html__( 'Primary', 'acacio' ),
                        'dark'    => esc_html__( 'Dark', 'acacio' ),
                        'white'   => esc_html__( 'White', 'acacio' ),
                    ],
                    'default' => 'primary',
                ],
                'acacio_item_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'acacio' ),
                ],
                'acacio_item_btn_direction' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Buttons Direction', 'acacio' ),
                    'options' => [
                        ''            => esc_html__( 'Horizontal', 'acacio' ),
                        'is-vertical' => esc_html__( 'Vertical', 'acacio' ),
                    ],
                ],
            ]
        ],
        'acacio_creative_version' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable creative version?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_use_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__desc',
        ],
        'acacio_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for title?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__title',
        ],

    ] );
    

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
        'icons'  => true,
    ], 'acacio_creative_items' );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label' => esc_html__( 'Add additional button?', 'acacio' ),
        'prefix'    => 'acacio_add_',
        'icons'     => true,
    ], 'acacio_creative_items' );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout2' ] ]
    ] );
    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for contents ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout2'] ]
    ]);

}

function acacio_contents_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_descr_typo'] ) && ! empty( $shortcode->atts['acacio_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__desc'], $shortcode->parse_typography( $shortcode->atts['acacio_descr_typo'] ) );
    }

    if (isset( $shortcode->atts['acacio_use_title_typo'] ) && $shortcode->atts['acacio_use_title_typo'] && isset($shortcode->atts['acacio_title_typo']) && ! empty( $shortcode->atts['acacio_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography( $shortcode->atts['acacio_title_typo'] ) );
	}

    return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'acacio_contents_layout2_dynamic_css', 10, 2 );


