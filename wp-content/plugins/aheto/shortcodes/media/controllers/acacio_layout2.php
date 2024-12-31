<?php

	use Aheto\Helper;
	add_action( 'aheto_before_aheto_media_register', 'acacio_media_layout2' );


	/**
	 * Media Shortcode
	 */

	function acacio_media_layout2( $shortcode ) {

		$preview_dir = '//assets.aheto.co/media/previews/';

		$shortcode->add_layout( 'acacio_layout2', [
			'title' => esc_html__( 'Media 2', 'acacio' ),
			'image' => $preview_dir . 'acacio_layout2.jpg',
		] );

		$shortcode->add_dependecy( 'acacio_video_slider', 'template', 'acacio_layout2' );
		$shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout2' );

		$shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout2' );
		$shortcode->add_dependecy( 'acacio_bullet_color', 'acacio_use_bullets_color', 'true' );

		$shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout2' );
		$shortcode->add_dependecy( 'acacio_bullet_color_active', 'acacio_use_bullets_color', 'true' );


		$shortcode->add_dependecy( 'acacio_image', 'template', 'acacio_layout3' );

		$shortcode->add_params([
			'acacio_video_slider' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Acacio Video Slider', 'acacio' ),
				'params'  => [
					'acacio_video_image'         => [
						'type'    => 'attach_image',
						'heading' => esc_html__( 'Image', 'acacio' ),
					],
				]
			],
			'acacio_hide_pagination'    => [
				'type'      => 'switch',
				'heading'   => esc_html__('Hide swiper pagination on desktop?', 'acacio'),
				'grid'      => 4,
			],
			'acacio_use_bullets_color'    => [
				'type'      => 'switch',
				'heading'   => esc_html__('Add your colors for swiper bullets?', 'acacio'),
				'grid'      => 4,
			],
			'acacio_bullet_color' => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Swiper bullet color', 'acacio' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
			],
			'acacio_bullet_color_active' => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Swiper bullet active color', 'acacio' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
			],

		]);

		\Aheto\Params::add_video_button_params( $shortcode, [
			'add_label' => esc_html__( 'Add video?', 'acacio' ),
			'prefix'    => 'acacio_',
			'group'     => esc_html__( 'Video Content', 'acacio' ),
		], 'acacio_video_slider' );

		\Aheto\Params::add_carousel_params( $shortcode, [
			'custom_options' => true,
			'prefix'         => 'acacio_swiper_',
			'include'        => [ 'effect', 'speed', 'loop', 'autoplay','lazy', 'slides', 'pagination', 'simulate_touch' ],
			'dependency'     => [ 'template', [ 'acacio_layout2' ] ]
		] );
		\Aheto\Params::add_image_sizer_params($shortcode, [
			'group'      => esc_html__( 'Images size for images ', 'acacio' ),
			'prefix'     => 'acacio_',
			'dependency' => ['template', ['acacio_layout2'] ]
		]);

	}

	function acacio_media_layout2_dynamic_css( $css, $shortcode ) {

		if ( ! empty( $shortcode->atts['acacio_bullet_color'] ) ) {
			$color                                             = Sanitize::color( $shortcode->atts['acacio_bullet_color'] );
			$css['global']['%1$s .swiper-pagination-bullet']['background'] = $color;
		}

		if ( ! empty( $shortcode->atts['acacio_bullet_color_active'] ) ) {
			$color                                             = Sanitize::color( $shortcode->atts['acacio_bullet_color_active'] );
			$css['global']['%1$s .swiper-pagination-bullet-active']['background'] = $color;
		}

		return $css;
	}

	add_filter( 'aheto_media_dynamic_css', 'acacio_media_layout2_dynamic_css', 10, 2 );
