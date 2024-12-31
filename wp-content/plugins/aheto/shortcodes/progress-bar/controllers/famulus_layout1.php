<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'famulus_progress_bar_layout1');
/**
 * Progress Bar Shortcode
 */

function famulus_progress_bar_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Progress Bar 4', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	$shortcode->add_dependecy('white_text', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_line_color', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_chart_symbol_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_chart_symbol_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_chart_symbol_typo', 'famulus_add_chart_symbol_use_typo', 'true');
	$shortcode->add_dependecy('famulus_add_chart_per_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_chart_per_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_chart_per_typo', 'famulus_add_chart_symbol_use_typo', 'true');
	$shortcode->add_dependecy('famulus_add_title_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_title_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_title_typo', 'famulus_add_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_add_desc_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_desc_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_add_desc_typo', 'famulus_add_desc_use_typo', 'true');

	aheto_demos_add_dependency(['percentage', 'heading', 'description'], ['famulus_layout1'], $shortcode);


	$shortcode->add_params([
		'white_text' => [
			'type'    => 'switch',
			'heading' => esc_html__('White Text', 'famulus'),
			'grid'    => 12,
		],
		'famulus_line_color'   => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Line color', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .aheto-progress__chart-circle' => 'stroke: {{VALUE}}',
			],
		],
		'famulus_add_chart_symbol_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for chart symbol?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_chart_symbol_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Chart Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol',
		],
		'famulus_add_chart_per_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for chart percent?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_chart_per_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Chart Percent Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol i',
		],
		'famulus_add_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title',
		],
		'famulus_add_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__desc',
		],
	]);


}

function famulus_aheto_progress_bar_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_add_chart_symbol_use_typo']) && $shortcode->atts['famulus_add_chart_symbol_use_typo'] && isset($shortcode->atts['famulus_add_chart_symbol_typo']) && !empty($shortcode->atts['famulus_add_chart_symbol_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__chart-symbol'], $shortcode->parse_typography($shortcode->atts['famulus_add_chart_symbol_typo']));
	}
	if ( isset($shortcode->atts['famulus_add_chart_per_use_typo']) && $shortcode->atts['famulus_add_chart_per_use_typo'] && isset($shortcode->atts['famulus_add_chart_per_typo']) && !empty($shortcode->atts['famulus_add_chart_per_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__chart-symbol i'], $shortcode->parse_typography($shortcode->atts['famulus_add_chart_per_typo']));
	}
	if ( isset($shortcode->atts['famulus_add_title_use_typo']) && $shortcode->atts['famulus_add_title_use_typo'] && isset($shortcode->atts['famulus_add_title_typo']) && !empty($shortcode->atts['famulus_add_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['famulus_add_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_add_desc_use_typo']) && $shortcode->atts['famulus_add_desc_use_typo'] && isset($shortcode->atts['famulus_add_desc_typo']) && !empty($shortcode->atts['famulus_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__desc'], $shortcode->parse_typography($shortcode->atts['famulus_add_desc_typo']));
	}
	if ( ! empty( $shortcode->atts['famulus_line_color'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['famulus_line_color'] );
		$css['global']['%1$s .aheto-progress__chart-circle']['stroke'] = $color;
	}
	return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'famulus_aheto_progress_bar_layout1_dynamic_css', 10, 2);
