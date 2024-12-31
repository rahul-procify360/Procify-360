<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'karma_sass_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_sass_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('karma_sass_layout1', [
		'title' => esc_html__('Karma Education Simple', 'karma'),
		'image' => $preview_dir . 'karma_sass_layout1.jpg',
	]);
	aheto_demos_add_dependency(['heading', 'features_align', 'link', 'link_style', 'features', 'price', 'link_url', 'link_title', 'link_color', 'link_border', 'link_color_hover',  'link_border_hover', 'link_bg', 'link_bg_hover' ], ['karma_sass_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_sass_bg_title_color', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_mark_color', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_divider_color', 'template', ['karma_sass_layout1']);

	$shortcode->add_dependecy('karma_sass_use_subtitle_typo', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_subtitle_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_subtitle_typo', 'karma_sass_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('karma_sass_use_price_typo', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_price_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_price_typo', 'karma_sass_use_price_typo', 'true');

	$shortcode->add_dependecy('karma_sass_use_desc_typo', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_desc_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_desc_typo', 'karma_sass_use_desc_typo', 'true');

	$shortcode->add_dependecy('karma_sass_use_link_typo', 'template', ['karma_sass_layout1']);
	$shortcode->add_dependecy('karma_sass_link_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_link_typo', 'karma_sass_use_link_typo', 'true');
	$shortcode->add_params([

		'karma_sass_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'karma_sass_use_price_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Price?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_price_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],
		'karma_sass_use_desc_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_desc_typo'            => [
			'type'     => 'typography',
			'group'    => 'Karma Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__description li',
		],
		'karma_sass_use_link_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Button?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_link_typo'            => [
			'type'     => 'typography',
			'group'    => 'Karma Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__content .aheto-btn',
		],
		'karma_sass_bg_title_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Title Background color', 'karma' ),
			'default'   => '#f3f9ff',
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing__header' => 'background-color: {{VALUE}};',
			],
		],
		'karma_sass_mark_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Mark color', 'karma' ),
			'default'   => '#4fb557',
			'selectors' => [
				'{{WRAPPER}} li::before' => 'color: {{VALUE}};',
			],
		],
		'karma_sass_divider_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Divider color', 'karma' ),
			'default'   => '#f7f7f7',
			'selectors' => [
				'{{WRAPPER}}  ul li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
			],
		],
	]);
}

function karma_sass_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_sass_use_subtitle_typo']) && $shortcode->atts['karma_sass_use_subtitle_typo'] && isset($shortcode->atts['karma_sass_subtitle_typo']) && !empty($shortcode->atts['karma_sass_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['karma_sass_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_sass_use_price_typo']) && $shortcode->atts['karma_sass_use_price_typo'] && isset($shortcode->atts['karma_sass_price_typo']) && !empty($shortcode->atts['karma_sass_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['karma_sass_price_typo']));
	}
	if ( isset($shortcode->atts['karma_sass_use_desc_typo']) && $shortcode->atts['karma_sass_use_desc_typo'] && isset($shortcode->atts['karma_sass_desc_typo']) && !empty($shortcode->atts['karma_sass_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography($shortcode->atts['karma_sass_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_sass_use_link_typo']) && $shortcode->atts['karma_sass_use_link_typo'] && isset($shortcode->atts['karma_sass_link_typo']) && !empty($shortcode->atts['karma_sass_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__content .aheto-btn'], $shortcode->parse_typography($shortcode->atts['karma_sass_link_typo']));
	}
	if ( isset( $shortcode->atts['karma_sass_bg_title_color'] ) && ! empty( $shortcode->atts['karma_sass_bg_title_color'] ) ) {
		$color       = Sanitize::color( $shortcode->atts['karma_sass_bg_title_color'] );
		$css['global']['%1$s  .aheto-pricing__header']['background-color'] = $color;
	}
	if ( isset( $shortcode->atts['karma_sass_mark_color'] ) && ! empty( $shortcode->atts['karma_sass_bg_title_color'] ) ) {
		$color       = Sanitize::color( $shortcode->atts['karma_sass_mark_color'] );
		$css['global']['%1$s  li::before']['color'] = $color;
	}
	if ( isset( $shortcode->atts['karma_sass_divider_color'] ) && ! empty( $shortcode->atts['karma_sass_divider_color'] ) ) {
		$color       = Sanitize::color( $shortcode->atts['karma_sass_divider_color'] );
		$css['global']['%1$s   ul li:not(:last-child)']['border-bottom-color'] = $color;
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'karma_sass_pricing_tables_layout1_dynamic_css', 10, 2);

