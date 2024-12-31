<?php


use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'sterling_features_single_layout5');

/**
 * Features Single Shortcode
 */

function sterling_features_single_layout5($shortcode)
{
	$dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('sterling_layout5', [
		'title' => esc_html__('Sterling features single animate', 'sterling'),
		'image' => $dir . 'sterling_layout5.jpg',
	]);

	aheto_demos_add_dependency('s_image', ['sterling_layout5'], $shortcode);
	aheto_demos_add_dependency('s_heading', ['sterling_layout5'], $shortcode);
	aheto_demos_add_dependency('s_description', ['sterling_layout5'], $shortcode);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'sterling_main_',
		'icons' => true,
		'dependency' => ['template', ['sterling_layout5']]
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size for images ', 'sterling'),
		'prefix'     => 'sterling_',
		'dependency' => ['template', ['sterling_layout5']]
	]);
}
