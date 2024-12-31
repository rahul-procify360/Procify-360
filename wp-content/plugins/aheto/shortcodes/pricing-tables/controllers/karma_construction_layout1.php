<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'karma_construction_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_construction_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('karma_construction_layout1', [
		'title' => esc_html__('Pricing Tables 9', 'karma'),
		'image' => $preview_dir . 'karma_construction_layout1.jpg',
	]);
	aheto_demos_add_dependency(['heading', 'link', 'link_style', 'link_border_hover', 'link_border', 'link_bg_hover', 'link_bg', 'link_color_hover', 'link_color', 'features', 'price', 'link_url', 'link_title'], ['karma_construction_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_construction_image', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_price_label', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_active', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_use_heading_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_heading_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_heading_typo', 'karma_construction_use_heading_typo', 'true');
	$shortcode->add_dependecy('karma_construction_use_price_label_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_price_label_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_price_label_typo', 'karma_construction_use_price_label_typo', 'true');
	$shortcode->add_dependecy('karma_construction_use_price_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_price_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_price_typo', 'karma_construction_use_price_typo', 'true');
	$shortcode->add_dependecy('karma_construction_use_desc_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_desc_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_desc_typo', 'karma_construction_use_desc_typo', 'true');

	$shortcode->add_dependecy('karma_construction_use_btn_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_btn_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_btn_typo', 'karma_construction_use_btn_typo', 'true');
	$shortcode->add_params([
		'karma_construction_active'                 => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Active Item?', 'karma'),
		],
		'karma_construction_use_heading_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_image'                => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Display Image', 'karma'),
		],
		'karma_construction_price_label'          => [
			'type'    => 'text',
			'heading' => esc_html__('Price Label', 'karma'),
		],
		'karma_construction_heading_typo'         => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'karma_construction_use_price_label_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading Label?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_price_label_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Price Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price span',
		],
		'karma_construction_use_price_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_price_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'karma_construction_use_desc_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_desc_typo'            => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
		'karma_construction_use_btn_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Button?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_btn_typo'            => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__btn',
		],
	]);
}

function karma_construction_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_construction_use_subtitle_typo']) && $shortcode->atts['karma_construction_use_subtitle_typo'] && isset($shortcode->atts['karma_construction_subtitle_typo']) && !empty($shortcode->atts['karma_construction_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_construction_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_heading_typo']) && $shortcode->atts['karma_construction_use_heading_typo'] && isset($shortcode->atts['karma_construction_heading_typo']) && !empty($shortcode->atts['karma_construction_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['karma_construction_heading_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_price_label_typo']) && $shortcode->atts['karma_construction_use_price_label_typo'] && isset($shortcode->atts['karma_construction_price_label_typo']) && !empty($shortcode->atts['karma_construction_price_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price span'], $shortcode->parse_typography($shortcode->atts['karma_construction_price_label_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_price_typo']) && $shortcode->atts['karma_construction_use_price_typo'] && isset($shortcode->atts['karma_construction_price_typo']) && !empty($shortcode->atts['karma_construction_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['karma_construction_price_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_desc_typo']) && $shortcode->atts['karma_construction_use_desc_typo'] && isset($shortcode->atts['karma_construction_desc_typo']) && !empty($shortcode->atts['karma_construction_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['karma_construction_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_btn_typo']) && $shortcode->atts['karma_construction_use_btn_typo'] && isset($shortcode->atts['karma_construction_btn_typo']) && !empty($shortcode->atts['karma_construction_btn_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__btn'], $shortcode->parse_typography($shortcode->atts['karma_construction_btn_typo']));
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'karma_construction_pricing_tables_layout1_dynamic_css', 10, 2);

