<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'soapy_pricing_tables_layout2');


/**
 * Pricing Tables Shortcode
 */

function soapy_pricing_tables_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Pricing Tables 29', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);
	$shortcode->add_dependecy('soapy_pricings', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_use_heading_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_heading_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_heading_typo', 'soapy_use_heading_typo', 'true');
	$shortcode->add_dependecy('soapy_use_heading_label_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_heading_label_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_heading_label_typo', 'soapy_use_heading_label_typo', 'true');
	$shortcode->add_dependecy('soapy_use_price_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_price_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_price_typo', 'soapy_use_price_typo', 'true');
	$shortcode->add_dependecy('soapy_use_desc_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_desc_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_desc_typo', 'soapy_use_desc_typo', 'true');
	$shortcode->add_dependecy('soapy_use_link_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_link_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_link_typo', 'soapy_use_link_typo', 'true');

	$shortcode->add_params([
		'soapy_use_heading_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_heading_typo'           => [
			'type'     => 'typography',
			'group'    => 'Soapy Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'soapy_use_heading_label_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading label?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_heading_label_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Heading Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-label',
		],
		'soapy_use_price_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_price_typo'             => [
			'type'     => 'typography',
			'group'    => 'Soapy Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'soapy_use_desc_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_desc_typo'              => [
			'type'     => 'typography',
			'group'    => 'Soapy Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
		'soapy_use_link_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_link_typo'              => [
			'type'     => 'typography',
			'group'    => 'Soapy Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-link',
		],
		//Isotope
		'soapy_pricings'               => [
			'type'    => 'group',
			'heading' => esc_html__('Soapy Consult Pricing Items', 'soapy'),
			'params'  => [
				'soapy_pricings_heading' => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'soapy'),
					'default' => esc_html__('Put your text...', 'soapy'),
				],
				'soapy_pricings_title'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category heading', 'soapy'),
					'default' => esc_html__('Put your text...', 'soapy'),
				],
				'soapy_pricings_label'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category label', 'soapy'),
					'default' => esc_html__('', 'soapy'),
				],
				'soapy_pricings_price'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category price', 'soapy'),
					'default' => esc_html__('Put your text...', 'soapy'),
				],
				'soapy_pricings_descr'   => [
					'type'    => 'textarea',
					'heading' => esc_html__('Category description', 'soapy'),
					'default' => esc_html__('Put your text...', 'soapy'),
				],
			],
		],
		//Isotope
	]);
}

function soapy_pricing_tables_layout2_dynamic_css($css, $shortcode) {

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
	if ( isset($shortcode->atts['soapy_use_link_typo']) && $shortcode->atts['soapy_use_link_typo'] && isset($shortcode->atts['soapy_link_typo']) && !empty($shortcode->atts['soapy_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__list-link'], $shortcode->parse_typography($shortcode->atts['soapy_link_typo']));
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'soapy_pricing_tables_layout2_dynamic_css', 10, 2);

