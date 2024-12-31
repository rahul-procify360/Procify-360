<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'funero_navbar_layout1');

/**
 *  Navbar Shortcode
 */

function funero_navbar_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Navbar 5', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);
	aheto_demos_add_dependency(['columns', 'left_links', 'right_links'], ['funero_layout1'], $shortcode);

	$shortcode->add_dependecy('funero_soc_label', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_label_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_label_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_label_typo', 'funero_label_use_typo', 'true');


	$shortcode->add_params([

		'funero_soc_label' => [
			'type'    => 'text',
			'heading' => esc_html__('Social label', 'funero'),
		],
		'funero_label_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Label?', 'funero'),
			'grid'    => 3,
		],
		'funero_label_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__label, {{WRAPPER}} .aheto-navbar--item',
		],
	]);
}


function funero_navbar_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_label_use_typo']) && $shortcode->atts['funero_label_use_typo'] && isset($shortcode->atts['funero_label_typo']) && !empty($shortcode->atts['funero_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__label, %1$s  .aheto-navbar--item'], $shortcode->parse_typography($shortcode->atts['funero_label_typo']));
	}
	return $css;
}
add_filter('aheto_navbar_dynamic_css', 'funero_navbar_layout1_dynamic_css', 10, 2);
