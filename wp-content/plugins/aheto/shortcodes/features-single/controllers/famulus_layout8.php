<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout8');


/**
 * Feature Single
 */

function famulus_features_single_layout8($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout8', [
		'title' => esc_html__('Features Single 14', 'famulus'),
		'image' => $preview_dir . 'famulus_layout8.jpg',
	]);

	aheto_demos_add_dependency(['s_image', 's_heading', 's_description'], ['famulus_layout8'], $shortcode);

	$shortcode->add_dependecy('famulus_after_title', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_subtitle', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_title_use_typo', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_subtitle_use_typo', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_subtitle_typo', 'template', 'famulus_layout8');
	$shortcode->add_dependecy('famulus_subtitle_typo', 'famulus_subtitle_use_typo', 'true');
	$shortcode->add_params([
		'famulus_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Famulus Subtitle', 'famulus'),
		],
		'famulus_after_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('After Title', 'famulus'),
		],
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
			'selector' => '{{WRAPPER}} .aheto-content-block__title',
		],
		'famulus_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__subtitle',
		],
	]);

}

function famulus_features_single_layout8_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_title_use_typo']) && $shortcode->atts['famulus_title_use_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_subtitle_use_typo']) && $shortcode->atts['famulus_subtitle_use_typo'] && isset($shortcode->atts['famulus_subtitle_typo']) && !empty($shortcode->atts['famulus_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography($shortcode->atts['famulus_subtitle_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout8_dynamic_css', 10, 2);

