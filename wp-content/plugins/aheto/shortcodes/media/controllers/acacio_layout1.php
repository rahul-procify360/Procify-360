<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_media_register', 'acacio_media_layout1' );


/**
 * Media Shortcode
 */

function acacio_media_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Media 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );


    $shortcode->add_dependecy( 'acacio_image', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_max_width_hide', 'template', 'acacio_layout1' );


    $shortcode->add_params([
        'acacio_image'     => [
            'type'    => 'attach_image',
            'heading' => esc_html__('Add image', 'acacio'),
        ],
        'acacio_max_width_hide'          => [
            'type'      => 'slider',
            'heading'   => esc_html__('Hide image on width', 'acacio'),
            'grid'      => 12,
            'range'     => [
                'px' => [
                    'min'  => 0,
                    'max'  => 3000,
                    'step' => 1,
                ],
            ],
        ],


    ]);


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);

}
