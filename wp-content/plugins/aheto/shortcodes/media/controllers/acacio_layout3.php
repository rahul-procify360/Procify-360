<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_media_register', 'acacio_media_layout3' );


/**
 * Media Shortcode
 */

function acacio_media_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'acacio_layout3', [
		'title' => esc_html__( 'Media 3', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout3.jpg',
	] );

    $shortcode->add_dependecy( 'acacio_image', 'template', 'acacio_layout3' );

    $shortcode->add_params([
        'acacio_image'     => [
            'type'    => 'attach_image',
            'heading' => esc_html__('Add image', 'acacio'),
        ],
    ]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Images size for images ', 'acacio' ),
		'prefix'     => 'acacio_',
		'dependency' => ['template', ['acacio_layout3'] ]
	]);

}


