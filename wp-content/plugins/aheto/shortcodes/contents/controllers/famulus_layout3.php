<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'famulus_contents_layout3' );


/**
 * Contents
 */

function famulus_contents_layout3( $shortcode ) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout3', [
		'title' => esc_html__('Content 8', 'famulus'),
		'image' => $preview_dir . 'famulus_layout3.jpg',
	]);

	aheto_demos_add_dependency( ['faqs', 'first_is_opened', 'multi_active', 'text_typo'], [ 'famulus_layout3' ], $shortcode );

	$shortcode->add_dependecy('famulus_use_typo_hightlight', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_hightlight', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_hightlight', 'famulus_use_typo_hightlight', 'true');
	$shortcode->add_dependecy('famulus_use_typo_main_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_main_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_main_title', 'famulus_use_typo_main_title', 'true');
	$shortcode->add_dependecy('famulus_use_typo_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_text_typo_title', 'famulus_use_typo_title', 'true');

	$shortcode->add_dependecy('famulus_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_tag', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_active_color', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_divider_color', 'template', 'famulus_layout3');

	$shortcode->add_params([
		'famulus_title'       => [
			'type'    => 'textarea',
			'heading' => esc_html__('Title', 'famulus'),
		],
		'famulus_title_tag'   => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for title', 'famulus'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h3',
			'grid'    => 5,
		],
		'famulus_use_typo_hightlight'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_hightlight' => [
			'type'     => 'typography',
			'group'    => 'Famulus Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title span, {{WRAPPER}}  .aheto-contents__main-title span',
		],

		'famulus_use_typo_main_title'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for main title?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_main_title' => [
			'type'     => 'typography',
			'group'    => 'Famulus Main Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__main-title',
		],
		'famulus_use_typo_title'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_title' => [
			'type'     => 'typography',
			'group'    => 'Famulus Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title',
		],
		'famulus_active_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Color for active title', 'famulus'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .is-open .aheto-contents__title' => 'color: {{VALUE}}'],
		],
		'famulus_divider_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Color for title divider', 'famulus'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-contents__title' => 'border-bottom-color: {{VALUE}}'],
		],
	]);
}

function famulus_contents_layout3_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_hightlight']) && $shortcode->atts['famulus_use_typo_hightlight'] && isset($shortcode->atts['famulus_text_typo_hightlight'])&& !empty($shortcode->atts['famulus_text_typo_hightlight']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__main-title span'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_hightlight']));
	}

	if ( isset($shortcode->atts['famulus_use_typo_title']) && $shortcode->atts['famulus_use_typo_title'] && isset($shortcode->atts['famulus_text_typo_title']) && !empty($shortcode->atts['famulus_text_typo_title']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_title']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_main_title']) && $shortcode->atts['famulus_use_typo_main_title'] && isset($shortcode->atts['famulus_text_typo_main_title']) && !empty($shortcode->atts['famulus_text_typo_main_title']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__main_title'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_main_title']));
	}
	if (!empty($shortcode->atts['famulus_active_color'])) {
		$color = Sanitize::color($shortcode->atts['famulus_active_color']);
		$css['global']['%1$s .is-open .aheto-contents__title']['color'] = $color;
	}
	if (!empty($shortcode->atts['famulus_divider_color'])) {
		$color = Sanitize::color($shortcode->atts['famulus_divider_color']);
		$css['global']['%1$s .aheto-contents__title']['border-bottom-color'] = $color;
	}
	return $css;
}

add_filter('aheto_contents_dynamic_css', 'famulus_contents_layout3_dynamic_css', 10, 2);