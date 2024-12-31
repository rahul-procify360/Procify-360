<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'karma_education_custom_post_types_layout1');

/**
 * Custom Post Type
 */

function karma_education_custom_post_types_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('karma_education_layout1', [
		'title' => esc_html__('Custom Post Type 7', 'karma'),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	]);


	aheto_demos_add_dependency(['skin', 'title_tag', 'image_height', 't_heading', 'use_heading'], ['karma_education_layout1'], $shortcode);

	\Aheto\Params::add_carousel_params($shortcode, [
		'group'          => 'Karma Education Swiper',
		'custom_options' => true,
		'prefix'         => 'karma_education_swiper_',
		'include'        => [
			'pagination',
			'arrows',
			'loop',
			'autoplay',
			'overflow',
			'centeredSlides',
			'speed',
			'slides',
			'spaces',
			'simulate_touch',
			'arrows_color',
			'arrows_size'
		], 'dependency'  => ['template', ['karma_education_layout1']]
	]);
}