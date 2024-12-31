<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'mooseoom_banner_slider_layout2' );

/**
 *  Banner Slider
 */

function mooseoom_banner_slider_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'mooseoom_layout2', [
		'title' => esc_html__( 'Banner Slider 15', 'aheto' ),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	] );


	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'mooseoom_layout2' ], $shortcode );

	$shortcode->add_dependecy('mooseoom_banner_theme', 'template', 'mooseoom_layout2');

	$shortcode->add_dependecy('mooseoom_modern_banners', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_banner_theme', 'template', 'mooseoom_layout2');

	$shortcode->add_dependecy('mooseoom_use_subtitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'mooseoom_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_desc_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_desc_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_desc_typo', 'mooseoom_use_desc_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_arrows_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_arrows_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_arrows_text_typo', 'mooseoom_use_arrows_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_fontarrov_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_text_typo', 'mooseoom_use_fontarrov_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_fontarrov_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_fontarrov_typo', 'mooseoom_use_fontarrov_typo', 'true');

	$shortcode->add_params( [
		'mooseoom_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'aheto'),
			'params'  => [
				'mooseoom_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'aheto'),
				],
				'mooseoom_title'         => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'aheto'),
				],
				'mooseoom_sub_title' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Subtitle', 'aheto'),
				],
				'mooseoom_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'aheto'),
				],
				'mooseoom_align'             => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'aheto'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'mooseoom_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'aheto'),
					'options' => [
						''            => esc_html__('Horizontal', 'aheto'),
						'is-vertical' => esc_html__('Vertical', 'aheto'),
					],
				],
			]
		],
		'mooseoom_use_fontarrov_typo' => [
			'type'    => 'switch',
			'group'    => 'Slider Options',
			'heading' => esc_html__( 'Use custom font for arrows?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_fontarrov_typo'        => [
			'type'     => 'typography',
			'group'    => 'Slider Options',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.swiper-button-prev, {{WRAPPER}} div.swiper-button-next',
		],
		'mooseoom_banner_theme'         => [
			'type'    => 'select',
			'heading' => esc_html__('Banner theme', 'aheto'),
			'options' => [
				''            => esc_html__('Light', 'aheto'),
				'banner-dark' => esc_html__('Dark', 'aheto'),
			],
		],
		'mooseoom_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_subtitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__sub-title',
		],
		'mooseoom_use_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_desc_typo'        => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
		'mooseoom_use_arrows_text_typo' => [
			'type'    => 'switch',
			'group'    => 'Slider Options',
			'heading' => esc_html__( 'Use custom font for arrows text?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_arrows_text_typo'        => [
			'type'     => 'typography',
			'group'    => 'Slider Options',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.swiper-button-prev span, {{WRAPPER}} div.swiper-button-next span',
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'mooseoom_main_',
	], 'mooseoom_modern_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'aheto'),
		'prefix'    => 'mooseoom_add_',
	], 'mooseoom_modern_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'mooseoom_swiper_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch','arrows', 'arrows_color', 'arrows_size'],
		'dependency'     => ['template', ['mooseoom_layout2']]
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Additional image size', 'aheto'),
		'prefix'     => 'mooseoom_',
		'dependency' => ['template', ['mooseoom_layout2']]
	]);

}

function mooseoom_banner_slider_layout2_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['mooseoom_use_fontarrov_typo']) && !empty($shortcode->atts['mooseoom_fontarrov_typo']) ) {
		\aheto_add_props($css['global']['%1$s .div.swiper-button-prev, %1$s .div.swiper-button-next'], $shortcode->parse_typography($shortcode->atts['mooseoom_fontarrov_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_subtitle_typo']) && !empty($shortcode->atts['mooseoom_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__sub-title'], $shortcode->parse_typography($shortcode->atts['mooseoom_subtitle_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_desc_typo']) && !empty($shortcode->atts['mooseoom_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['mooseoom_desc_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_arrows_text_typo']) && !empty($shortcode->atts['mooseoom_arrows_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s div.swiper-button-prev span, %1$s div.swiper-button-next span'], $shortcode->parse_typography($shortcode->atts['mooseoom_arrows_text_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['mooseoom_arrows_color']);
	}

	if ( !empty($shortcode->atts['mooseoom_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['mooseoom_arrows_size'] );
    }
	if ( ! empty($shortcode->atts['mooseoom_arrows_num_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .swiper-button-next span, %1$s .swiper-button-prev span'], $shortcode->parse_typography( $shortcode->atts['mooseoom_arrows_num_typo'] ) );
    }



	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'mooseoom_banner_slider_layout2_dynamic_css', 10, 2);
