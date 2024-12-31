<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'soapy_title_bar_layout1');

/**
 * Title Bar
 */

function soapy_title_bar_layout1($shortcode) {
	$dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Title Bar 8', 'soapy'),
		'image' => $dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['title_tag', 'use_title_typo', 'title_typo', 'title_alignment', 'breadcrumb', 'crumb_alignment'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_breadcrumb_use_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_breadcrumb_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_breadcrumb_typo', 'soapy_breadcrumb_use_typo', 'true');
	$shortcode->add_params([
		'soapy_breadcrumb_use_typo' => [
			'type' => 'switch',
			'heading'  => esc_html__('Use custom font for breadcrumb?', 'soapy'),
			'grid'     => 3,
		],
		'soapy_breadcrumb_typo'     => [
			'type' => 'typography',
			'group'    => 'Soapy Breadcrumb Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .breadcrumbs__item, {{WRAPPER}} .breadcrumbs__item a',
		],
	]);
}
function soapy_title_bar_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['soapy_breadcrumb_use_typo']) && !empty($shortcode->atts['soapy_breadcrumb_typo']) ) {
		\aheto_add_props($css['global']['%1$s .breadcrumbs__item a, %1$s .breadcrumbs__item'], $shortcode->parse_typography($shortcode->atts['soapy_breadcrumb_typo']));
	}
	return $css;
}

add_filter('aheto_title_bar_dynamic_css', 'soapy_title_bar_layout1_dynamic_css', 10, 2);
