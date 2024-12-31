<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-timeline_register', 'outsourceo_features_timeline_layout1' );

/**
 * Features Timeline Shortcode
 */

function outsourceo_features_timeline_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/features-timeline/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Features Timeline 5', 'outsourceo' ),
		'image' => $dir . 'acacio_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_timeline', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_dark_version', 'template', 'outsourceo_layout1' );


	$shortcode->add_params( [
		'outsourceo_timeline' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Items', 'outsourceo' ),
			'params'  => [
				'outsourceo_timeline_date'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Date', 'outsourceo' ),
				],
				'outsourceo_timeline_title'   => [
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Title', 'outsourceo' ),
					'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'outsourceo' ),
					'default'     => esc_html__( 'Title with [[ hightlight ]] text.', 'outsourceo' ),
				],
				'outsourceo_use_dot'          => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot at the end of the title?', 'outsourceo' ),
					'grid'    => 12,
				],
				'outsourceo_dot_color'        => [
					'type'    => 'select',
					'heading' => esc_html__( 'Color for dot', 'outsourceo' ),
					'options' => [
						'primary' => esc_html__( 'Primary', 'outsourceo' ),
						'dark'    => esc_html__( 'Dark', 'outsourceo' ),
						'white'   => esc_html__( 'White', 'outsourceo' ),
					],
					'default' => 'primary',
				],
				'outsourceo_timeline_content' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Content', 'outsourceo' ),
					'default' => esc_html__( 'Add some text for content', 'outsourceo' ),
				],
				'outsourceo_timeline_image'   => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Add image', 'outsourceo' ),
				],
			],
		],

		'outsourceo_dark_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark version?', 'outsourceo' ),
			'grid'    => 3,
		],


	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'icons'      => true,
		'add_button' => true,
	], 'outsourceo_timeline' );


	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );


}