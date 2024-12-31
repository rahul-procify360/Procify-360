<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'sterling_contents_layout1');

/**
 * Contents Shortcode
 */

function sterling_contents_layout1($shortcode)
{

	$theme_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Faq', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);

	aheto_demos_add_dependency('faqs', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('first_is_opened', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('multi_active', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('title_typo', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('text_typo', ['sterling_layout1'], $shortcode);
}