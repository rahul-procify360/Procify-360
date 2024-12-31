<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout1');


/**
 * Contents
 */

function famulus_contents_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Content 6', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy( 'famulus_border_radius', 'template', 'famulus_layout1' );

	$shortcode->add_params([

		'famulus_border_radius'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Border radius', 'famulus'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__item' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
		],


	]);

}


function famulus_contents_layout1_dynamic_css($css, $shortcode) {

	if (!empty($shortcode->atts['famulus_border_radius'])) {
		$css['global']['%1$s .aheto-contents__item']['border-radius'] = Sanitize::size($shortcode->atts['famulus_border_radius']);
	}

	return $css;
}

add_filter('aheto_contents_dynamic_css', 'famulus_contents_layout1_dynamic_css', 10, 2);