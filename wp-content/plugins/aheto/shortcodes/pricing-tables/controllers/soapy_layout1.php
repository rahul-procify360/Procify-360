<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'soapy_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function soapy_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Pricing Tables 28', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);
	aheto_demos_add_dependency(['heading', 'link', 'link_style', 'link_border_hover', 'link_border', 'link_bg_hover', 'link_bg', 'link_color_hover', 'link_color', 'features', 'price', 'link_url', 'link_title'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_subtitle', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_active', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_use_subtitle_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_subtitle_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_subtitle_typo', 'soapy_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('soapy_use_heading_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_heading_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_heading_typo', 'soapy_use_heading_typo', 'true');
	$shortcode->add_dependecy('soapy_use_heading_label_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_heading_label_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_heading_label_typo', 'soapy_use_heading_label_typo', 'true');
	$shortcode->add_dependecy('soapy_use_price_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_price_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_price_typo', 'soapy_use_price_typo', 'true');
	$shortcode->add_dependecy('soapy_use_desc_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_desc_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_desc_typo', 'soapy_use_desc_typo', 'true');
	$shortcode->add_params([
		'soapy_subtitle'               => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'soapy'),
		],
		'soapy_active'                 => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Active Item?', 'soapy'),
		],
		'soapy_use_subtitle_typo'      => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_subtitle_typo'          => [
			'type'     => 'typography',
			'group'    => 'Soapy Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__subtitle',
		],
		'soapy_use_heading_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_heading_typo'           => [
			'type'     => 'typography',
			'group'    => 'Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'soapy_use_heading_label_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading Label?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_heading_label_typo'     => [
			'type'     => 'typography',
			'group'    => 'Heading Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-label',
		],
		'soapy_use_price_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_price_typo'             => [
			'type'     => 'typography',
			'group'    => 'Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'soapy_use_desc_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_desc_typo'              => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
	]);
}

function soapy_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_use_subtitle_typo']) && $shortcode->atts['soapy_use_subtitle_typo'] && isset($shortcode->atts['soapy_subtitle_typo']) && !empty($shortcode->atts['soapy_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['soapy_subtitle_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_heading_typo']) && $shortcode->atts['soapy_use_heading_typo'] && isset($shortcode->atts['soapy_heading_typo']) && !empty($shortcode->atts['soapy_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['soapy_heading_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_heading_label_typo']) && $shortcode->atts['soapy_use_heading_label_typo'] && isset($shortcode->atts['soapy_heading_label_typo']) && !empty($shortcode->atts['soapy_heading_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-label'], $shortcode->parse_typography($shortcode->atts['soapy_heading_label_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_price_typo']) && $shortcode->atts['soapy_use_price_typo'] && isset($shortcode->atts['soapy_price_typo']) && !empty($shortcode->atts['soapy_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['soapy_price_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_desc_typo']) && $shortcode->atts['soapy_use_desc_typo'] && isset($shortcode->atts['soapy_desc_typo']) && !empty($shortcode->atts['soapy_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['soapy_desc_typo']));
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'soapy_pricing_tables_layout1_dynamic_css', 10, 2);

