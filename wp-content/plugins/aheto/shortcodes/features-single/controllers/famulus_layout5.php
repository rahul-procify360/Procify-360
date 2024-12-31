<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout5');


/**
 * Feature Single
 */

function famulus_features_single_layout5($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout5', [
		'title' => esc_html__('Features Single 11', 'famulus'),
		'image' => $preview_dir . 'famulus_layout5.jpg',
	]);

	aheto_demos_add_dependency(['s_image', 's_heading', 's_description', 'use_description', 't_description', 'link_url', 'link_title'], ['famulus_layout5'], $shortcode);

	$shortcode->add_dependecy('famulus_before_num', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_num', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_after_num', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_full_width', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_link_arrow', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_number_fs', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_title_use_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_desc_h_use_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_desc_h_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_desc_h_typo', 'famulus_desc_h_use_typo', 'true');
	$shortcode->add_dependecy('famulus_link_use_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_link_typo', 'template', 'famulus_layout5');
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_link_use_typo', 'true');

	$shortcode->add_params([
		'famulus_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title, .aheto-content-block__num-wrap',
		],
		'famulus_desc_h_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_desc_h_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text span',
		],
		'famulus_before_num' => [
			'type'    => 'text',
			'heading' => esc_html__('Before Number', 'famulus'),
		],
		'famulus_num'        => [
			'type'    => 'text',
			'heading' => esc_html__('Number', 'famulus'),
		],
		'famulus_after_num'  => [
			'type'    => 'text',
			'heading' => esc_html__('After Number', 'famulus'),
		],
		'famulus_full_width' => [
			'type'    => 'switch',
			'heading' => esc_html__('Item full width?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_arrow' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add link to arrow?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_number_fs'  => [
			'type'    => 'switch',
			'heading' => esc_html__('After Title Default Font Size?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'         => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link-wrap a, .aheto-content-block__link-text ',
		],
	]);
}
function famulus_features_single_layout5_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_title_use_typo']) && $shortcode->atts['famulus_title_use_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title, %1$s .aheto-content-block__num-wrap'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_desc_h_use_typo']) && $shortcode->atts['famulus_desc_h_use_typo'] && isset($shortcode->atts['famulus_desc_h_typo']) && !empty($shortcode->atts['famulus_desc_h_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text span'], $shortcode->parse_typography($shortcode->atts['famulus_desc_h_typo']));
	}
	if ( isset($shortcode->atts['famulus_subtitle_use_typo']) && $shortcode->atts['famulus_subtitle_use_typo'] && isset($shortcode->atts['famulus_subtitle_typo']) && !empty($shortcode->atts['famulus_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography($shortcode->atts['famulus_subtitle_typo']));
	}
	if ( isset($shortcode->atts['famulus_link_use_typo']) && $shortcode->atts['famulus_link_use_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-content-block__link-wrap a, .aheto-content-block__link-text '], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout5_dynamic_css', 10, 2);

