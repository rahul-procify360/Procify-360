<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'karma_education_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_education_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('karma_education_layout1', [
		'title' => esc_html__('Pricing Tables 10', 'karma'),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	]);

	aheto_demos_add_dependency(['heading'], ['karma_education_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_education_subtitle', 'template', 'karma_education_layout1');

	$shortcode->add_dependecy('karma_education_image', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_pricings', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_price_label', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_active', 'template', 'karma_education_layout1');

	$shortcode->add_dependecy('karma_education_use_heading_typo', 'template', ['karma_education_layout1']);
	$shortcode->add_dependecy('karma_education_heading_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_heading_typo', 'karma_education_use_heading_typo', 'true');

	$shortcode->add_dependecy('karma_education_use_subtitle_typo', 'template', ['karma_education_layout1']);
	$shortcode->add_dependecy('karma_education_subtitle_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_subtitle_typo', 'karma_education_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('karma_education_use_price_typo', 'template', ['karma_education_layout1']);
	$shortcode->add_dependecy('karma_education_price_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_price_typo', 'karma_education_use_price_typo', 'true');

	$shortcode->add_dependecy('karma_education_desc_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_desc_typo', 'karma_education_use_desc_typo', 'true');
    $shortcode->add_dependecy('karma_education_use_desc_typo', 'template', ['karma_education_layout1']);

	$shortcode->add_params([
		'karma_education_active'                 => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Active Item?', 'karma'),
		],
		'karma_education_use_heading_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_image'                => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Display Image', 'karma'),
		],
		'karma_education_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'karma'),
		],
		'karma_education_pricings'               => [
			'type'    => 'group',
			'heading' => esc_html__('Pricing Items', 'karma'),
			'params'  => [
				'karma_education_pricings_heading' => [
					'type'    => 'text',
					'heading' => esc_html__('Price', 'karma'),
				],
				'karma_education_pricings_label'   => [
					'type'    => 'text',
					'heading' => esc_html__('Label', 'karma'),
				],

			],
		],
		'karma_education_heading_typo'         => [
			'type'     => 'typography',
			'group'    => 'Karma Education Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'karma_education_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__subtitle',
		],
		'karma_education_use_price_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_price_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Education Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'karma_education_use_desc_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_desc_typo'            => [
			'type'     => 'typography',
			'group'    => 'Karma Education Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'karma_events_',
		'icons'      => true,
		'dependency' => ['template', ['karma_education_layout1'] ]
	]);
}

function karma_education_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_education_use_subtitle_typo']) && $shortcode->atts['karma_education_use_subtitle_typo'] && isset($shortcode->atts['karma_education_subtitle_typo']) && !empty($shortcode->atts['karma_education_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_education_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_education_use_heading_typo']) && $shortcode->atts['karma_education_use_heading_typo'] && isset($shortcode->atts['karma_education_heading_typo']) && !empty($shortcode->atts['karma_education_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['karma_education_heading_typo']));
	}
	if ( isset($shortcode->atts['karma_education_use_subtitle_typo']) && $shortcode->atts['karma_education_use_subtitle_typo'] && isset($shortcode->atts['karma_education_subtitle_typo']) && !empty($shortcode->atts['karma_education_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_education_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_education_use_price_typo']) && $shortcode->atts['karma_education_use_price_typo'] && isset($shortcode->atts['karma_education_price_typo']) && !empty($shortcode->atts['karma_education_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['karma_education_price_typo']));
	}
	if ( isset($shortcode->atts['karma_education_use_desc_typo']) && $shortcode->atts['karma_education_use_desc_typo'] && isset($shortcode->atts['karma_education_desc_typo']) && !empty($shortcode->atts['karma_education_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['karma_education_desc_typo']));
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'karma_education_pricing_tables_layout1_dynamic_css', 10, 2);

