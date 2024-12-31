<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_shop_features_slider_layout1');


function karma_shop_features_slider_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_shop_layout1', [
		'title' => esc_html__('Features Slider 6', 'karma'),
		'image' => $preview_dir . 'karma_shop_layout1.jpg',
	]);
	aheto_demos_add_dependency(['t_heading', 'use_heading'], ['karma_shop_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_shop_slider', 'template', 'karma_shop_layout1');

	$shortcode->add_params([
		'karma_shop_slider' => [
			'type'    => 'group',
			'heading' => esc_html__('Features Slider', 'karma'),
			'params'  => [
				'karma_shop_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_shop_heading'  => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
				],
				'karma_shop_link_url' => [
					'type'    => 'text',
					'heading' => esc_html__('Link URL', 'karma'),
				],
			],
		],

	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_shop_',
		'group'          => 'Karma Shop Swiper',
		'custom_options' => true,
		'include'        => ['arrows', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch', 'arrows_color', 'arrows_size'],
		'dependency'     => ['template', ['karma_shop_layout1']]
	]);
}