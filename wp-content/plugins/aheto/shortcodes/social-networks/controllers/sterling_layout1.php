<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'sterling_social_networks_layout1');

/**
 * Social-networks Shortcode
 */

function sterling_social_networks_layout1($shortcode)
{

	$theme_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Socials', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);

	aheto_demos_add_dependency('networks', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('size', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('style', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('color', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('socials_align', ['sterling_layout1'], $shortcode);
}