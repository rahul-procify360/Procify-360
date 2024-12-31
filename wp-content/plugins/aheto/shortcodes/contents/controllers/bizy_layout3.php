<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'bizy_contents_layout3');


/**
 * Contents
 */

function bizy_contents_layout3($shortcode) {

  $preview_dir = '//assets.aheto.co/contents/previews/';
  
	$shortcode->add_layout('bizy_layout3', [
		'title' => esc_html__('Bizy Gradient', 'bizy'),
		'image' => $preview_dir . 'bizy_layout3.jpg',
  ]);

	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['bizy_layout3'], $shortcode);

}