<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'ewo_pricing_tables_layout1' );


/**
 * Pricing Tables Shortcode
 */

function ewo_pricing_tables_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Pricing Tables 3', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout1.jpg',
	] );

	$shortcode->add_dependecy('ewo_use_category_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_category_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_category_typo', 'ewo_use_category_typo', 'true');

	$shortcode->add_dependecy('ewo_use_title_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_title_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_title_typo', 'ewo_use_title_typo', 'true');

	$shortcode->add_dependecy('ewo_use_price_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_price_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_price_typo', 'ewo_use_price_typo', 'true');

	$shortcode->add_dependecy('ewo_use_descr_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_descr_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_descr_typo', 'ewo_use_descr_typo', 'true');

	$shortcode->add_dependecy('ewo_use_bb_typo', 'template', 'ewo_layout1');
	//Isotope
	$shortcode->add_dependecy('ewo_pricings', 'template', 'ewo_layout1');

	$shortcode->add_params([
		//Isotope
		'ewo_pricings' => [
			'type'    => 'group',
			'heading' => esc_html__('Ewo Consult Pricing Items', 'ewo'),
			'params'  => [
				'ewo_pricings_heading'        => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'ewo'),
					'default' => esc_html__('Enter your text...', 'ewo'),
				],
				'ewo_pricings_title'        => [
					'type'    => 'text',
					'heading' => esc_html__('Category heading', 'ewo'),
					'default' => esc_html__('Enter your text...', 'ewo'),
				],
				'ewo_pricings_price'        => [
					'type'    => 'text',
					'heading' => esc_html__('Category price', 'ewo'),
					'default' => esc_html__('Enter your text...', 'ewo'),
				],
				'ewo_pricings_descr'        => [
					'type'    => 'textarea',
					'heading' => esc_html__('Category description', 'ewo'),
					'default' => esc_html__('Enter your text...', 'ewo'),
				],
			],
		],
		'ewo_use_category_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for category?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_category_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Category Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-link',
		],
		'ewo_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'ewo_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'ewo_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
		'ewo_use_bb_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use dark border?', 'ewo'),
			'grid'    => 3,
		],
	]);
}


function ewo_pricing_tables_layout1_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['ewo_use_category_typo']) && !empty($shortcode->atts['ewo_category_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-category'], $shortcode->parse_typography($shortcode->atts['ewo_category_typo']));
	}

	if (!empty($shortcode->atts['ewo_use_title_typo']) && !empty($shortcode->atts['ewo_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['ewo_title_typo']));
	}

	if (!empty($shortcode->atts['ewo_use_price_typo']) && !empty($shortcode->atts['ewo_price_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['ewo_price_typo']));
	}

	if (!empty($shortcode->atts['ewo_use_descr_typo']) && !empty($shortcode->atts['ewo_descr_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['ewo_descr_typo']));
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'ewo_pricing_tables_layout1_dynamic_css', 10, 2);