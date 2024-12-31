<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'karma_events_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_events_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Pricing Tables 11', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);
	aheto_demos_add_dependency(['heading', 'features', 'price'], ['karma_events_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_events_add_boxshadow', 'template', 'karma_events_layout1');

	$shortcode->add_dependecy('karma_events_image', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_subtitle', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_active', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_use_heading_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_heading_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_heading_typo', 'karma_events_use_heading_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_price_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_price_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_price_typo', 'karma_events_use_price_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_desc_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_desc_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'karma_events_use_desc_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_subtitle_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_subtitle_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_subtitle_typo', 'karma_events_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('karma_events_use_btn_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_btn_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_btn_typo', 'karma_events_use_btn_typo', 'true');
	$shortcode->add_params([
		'karma_events_add_boxshadow'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Add Box Shadow?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_use_heading_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_image'             => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Display Background', 'karma'),
		],
		'karma_events_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'karma'),
		],
		'karma_events_heading_typo'      => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'karma_events_use_price_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_price_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'karma_events_use_desc_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_desc_typo'         => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
		'karma_events_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-subtitle',
		],
		'karma_events_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Mark as active?', 'karma'),
			'grid'    => 3,
		],

	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'karma_events_',
		'group'      => 'Karma Button',
		'icons'      => true,
		'dependency' => ['template', ['karma_events_layout1']]
	]);

}

function karma_events_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_use_subtitle_typo']) && $shortcode->atts['karma_events_use_subtitle_typo'] && isset($shortcode->atts['karma_events_subtitle_typo']) && !empty($shortcode->atts['karma_events_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_events_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_heading_typo']) && $shortcode->atts['karma_events_use_heading_typo'] && isset($shortcode->atts['karma_events_heading_typo']) && !empty($shortcode->atts['karma_events_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['karma_events_heading_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_price_typo']) && $shortcode->atts['karma_events_use_price_typo'] && isset($shortcode->atts['karma_events_price_typo']) && !empty($shortcode->atts['karma_events_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['karma_events_price_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_desc_typo']) && $shortcode->atts['karma_events_use_desc_typo'] && isset($shortcode->atts['karma_events_desc_typo']) && !empty($shortcode->atts['karma_events_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['karma_events_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_subtitle_typo']) && $shortcode->atts['karma_events_use_subtitle_typo'] && isset($shortcode->atts['karma_events_subtitle_typo']) && !empty($shortcode->atts['karma_events_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-subtitle'], $shortcode->parse_typography($shortcode->atts['karma_events_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_btn_typo']) && $shortcode->atts['karma_events_use_btn_typo'] && isset($shortcode->atts['karma_events_btn_typo']) && !empty($shortcode->atts['karma_events_btn_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__btn'], $shortcode->parse_typography($shortcode->atts['karma_events_btn_typo']));
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'karma_events_pricing_tables_layout1_dynamic_css', 10, 2);

