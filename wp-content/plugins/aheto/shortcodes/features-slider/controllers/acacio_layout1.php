<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-slider_register', 'acacio_features_slider_layout1' );

/**
 * Features Slider
 */

function acacio_features_slider_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Features Slider 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_description', 't_description'], [ 'acacio_layout1'], $shortcode );

    $shortcode->add_dependecy( 'acacio_background_color', 'acacio_background_type', 'color' );
    $shortcode->add_dependecy( 'acacio_bg_image', 'acacio_background_type', 'image' );
    $shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_add_image', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_features_slider', 'template', 'acacio_layout1' );

    $shortcode->add_params( [
        'acacio_features_slider' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Features', 'acacio' ),
            'params'  => [
                'acacio_background_type' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Slider background type', 'acacio' ),
                    'options' => [
                        'color' => esc_html__( 'Color', 'acacio' ),
                        'image' => esc_html__( 'Image', 'acacio' ),
                    ],
                    'default' => 'color',
                ],
                'acacio_background_color' => [
                    'type'      => 'colorpicker',
                    'heading'   => esc_html__( 'Shape background color', 'acacio' ),
                    'grid'      => 6,
                    'selectors' => [ '{{WRAPPER}} .aheto-features-slider-image-wrap' => 'background: {{VALUE}}' ],
                ],
                'acacio_bg_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'acacio' ),
                ],
                'acacio_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'acacio' ),
                ],


                'acacio_title'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Title', 'acacio' ),
                    'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'acacio' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Heading with [[ hightlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'acacio' ),
                ],
                'acacio_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'acacio' ),
                ],
            ]
        ],
        'acacio_hide_pagination'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Hide swiper pagination on desktop?', 'acacio'),
            'grid'      => 4,
        ],
        'acacio_add_image'         => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Additional Image', 'acacio' ),
        ],
    ] );


    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'include'        => ['arrows', 'pagination', 'delay', 'speed', 'loop', 'lazy', 'simulate_touch'],
        'prefix' => 'acacio_',
        'dependency' => ['template', ['acacio_layout1']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'acacio_button_',
        'depedency' => ['template', ['acacio_layout1']]
    ], 'acacio_features_slider');

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for team photos ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);
}
