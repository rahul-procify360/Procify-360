<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'djo_heading_layout2');

/**
 * Heading Shortcode
 */

function djo_heading_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('djo_layout2', [
		'title' => esc_html__('Heading 3', 'djo'),
		'image' => $preview_dir . 'djo_layout2.jpg',
	]);
	$shortcode->add_dependecy('djo_text', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_use_text_typo', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_text_typo', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_text_typo', 'djo_use_text_typo', 'true');
	aheto_demos_add_dependency('text_tag', ['djo_layout2'], $shortcode);

	$shortcode->add_params([
		'djo_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for BG Text?', 'djo'),
			'grid'    => 3,
		],
		'djo_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Bg Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__bg-title',
		],
		'djo_text' => [
			'type'    => 'text',
			'heading' => esc_html__('Backgroun text', 'djo'),
			'grid'    => 12,
		],
	]);


}
function djo_heading_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_text_typo']) && $shortcode->atts['djo_use_text_typo'] && isset($shortcode->atts['djo_text_typo']) && !empty($shortcode->atts['djo_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__bg-title'], $shortcode->parse_typography($shortcode->atts['djo_text_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'djo_heading_layout2_dynamic_css', 10, 2);

