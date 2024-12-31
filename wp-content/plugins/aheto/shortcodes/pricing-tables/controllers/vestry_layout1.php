<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'vestry_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function vestry_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Pricing Tables 30', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
  ]);
  
	aheto_demos_add_dependency(['price', 'description','heading' ], ['vestry_layout1'], $shortcode);
  
	$shortcode->add_dependecy('vestry_use_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'vestry_use_title_typo', 'true');

	$shortcode->add_dependecy('vestry_use_price_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_price_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_price_typo', 'vestry_use_price_typo', 'true');

	$shortcode->add_dependecy('vestry_features', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_use_features_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_features_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_features_typo', 'vestry_use_features_typo', 'true');

	$shortcode->add_dependecy('vestry_use_time_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_time_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_time_typo', 'vestry_use_time_typo', 'true');
	
	$shortcode->add_dependecy('vestry_use_include ', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_active', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_background', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_disable_color', 'template', 'vestry_layout1');


	$shortcode->add_params([
		'vestry_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],

		'vestry_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],

		'vestry_features'          => [
			'type'    => 'group',
			'heading' => esc_html__('Features', 'vestry'),
			'params'  => [
				'vestry_feature' => [
					'type'    => 'text',
					'heading' => esc_html__('Feature', 'vestry'),
					'description' => esc_html__('Enter Feature.', 'vestry'),
				],
				'vestry_use_include' => [
					'type'    => 'switch',
					'heading' => esc_html__('Disable this position', 'vestry'),
					'grid'    => 3,
				],
			],
		],

		'vestry_use_features_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for features?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_features_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Features Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__description li, {{WRAPPER}} .aheto-pricing__list-item',
		],

		'vestry_use_time_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for cost time?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_time_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Cost Time Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-time',
		],

		'vestry_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Mark as active?', 'vestry'),
			'grid'    => 12,
		],

		'vestry_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Background color', 'vestry'),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--vestry-classic' => 'background: {{VALUE}}',
			],
		],
		'vestry_disable_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Features disable color', 'vestry'),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing__description li.disable' => 'color: {{VALUE}}',
			],
		],
  ]);
  \Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'vestry_',
		'dependency' => ['template', ['vestry_layout1']]
	]);
}

function vestry_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['vestry_use_title_typo']) && !empty($shortcode->atts['vestry_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
	}
	if ( !empty($shortcode->atts['vestry_use_price_typo']) && !empty($shortcode->atts['vestry_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['vestry_price_typo']));
	}
	if ( !empty($shortcode->atts['vestry_use_features_typo']) && !empty($shortcode->atts['vestry_features_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography($shortcode->atts['vestry_features_typo']));
	}
	if ( !empty($shortcode->atts['vestry_use_time_typo']) && !empty($shortcode->atts['vestry_time_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost-time'], $shortcode->parse_typography($shortcode->atts['vestry_time_typo']));
	}
	if (!empty($shortcode->atts['vestry_disable_color'])) {
		$color = Sanitize::color($shortcode->atts['vestry_disable_color']);
		$css['global']['%1$s .aheto-pricing__description li.disable']['color'] = $color;
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'vestry_pricing_tables_layout1_dynamic_css', 10, 2);

