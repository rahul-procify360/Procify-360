<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'bizy_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function bizy_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('bizy_layout1', [
		'title' => esc_html__('Bizy Yellow', 'bizy'),
		'image' => $preview_dir . 'bizy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['heading'], ['bizy_layout1'], $shortcode);
	$shortcode->add_dependecy('bizy_subtitle', 'template', 'bizy_layout1');


    $shortcode->add_dependecy('bizy_pricings', 'template', 'bizy_layout1');
    $shortcode->add_dependecy('bizy_price', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_price_label', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_active', 'template', 'bizy_layout1');

	$shortcode->add_dependecy('bizy_use_heading_typo', 'template', ['bizy_layout1']);
	$shortcode->add_dependecy('bizy_heading_typo', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_heading_typo', 'bizy_use_heading_typo', 'true');

	$shortcode->add_dependecy('bizy_use_subtitle_typo', 'template', ['bizy_layout1']);
	$shortcode->add_dependecy('bizy_subtitle_typo', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_subtitle_typo', 'bizy_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('bizy_use_price_typo', 'template', ['bizy_layout1']);
	$shortcode->add_dependecy('bizy_price_typo', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_price_typo', 'bizy_use_price_typo', 'true');

	$shortcode->add_dependecy('bizy_desc_typo', 'template', 'bizy_layout1');
	$shortcode->add_dependecy('bizy_desc_typo', 'bizy_use_desc_typo', 'true');
    $shortcode->add_dependecy('bizy_use_desc_typo', 'template', ['bizy_layout1']);

	$shortcode->add_params([
		'bizy_active'                 => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Active Item?', 'bizy'),
		],
		'bizy_use_heading_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'bizy'),
			'grid'    => 3,
		],
		'bizy_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'bizy'),
        ],
        'bizy_price' => [
            'type'    => 'text',
            'heading' => esc_html__('Price', 'bizy'),
        ],
		'bizy_pricings'               => [
			'type'    => 'group',
			'heading' => esc_html__('Pricing Items', 'bizy'),
			'params'  => [
				'bizy_pricings_label'   => [
					'type'    => 'text',
					'heading' => esc_html__('Label', 'bizy'),
				],

			],
		],
		'bizy_heading_typo'         => [
			'type'     => 'typography',
			'group'    => 'Bizy Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'bizy_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'bizy'),
			'grid'    => 3,
		],
		'bizy_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Bizy Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__subtitle',
		],
		'bizy_use_price_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'bizy'),
			'grid'    => 3,
		],
		'bizy_price_typo'           => [
			'type'     => 'typography',
			'group'    => 'Bizy Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'bizy_use_desc_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'bizy'),
			'grid'    => 3,
		],
		'bizy_desc_typo'            => [
			'type'     => 'typography',
			'group'    => 'Bizy Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'bizy_events_',
		'group'      => esc_html__( 'Bizy Button Settings', 'bizy' ),
		'icons'      => true,
		'dependency' => ['template', ['bizy_layout1'] ]
	]);
}

function bizy_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['bizy_use_subtitle_typo']) && $shortcode->atts['bizy_use_subtitle_typo'] && isset($shortcode->atts['bizy_subtitle_typo']) && !empty($shortcode->atts['bizy_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['bizy_subtitle_typo']));
	}
	if ( isset($shortcode->atts['bizy_use_heading_typo']) && $shortcode->atts['bizy_use_heading_typo'] && isset($shortcode->atts['bizy_heading_typo']) && !empty($shortcode->atts['bizy_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['bizy_heading_typo']));
	}
	if ( isset($shortcode->atts['bizy_use_subtitle_typo']) && $shortcode->atts['bizy_use_subtitle_typo'] && isset($shortcode->atts['bizy_subtitle_typo']) && !empty($shortcode->atts['bizy_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['bizy_subtitle_typo']));
	}
	if ( isset($shortcode->atts['bizy_use_price_typo']) && $shortcode->atts['bizy_use_price_typo'] && isset($shortcode->atts['bizy_price_typo']) && !empty($shortcode->atts['bizy_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['bizy_price_typo']));
	}
	if ( isset($shortcode->atts['bizy_use_desc_typo']) && $shortcode->atts['bizy_use_desc_typo'] && isset($shortcode->atts['bizy_desc_typo']) && !empty($shortcode->atts['bizy_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['bizy_desc_typo']));
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'bizy_pricing_tables_layout1_dynamic_css', 10, 2);

