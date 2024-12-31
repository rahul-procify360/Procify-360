<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'sterling_banner_slider_layout1');

/**
 *  Banner Slider
 */

function sterling_banner_slider_layout1($shortcode) {
  
  $theme_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Banner Slider 28', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_modern_banners', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_overlay_color', 'sterling_overlay', 'true');
	$shortcode->add_dependecy('sterling_use_subtitle_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_subtitle_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_subtitle_typo', 'sterling_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('sterling_use_title_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_title_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_typo', 'sterling_use_title_typo', 'true');
	$shortcode->add_dependecy('sterling_use_desc_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_desc_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_desc_typo', 'sterling_use_desc_typo', 'true');
	$shortcode->add_params([
		'sterling_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'sterling'),
			'params'  => [
				'sterling_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'sterling'),
				],
				'sterling_overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__('Enable overlay for background image?', 'sterling'),
					'grid'    => 12,
				],
				'sterling_overlay_color' => [
					'type'    => 'colorpicker',
					'heading' => esc_html__('Overlay Color', 'sterling'),
					'grid'    => 12,
					'default' => ''
				],
				'sterling_sub_title' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Subtitle', 'sterling'),
				],
				'sterling_title'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Title', 'sterling'),
				],
				'sterling_desc'      => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'sterling'),
				],
			]
		],
		'sterling_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_subtitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__sub-title',
		],
		'sterling_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
		],
		'sterling_use_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_desc_typo'        => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__descr',
		],
	]);

	\Aheto\Params::add_video_button_params($shortcode, [
		'add_label' => esc_html__('Add video?', 'sterling'),
		'prefix'    => 'sterling_video_',
		'group'     => esc_html__('Video Content', 'sterling'),
	], 'sterling_modern_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'sterling_main_',
		'icons'      => true,
	], 'sterling_modern_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'sterling'),
		'prefix'    => 'sterling_add_',
		'icons'      => true,
	], 'sterling_modern_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'sterling_swiper_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
		'dependency'     => ['template', ['sterling_layout1']]
	]);
}

function sterling_banner_slider_layout1_dynamic_css($css, $shortcode) {
	if ( !empty($shortcode->atts['sterling_use_subtitle_typo']) && !empty($shortcode->atts['sterling_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__sub-title'], $shortcode->parse_typography($shortcode->atts['sterling_subtitle_typo']));
	}
	if ( !empty($shortcode->atts['sterling_use_title_typo']) && !empty($shortcode->atts['sterling_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['sterling_title_typo']));
  }
	if ( !empty($shortcode->atts['sterling_use_desc_typo']) && !empty($shortcode->atts['sterling_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__descr'], $shortcode->parse_typography($shortcode->atts['sterling_desc_typo']));
  }
  
	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'sterling_banner_slider_layout1_dynamic_css', 10, 2);