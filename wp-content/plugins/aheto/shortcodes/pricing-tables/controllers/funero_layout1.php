<?php

use Aheto\Helper;
add_action('aheto_before_aheto_pricing-tables_register', 'funero_pricing_tables_layout1');


/**
 * Pricing tables
 */

function funero_pricing_tables_layout1($shortcode)
{
	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Pricing Tables 5', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	aheto_demos_add_dependency(['price', 'description', 'heading'], ['funero_layout1'], $shortcode);

	$shortcode->add_dependecy('funero_use_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_typo', 'funero_use_title_typo', 'true');

	$shortcode->add_dependecy('funero_use_price_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_price_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_price_typo', 'funero_use_price_typo', 'true');

	$shortcode->add_dependecy('funero_features', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_features_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_features_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_features_typo', 'funero_use_features_typo', 'true');
	$shortcode->add_dependecy('funero_use_include ', 'template', 'funero_layout1');

	$shortcode->add_dependecy('funero_use_time_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_time_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_time_typo', 'funero_use_time_typo', 'true');

	$shortcode->add_dependecy('funero_active', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_background', 'template', 'funero_layout1');

	$shortcode->add_params([
		'funero_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'funero'),
			'grid'    => 3,
		],

		'funero_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Funero Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],

		'funero_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'funero'),
			'grid'    => 3,
		],

		'funero_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Funero Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],

		'funero_features'          => [
			'type'    => 'group',
			'heading' => esc_html__('Features', 'funero'),
			'params'  => [
				'funero_feature' => [
					'type'    => 'text',
					'heading' => esc_html__('Feature', 'funero'),
					'description' => esc_html__('Enter Feature.', 'funero'),
				],
			],
		],

		'funero_use_features_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for features?', 'funero'),
			'grid'    => 3,
		],

		'funero_features_typo' => [
			'type'     => 'typography',
			'group'    => 'Funero Features Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__description li, {{WRAPPER}} .aheto-pricing__list-item',
		],

		'funero_use_time_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for cost time?', 'funero'),
			'grid'    => 3,
		],

		'funero_time_typo' => [
			'type'     => 'typography',
			'group'    => 'Funero Cost Time Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-time',
		],

		'funero_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Mark as active?', 'funero'),
			'grid'    => 12,
		],

		'funero_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Background color', 'funero'),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--funero-classic' => 'background: {{VALUE}}',
			],
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'group'    => 'Funero Button',
		'prefix'     => 'funero_',
		'dependency' => ['template', ['funero_layout1']]
	]);
}

function funero_pricing_tables_layout1_dynamic_css($css, $shortcode)
{
	if (isset($shortcode->atts['funero_use_title_typo']) && $shortcode->atts['funero_use_title_typo'] && isset($shortcode->atts['funero_title_typo']) && !empty($shortcode->atts['funero_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['funero_title_typo']));
	}
	if (isset($shortcode->atts['funero_use_price_typo']) && $shortcode->atts['funero_use_price_typo'] && isset($shortcode->atts['funero_price_typo']) && !empty($shortcode->atts['funero_price_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['funero_price_typo']));
	}
	if (isset($shortcode->atts['funero_use_features_typo']) && $shortcode->atts['funero_use_features_typo'] && isset($shortcode->atts['funero_features_typo']) && !empty($shortcode->atts['funero_features_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography($shortcode->atts['funero_features_typo']));
	}
	if (isset($shortcode->atts['funero_use_time_typo']) && $shortcode->atts['funero_use_time_typo'] && isset($shortcode->atts['funero_time_typo']) && !empty($shortcode->atts['funero_time_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost-time'], $shortcode->parse_typography($shortcode->atts['funero_time_typo']));
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'funero_pricing_tables_layout1_dynamic_css', 10, 2);
