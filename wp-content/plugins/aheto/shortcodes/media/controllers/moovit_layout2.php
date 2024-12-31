<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_media_register', 'moovit_media_layout2' );


/**
 * Media Shortcode
 */

function moovit_media_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Media 17', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_responsive_image', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_max_width_hide', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_align', 'template', 'moovit_layout2' );


	$shortcode->add_params( [

		'moovit_responsive_image'     => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Add image', 'moovit'),
		],
		'moovit_max_width_hide'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Hide image on width', 'moovit'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 1,
				],
			],
		],
		'moovit_align'             => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align', 'outsourceo' ),
			'options' => \Aheto\Helper::choices_alignment(),
		],

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout2'] ]
	]);
}
