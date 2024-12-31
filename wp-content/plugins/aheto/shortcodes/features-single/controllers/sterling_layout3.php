<?php


use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'sterling_features_single_layout3');

/**
 * Features Single Shortcode
 */

function sterling_features_single_layout3($shortcode)
{
	$dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('sterling_layout3', [
		'title' => esc_html__('Sterling features single hover', 'sterling'),
		'image' => $dir . 'sterling_layout3.jpg',
	]);

	aheto_demos_add_dependency('s_image', ['sterling_layout3'], $shortcode);
	aheto_demos_add_dependency('s_heading', ['sterling_layout3'], $shortcode);
	aheto_demos_add_dependency('s_description', ['sterling_layout3'], $shortcode);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'sterling_main_',
		'dependency' => ['template', ['sterling_layout3']]
	]);
}
