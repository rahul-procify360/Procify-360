<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'pointe_contents_layout1');


/**
 * Contents
 */

function pointe_contents_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('pointe_layout1', [
		'title' => esc_html__('Pointe contents classic', 'pointe'),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	]);
	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'title_typo', 'text_typo'], ['pointe_layout1'], $shortcode);
}
