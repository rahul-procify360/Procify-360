<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'soapy_social_networks_layout1');

/**
 * Social Networks
 */

function soapy_social_networks_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Social Networks 11', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);
	aheto_demos_add_dependency('networks', ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_label', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_label_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_label_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_label_typo', 'soapy_label_use_typo', 'true');
	$shortcode->add_params([
		'soapy_label'          => [
			'type'    => 'text',
			'heading' => esc_html__('Label', 'soapy'),
		],
		'soapy_label_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_label_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-socials__label',
		],
	]);
}
function soapy_social_networks_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_label_use_typo']) && $shortcode->atts['soapy_label_use_typo'] && isset($shortcode->atts['soapy_label_typo']) && !empty($shortcode->atts['soapy_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-socials__label'], $shortcode->parse_typography($shortcode->atts['soapy_label_typo']));
	}

	return $css;
}
add_filter('aheto_social_networks_dynamic_css', 'soapy_social_networks_layout1_dynamic_css', 10, 2);
