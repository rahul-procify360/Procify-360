<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-timeline_register', 'famulus_features_timeline_layout1');


/**
 * Features Timeline Shortcode
 */

function famulus_features_timeline_layout1($shortcode) {
	$dir = '//assets.aheto.co/features-timeline/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Features Timeline 2', 'famulus'),
		'image' => $dir . 'acacio_layout1.jpg',
	]);
	$shortcode->add_dependecy('famulus_timeline', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_dark_version', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_title_h_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_title_h_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_title_h_typo', 'famulus_title_h_use_typo', 'true');

	$shortcode->add_dependecy('famulus_year_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_year_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_year_typo', 'famulus_year_use_typo', 'true');

	$shortcode->add_params([
		'famulus_timeline'     => [
			'type'    => 'group',
			'heading' => esc_html__('Items', 'famulus'),
			'params'  => [
				'famulus_timeline_date'    => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'famulus'),
				],
				'famulus_timeline_title'   => [
					'type'        => 'textarea',
					'heading'     => esc_html__('Title', 'famulus'),
					'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'famulus'),
					'default'     => esc_html__('Title with [[ hightlight ]] text.', 'famulus'),
				],
				'famulus_timeline_content' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Content', 'famulus'),
					'default' => esc_html__('Add some text for content', 'famulus'),
				],
				'famulus_timeline_image'   => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Add image', 'famulus'),
				],
			],
		],
		'famulus_dark_version' => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable dark version?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_h_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_h_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Title Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-timeline__title span',
		],
		'famulus_year_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for year?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_year_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Year Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-timeline__events li  h5',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'famulus_',
		'icons'  => true,
	], 'famulus_timeline');
}
function famulus_aheto_features_timeline_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['famulus_title_h_use_typo']) && $shortcode->atts['famulus_title_h_use_typo'] && isset($shortcode->atts['famulus_title_h_typo']) && !empty($shortcode->atts['famulus_title_h_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-timeline__title span'], $shortcode->parse_typography($shortcode->atts['famulus_title_h_typo']));
	}
	if ( isset($shortcode->atts['famulus_year_use_typo']) && $shortcode->atts['famulus_year_use_typo'] && isset($shortcode->atts['famulus_year_typo']) && !empty($shortcode->atts['famulus_year_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-timeline__events li  h5'], $shortcode->parse_typography($shortcode->atts['famulus_year_typo']));
	}
	return $css;
}

add_filter('aheto_features_timeline_dynamic_css', 'famulus_aheto_features_timeline_layout1_dynamic_css', 10, 2);