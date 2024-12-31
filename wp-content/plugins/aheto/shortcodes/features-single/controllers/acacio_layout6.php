<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout6' );

/**
 * Features Single
 */

function acacio_features_single_layout6( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'acacio_layout6', [
		'title' => esc_html__( 'Features Single 6', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout6.jpg',
	] );

	$shortcode->add_dependecy( 'acacio_features_modern_vertical', 'template', 'acacio_layout6' );

	$shortcode->add_params( [
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

	] );


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', ['acacio_layout6'] ]
    ]);
}