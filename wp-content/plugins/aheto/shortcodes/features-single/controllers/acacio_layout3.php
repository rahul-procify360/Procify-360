<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout3' );

/**
 * Features Single
 */

function acacio_features_single_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'acacio_layout3', [
		'title' => esc_html__( 'Features Single 3', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout3.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], [ 'acacio_layout3'], $shortcode );

    //	Acacio Simple Scaled Items
    $shortcode->add_dependecy( 'acacio_features_modern_vertical', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_title', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_description', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_content_orientation', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_use_img_height', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_active', 'template', 'acacio_layout3');
    $shortcode->add_dependecy( 'acacio_img_height', 'acacio_use_img_height', 'true' );
    
    
    $shortcode->add_params( [
        'acacio_title' => [
            'type'     => 'text',
            'heading' => esc_html__( 'Add your title', 'acacio' ),
            'grid' =>  1
        ],
        'acacio_description' => [
            'type'     => 'textarea',
            'heading' => esc_html__( 'Add your description', 'acacio' ),
            'grid' => 3
        ],
        'acacio_content_orientation' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Content orientation', 'acacio' ),
            'options' => [
                ''            => esc_html__( 'Line', 'acacio' ),
                'column' => esc_html__( 'Column', 'acacio' ),
            ],
        ],
        'acacio_active'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Mark as active?', 'acacio' ),
            'grid'    => 12,
        ],
        'acacio_features_modern_vertical' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Features Modern (Vertical)', 'acacio' ),
            'params'  => [
                'acacio_features_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'acacio' ),
                ],
                'acacio_features_counter_bg'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Add your background image for numbers', 'acacio' ),
                ],
                'acacio_features_title_image' => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Add your title image ', 'acacio' ),
                ],
                'acacio_features_title'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Title', 'acacio' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Title', 'acacio' ),
                ],
                'acacio_features_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'acacio' ),
                ],
            ]
        ],
        'acacio_use_img_height' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Set image height?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_img_height'    => [
            'type'      => 'slider',
            'heading'   => esc_html__('Image height', 'acacio'),
            'grid'      => 4,
            'size_units' => [ 'px', '%', 'vh' ],
            'range'     => [
                'px' => [
                    'min'  => 200,
                    'max'  => 2000,
                    'step' => 5,
                ],
                '%' => [
                    'min'  => 0,
                    'max'  => 100,
                ],
                'vh' => [
                    'min'  => 0,
                    'max'  => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .aheto-features-block__image ' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ],
    ] );
    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
        'dependency' => ['template', ['acacio_layout3'] ]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', ['acacio_layout3'] ]
    ]);

}
