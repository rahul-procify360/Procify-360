<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout3');


/**
 * Feature Single
 */

function famulus_features_single_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout3', [
		'title' => esc_html__('Features Single 9', 'famulus'),
		'image' => $preview_dir . 'famulus_layout3.jpg',
	]);
	aheto_demos_add_dependency(['s_image', 's_heading', 's_description', 'use_heading', 't_heading', 'use_description', 't_description', 'link_url', 'link_title'], ['famulus_layout3'], $shortcode);

	$shortcode->add_dependecy('famulus_link_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_link_use_typo', 'true');
	$shortcode->add_params([
		'famulus_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link-wrap a',
		],
	]);
}

function famulus_features_single_layout3_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_link_use_typo']) && $shortcode->atts['famulus_link_use_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-content-block__link-wrap a'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout3_dynamic_css', 10, 2);
