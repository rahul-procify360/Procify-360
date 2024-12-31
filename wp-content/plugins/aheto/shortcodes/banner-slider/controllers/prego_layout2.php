<?php
use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'prego_banner_slider_layout2');

/**
 *  Banner Slider
 */

function prego_banner_slider_layout2( $shortcode ) {
    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('prego_layout2', [
		'title' => esc_html__('Prego Banner Slider Modern', 'prego'),
		'image' => $preview_dir . 'prego_layout2.jpg',
	]);
	aheto_demos_add_dependency(['use_heading', 't_heading'], ['prego_layout2'], $shortcode);

	$shortcode->add_dependecy('prego_overlay_color', 'overlay', 'true');
	$shortcode->add_dependecy('prego_subtitle_use_typo', 'template', 'prego_layout2');
	$shortcode->add_dependecy('prego_subtitle_typo', 'template', 'prego_layout2');
	$shortcode->add_dependecy('prego_subtitle_typo', 'prego_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('prego_modern_banners', 'template', 'prego_layout2');
	$shortcode->add_params([
		'prego_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'prego'),
			'params'  => [
				'prego_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'prego'),
				],
				'prego_item_desc'          => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'prego'),
				],
				'prego_item_title'         => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'prego'),
				],
				'prego_item_align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'prego'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'prego_item_title_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'prego'),
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
		'prego_subtitle_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'prego'),
			'grid'    => 3,
		],
		'prego_subtitle_typo'      => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'prego_btn_',
	], 'prego_modern_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'prego_swiper_',
		'include'        => ['effect', 'arrows', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
		'dependency'     => ['template', ['prego_layout2']]
	]);
}
