<?php


use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'outsourceo_banner_slider_layout1' );

function outsourceo_banner_slider_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Banner Slider 20', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_modern_banners', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_overlay_color', 'outsourceo_overlay', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_descr_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_descr_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_descr_typo', 'outsourceo_use_descr_typo', 'true' );


	$shortcode->add_params( [
		'outsourceo_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'outsourceo' ),
			'params'  => [
				'image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'outsourceo' ),
				],
				'add_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Additional Image', 'outsourceo' ),
				],
				'overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Enable overlay for background image?', 'outsourceo' ),
					'grid'    => 12,
				],
				'overlay_color' => [
					'type'    => 'colorpicker',
					'heading' => esc_html__( 'Overlay Color', 'outsourceo' ),
					'grid'    => 12,
					'default' => ''
				],
				'title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'outsourceo' ),
				],
				'use_dot'       => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot in the end title?', 'outsourceo' ),
					'grid'    => 12,
				],
				'desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'outsourceo' ),
				],
				'align' => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'outsourceo'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'outsourceo' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'outsourceo' ),
						'is-vertical' => esc_html__( 'Vertical', 'outsourceo' ),
					],
				],
			]
		],
		'outsourceo_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Description?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Description Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_main_',
		'add_button' => true,
	], 'outsourceo_modern_banners' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'outsourceo_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'arrows_style', 'lazy', 'arrows_size' ],
		'dependency'     => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );
	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'group'      => esc_html__( 'Images size for additional image', 'outsourceo' ),
		'prefix'     => 'outsourceo_add_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

}

function outsourceo_banner_slider_layout1_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_descr_typo'] ) && ! empty( $shortcode->atts['outsourceo_descr_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography( $shortcode->atts['outsourceo_descr_typo'] ) );
	}

	if ( !empty($shortcode->atts['outsourceo_swiper_arrows_size']) ) {
		$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['outsourceo_swiper_arrows_size'] );
	}

	return $css;
}


add_filter( 'aheto_banner_slider_dynamic_css', 'outsourceo_banner_slider_layout1_shortcode_dynamic_css', 10, 2 );

function outsourceo_banner_slider_layout1_carousel( $carousel_params ) {

	$carousel_params['include'][] = 'pagination';

	return $carousel_params;

}

add_filter( 'aheto_banner_slider_carousel', 'outsourceo_banner_slider_layout1_carousel', 10, 2 );
