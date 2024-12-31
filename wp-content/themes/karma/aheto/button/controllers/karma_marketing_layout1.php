<?php

use Aheto\Helper;

/**
 * Custom Button
 */

function karma_marketing_button_all_layouts($all_layouts) {


	$preview_dir = get_template_directory_uri() . '/aheto/button/previews/';

	$all_layouts['karma_marketing_layout1'] = array(
		'title' => esc_html__('karma Marketing Layout1', 'karma'),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	);
	$all_layouts['karma_marketing_layout2'] = array(
		'title' => esc_html__('karma Marketing Layout2', 'karma'),
		'image' => $preview_dir . 'karma_marketing_layout2.jpg',
	);

	return $all_layouts;

}

add_filter('aheto_button_all_layouts', 'karma_marketing_button_all_layouts', 10, 2);