<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'famulus_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */

function famulus_pricing_tables_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Pricing Tables 4', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);
	aheto_demos_add_dependency(['heading', 'link', 'link_style', 'link_border_hover', 'link_border', 'link_bg_hover', 'link_bg', 'link_color_hover', 'link_color', 'features', 'price', 'link_url', 'link_title'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_active', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_hover', 'template', 'famulus_layout1');

	$shortcode->add_dependecy('famulus_border_radius', 'template', 'famulus_layout1');

	$shortcode->add_dependecy('famulus_use_title_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_use_title_typo', 'true');

	$shortcode->add_dependecy('famulus_use_titlehighlight_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_titlehighlight_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_titlehighlight_typo', 'famulus_use_titlehighlight_typo', 'true');

	$shortcode->add_dependecy('famulus_use_price_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_price_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_price_typo', 'famulus_use_price_typo', 'true');

	$shortcode->add_dependecy('famulus_subtitle', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_use_subtitle_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_subtitle_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_subtitle_typo', 'famulus_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('famulus_use_item_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_item_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_item_typo', 'famulus_use_item_typo', 'true');

	$shortcode->add_dependecy('famulus_use_btn_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_btn_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_btn_typo', 'famulus_use_btn_typo', 'true');

	$shortcode->add_params([
		'famulus_active'            => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Active Item?', 'famulus'),
		],
		'famulus_hover'            => [
			'type'    => 'checkbox',
			'heading' => esc_html__('Remove hover effect?', 'famulus'),
		],
		'famulus_border_radius'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Famulus border radius for block', 'famulus' ),
			'description' => esc_html__( 'Enter border radius block. Value must be with unit. For example: 5px', 'famulus' ),
			'selectors' => [ '{{WRAPPER}} .aheto-pricing--famulus-simple' => 'border-radius: {{VALUE}}; overflow: hidden' ],
			'grid'    => 3,
	],
		'famulus_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'famulus_use_titlehighlight_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_titlehighlight_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Title Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title span',
		],
		'famulus_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_price_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost',
		],
		'famulus_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'famulus'),
		],
		'famulus_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__subtitle',
		],
		'famulus_use_item_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for item?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_item_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Item Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-item p',
		],
		'famulus_use_btn_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for button?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_btn_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__btn',
		],
	]);
}

function famulus_pricing_tables_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_title_typo']) && $shortcode->atts['famulus_use_title_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_use_titlehighlight_typo']) && $shortcode->atts['famulus_use_titlehighlight_typo'] && isset($shortcode->atts['famulus_titlehighlight_typo']) && !empty($shortcode->atts['famulus_titlehighlight_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__title span'], $shortcode->parse_typography($shortcode->atts['famulus_titlehighlight_typo']));
	}
	if ( isset($shortcode->atts['famulus_use_subtitle_typo']) && $shortcode->atts['famulus_use_subtitle_typo'] && isset($shortcode->atts['famulus_subtitle_typo']) && !empty($shortcode->atts['famulus_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__subtitle'], $shortcode->parse_typography($shortcode->atts['famulus_subtitle_typo']));
	}
	if ( isset($shortcode->atts['famulus_use_price_typo']) && $shortcode->atts['famulus_use_price_typo'] && isset($shortcode->atts['famulus_price_typo']) && !empty($shortcode->atts['famulus_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__cost'], $shortcode->parse_typography($shortcode->atts['famulus_price_typo']));
	}
	if ( isset($shortcode->atts['famulus_use_item_typo']) && $shortcode->atts['famulus_use_item_typo'] && isset($shortcode->atts['famulus_item_typo']) && !empty($shortcode->atts['famulus_item_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__list-item p'], $shortcode->parse_typography($shortcode->atts['famulus_item_typo']));
	}
	if ( isset($shortcode->atts['famulus_use_btn_typo']) && $shortcode->atts['famulus_use_btn_typo'] && isset($shortcode->atts['famulus_btn_typo']) && !empty($shortcode->atts['famulus_btn_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing__btn'], $shortcode->parse_typography($shortcode->atts['famulus_btn_typo']));
	}
	if ( isset( $shortcode->atts['famulus_border_radius'] ) && ! empty( $shortcode->atts['famulus_border_radius'] ) ) {
		$radius                                 = Sanitize::size( $shortcode->atts['famulus_border_radius'] );
		$css['global']['%1$s']['border-radius'] = $radius;
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'famulus_pricing_tables_layout1_dynamic_css', 10, 2);

