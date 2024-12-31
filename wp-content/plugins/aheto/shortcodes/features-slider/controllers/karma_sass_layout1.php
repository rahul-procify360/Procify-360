<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_sass_features_slider_layout1');


function karma_sass_features_slider_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_sass_layout1', [
		'title' => esc_html__('Karma SASS Layout 1', 'karma'),
		'image' => $preview_dir . 'karma_sass_layout1.jpg',
	]);
    $shortcode->add_dependecy('karma_sass_slider', 'template', 'karma_sass_layout1');
    $shortcode->add_dependecy('karma_sass_image_slide_active', 'template', 'karma_sass_layout1');


	$shortcode->add_params([
		'karma_sass_slider'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Slider', 'karma'),
			'params'  => [
				'karma_sass_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
			],
		],
		'karma_sass_image_slide_active'       => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image For Active Slide', 'aheto'),
		],
	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_sass_',
		'custom_options' => true,
		'group'          => 'Karma Swiper',
		'include'        => ['pagination', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch', 'centeredSlides'],
		'dependency'     => ['template', ['karma_sass_layout1']]
	]);
}
