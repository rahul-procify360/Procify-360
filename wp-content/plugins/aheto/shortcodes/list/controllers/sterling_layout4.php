<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'sterling_list_layout4');

/**
 * List
 */

function sterling_list_layout4($shortcode)
{

	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('sterling_layout4', [
		'title' => esc_html__('Sterling list with background', 'sterling'),
		'image' => $dir . 'sterling_layout4.jpg',
	]);

	aheto_demos_add_dependency('heading', ['sterling_layout4'], $shortcode);
	aheto_demos_add_dependency('lists', ['sterling_layout4'], $shortcode);
	aheto_demos_add_dependency('text_tag', ['sterling_layout4'], $shortcode);

}