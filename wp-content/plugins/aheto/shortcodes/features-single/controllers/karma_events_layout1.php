<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'karma_events_features_single_layout1');


/**
 * Feature Single
 */

function karma_events_features_single_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Features Single 28', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);

	aheto_demos_add_dependency(['s_heading', 's_description'], ['karma_events_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_events_after_title', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_title', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_url', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_use_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_typo', 'karma_events_title_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_desc_use_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'karma_events_desc_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_link_use_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_typo', 'karma_events_link_use_typo', 'true');
	$shortcode->add_params([
		'karma_events_after_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('After Title', 'karma'),
		],
		'karma_events_link_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'karma'),
		],
		'karma_events_link_url'       => [
			'type'    => 'text',
			'heading' => esc_html__('Link URL', 'karma'),
		],
		'karma_events_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title',
		],
		'karma_events_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
		],
		'karma_events_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link',
		],
	]);

}

function karma_events_features_single_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_title_use_typo']) && $shortcode->atts['karma_events_title_use_typo'] && isset($shortcode->atts['karma_events_title_typo']) && !empty($shortcode->atts['karma_events_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['karma_events_title_typo']));
	}
	if ( isset($shortcode->atts['karma_events_desc_use_typo']) && $shortcode->atts['karma_events_desc_use_typo'] && isset($shortcode->atts['karma_events_desc_typo']) && !empty($shortcode->atts['karma_events_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text'], $shortcode->parse_typography($shortcode->atts['karma_events_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_events_link_use_typo']) && $shortcode->atts['karma_events_link_use_typo'] && isset($shortcode->atts['karma_events_link_typo']) && !empty($shortcode->atts['karma_events_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__link'], $shortcode->parse_typography($shortcode->atts['karma_events_link_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'karma_events_features_single_layout1_dynamic_css', 10, 2);

