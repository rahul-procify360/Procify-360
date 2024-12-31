<?php


use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'sterling_features_single_layout4');

/**
 * Features Single Shortcode
 */

function sterling_features_single_layout4($shortcode)
{
	$dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('sterling_layout4', [
		'title' => esc_html__('Sterling features single scale', 'sterling'),
		'image' => $dir . 'sterling_layout4.jpg',
	]);

	aheto_demos_add_dependency('s_image', ['sterling_layout4'], $shortcode);
	aheto_demos_add_dependency('s_heading', ['sterling_layout4'], $shortcode);
	aheto_demos_add_dependency('s_description', ['sterling_layout4'], $shortcode);
  $shortcode->add_dependecy('sterling_use_main', 'template', 'sterling_layout4');

	$shortcode->add_params([
		'sterling_use_main' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use like main', 'sterling'),
			'grid'    => 3,
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'sterling_main_',
		'dependency' => ['template', ['sterling_layout4']]
	]);
}
