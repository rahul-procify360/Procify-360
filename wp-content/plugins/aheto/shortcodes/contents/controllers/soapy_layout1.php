<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'soapy_contents_layout1');


/**
 * Contents
 */

function soapy_contents_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Content 30', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['soapy_layout1'], $shortcode);

}
