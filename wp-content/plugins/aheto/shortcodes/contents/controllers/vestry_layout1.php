<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'vestry_contents_layout1');


/**
 * Contents
 */

function vestry_contents_layout1($shortcode) {

  $preview_dir = '//assets.aheto.co/contents/previews/';
  
	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Content 31', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
  ]);
  
	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['vestry_layout1'], $shortcode);

}
