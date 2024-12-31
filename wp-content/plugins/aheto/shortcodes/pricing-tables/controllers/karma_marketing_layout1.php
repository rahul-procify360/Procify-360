<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'karma_marketing_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_marketing_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout1', [
		'title' => esc_html__ ( 'Pricing Tables 12', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	] );

	$shortcode->add_dependecy('karma_marketing_title', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_line_color', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_btn_border_color', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_price_border_color', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_desc_main', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_link_title', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_link_url', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_pricings', 'template', 'karma_marketing_layout1');

	$shortcode->add_dependecy('karma_marketing_use_heading_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_heading_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_heading_typo', 'karma_marketing_use_heading_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_price_typo', 'template', [ 'karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_price_typo', 'template', [ 'karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_price_typo', 'karma_marketing_use_price_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_desc_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_desc_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_desc_typo', 'karma_marketing_use_desc_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_link_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_link_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_link_typo', 'karma_marketing_use_link_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_category_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_category_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_category_typo', 'karma_marketing_use_category_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_active_category_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_active_category_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_active_category_typo', 'karma_marketing_use_active_category_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_main_title_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_main_title_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_main_title_typo', 'karma_marketing_use_main_title_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_use_main_desc_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_main_desc_typo', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_main_desc_typo', 'karma_marketing_use_main_desc_typo', 'true');

	$shortcode->add_params([
		'karma_marketing_use_heading_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_heading_typo'           => [
			'type'     => 'typography',
			'group'    => 'Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title',
		],
		'karma_marketing_use_main_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Main Title?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_main_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Main Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__main-title',
		],
		'karma_marketing_use_main_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Main Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_main_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Main Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__main-desc',
		],
		'karma_marketing_use_price_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_price_typo'             => [
			'type'     => 'typography',
			'group'    => 'Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-price',
		],
		'karma_marketing_use_desc_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_desc_typo'              => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-descr *',
		],
		'karma_marketing_use_category_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Categories?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_category_typo'              => [
			'type'     => 'typography',
			'group'    => 'Categories Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-link',
		],
		'karma_marketing_use_active_category_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Active Categories?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_active_category_typo'              => [
			'type'     => 'typography',
			'group'    => 'Active Categories Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .active .aheto-pricing__list-link',
		],
		'karma_marketing_use_link_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Main Links?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_link_typo'              => [
			'type'     => 'typography',
			'group'    => 'Main Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__main-link',
		],
		'karma_marketing_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'karma'),
			'default' => esc_html__('Put your text...', 'karma'),
		],
		'karma_marketing_desc_main' => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description Main', 'karma'),
			'default' => esc_html__('Put your text...', 'karma'),
		],
		'karma_marketing_link_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'karma'),
			'default' => esc_html__('LEARN MORE', 'karma'),
		],
		'karma_marketing_link_url' => [
			'type'    => 'text',
			'heading' => esc_html__('Link URL', 'karma'),
			'default' => esc_html__('#', 'karma'),
		],
		'karma_marketing_line_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Line background', 'karma'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-pricing__main-title::after' => 'background-color: {{VALUE}}'],
		],
		'karma_marketing_btn_border_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Category button border color', 'karma'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-pricing__list-link' => 'border-color: {{VALUE}}'],
		],
		'karma_marketing_price_border_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Price border color', 'karma'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-pricing__box-price' => 'border-color: {{VALUE}}'],
		],

		'karma_marketing_pricings'               => [
			'type'    => 'group',
			'heading' => esc_html__('Consult Pricing Items', 'karma'),
			'params'  => [
				'karma_marketing_pricings_heading' => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_marketing_pricings_title'   => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_marketing_pricings_price'   => [
					'type'    => 'text',
					'heading' => esc_html__('Price', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_marketing_pricings_descr'   => [
					'type'    => 'editor',
					'heading' => esc_html__('Description', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_marketing_active'          => [
					'type'    => 'switch',
					'heading' => esc_html__('Active element?', 'karma'),
					'grid'    => 3,
				],
			],
		],

	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'karma_marketing_pricing_layout1_'
	] , 'karma_marketing_pricings');

}

function karma_marketing_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_marketing_use_heading_typo']) && !empty($shortcode->atts['karma_marketing_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-title'], $shortcode->parse_typography($shortcode->atts['karma_marketing_heading_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_price_typo']) && !empty($shortcode->atts['karma_marketing_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-price'], $shortcode->parse_typography($shortcode->atts['karma_marketing_price_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_desc_typo']) && !empty($shortcode->atts['karma_marketing_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__box-descr'], $shortcode->parse_typography($shortcode->atts['karma_marketing_desc_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_category_typo']) && !empty($shortcode->atts['karma_marketing_category_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__list-link'], $shortcode->parse_typography($shortcode->atts['karma_marketing_category_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_active_category_typo']) && !empty($shortcode->atts['karma_marketing_active_category_typo']) ) {
		\aheto_add_props($css['global']['%1$s .active .aheto-pricing__list-link'], $shortcode->parse_typography($shortcode->atts['karma_marketing_active_category_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_link_typo']) && !empty($shortcode->atts['karma_marketing_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__main-link'], $shortcode->parse_typography($shortcode->atts['karma_marketing_link_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_main_title_typo']) && !empty($shortcode->atts['karma_marketing_main_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__main-title'], $shortcode->parse_typography($shortcode->atts['karma_marketing_main_title_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_use_main_desc_typo']) && !empty($shortcode->atts['karma_marketing_main_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__main-desc'], $shortcode->parse_typography($shortcode->atts['karma_marketing_main_desc_typo']));
	}

	if (!empty($shortcode->atts['karma_marketing_line_color'])) {
		$color = Sanitize::color($shortcode->atts['karma_marketing_line_color']);
		$css['global']['%1$s .aheto-pricing__main-title::after']['background-color'] = $color;
	}
	if (!empty($shortcode->atts['karma_marketing_btn_border_color'])) {
		$color = Sanitize::color($shortcode->atts['karma_marketing_btn_border_color']);
		$css['global']['%1$s .aheto-pricing__list-link']['border-color'] = $color;
	}

	if (!empty($shortcode->atts['karma_marketing_price_border_color'])) {
		$color = Sanitize::color($shortcode->atts['karma_marketing_price_border_color']);
		$css['global']['%1$s .aheto-pricing__box-price']['border-color'] = $color;
	}

	return $css;

}

add_filter('aheto_pricing_tables_dynamic_css', 'karma_marketing_pricing_tables_layout1_dynamic_css', 10, 2);

