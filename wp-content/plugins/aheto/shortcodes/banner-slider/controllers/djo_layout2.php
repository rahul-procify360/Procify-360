<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'djo_banner_slider_layout2');

/**
 * Features Banner Slider
 */

function djo_banner_slider_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('djo_layout2', [
		'title' => esc_html__('Banner Slider 6', 'aheto'),
		'image' => $preview_dir . 'djo_layout2.jpg',
	]);
	aheto_demos_add_dependency(['use_heading', 't_heading'], ['djo_layout2'], $shortcode);

	$shortcode->add_dependecy('djo_overlay_color', 'djo_overlay', 'true');
	$shortcode->add_dependecy('djo_subtitle_use_typo', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_subtitle_typo', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_subtitle_typo', 'djo_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('djo_djo_video_banners', 'template', 'djo_layout2');

	$shortcode->add_params([
		'djo_djo_video_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'aheto'),
			'params'  => [
				'djo_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'aheto'),
				],
				'djo_overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__('Enable overlay for background image?', 'aheto'),
					'grid'    => 12,
				],
				'djo_overlay_color' => [
					'type'    => 'colorpicker',
					'heading' => esc_html__('Overlay Color', 'aheto'),
					'grid'    => 12,
					'default' => ''
				],
				'djo_title'         => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'aheto'),
				],
				'djo_desc'          => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'aheto'),
				],
				'djo_align' => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'aheto'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'djo_title_tag'   => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'aheto'),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'h1',
					'grid'    => 5,
				],
			]
		],
		'djo_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'aheto'),
			'grid'    => 3,
		],
		'djo_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'djo_swiper_',
		'include'        => ['effect', 'arrows', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
		'dependency'     => ['template', ['djo_layout2']]
	]);
	\Aheto\Params::add_video_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add video?', 'aheto' ),
		'prefix'    => 'djo_',
		'group'     => esc_html__( 'Video Content', 'aheto' ),
	], 'djo_djo_video_banners' );
}

function djo_banner_slider_layout2_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['djo_subtitle_use_typo']) && $shortcode->atts['djo_subtitle_use_typo'] &&  isset($shortcode->atts['djo_subtitle_typo']) &&  !empty($shortcode->atts['djo_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['djo_subtitle_typo']));
	}

	return $css;
}
add_filter('aheto_banner_slider_dynamic_css', 'djo_banner_slider_layout2_dynamic_css', 10, 2);
