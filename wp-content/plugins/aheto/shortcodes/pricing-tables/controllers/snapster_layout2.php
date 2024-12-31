<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'snapster_pricing_tables_layout2' );


/**
 * Pricing Tables Shortcode
 */

function snapster_pricing_tables_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'snapster_layout2', [
		'title' => esc_html__( 'Snapster Modern', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'snapster_modern', 'template', 'snapster_layout2' );

	$shortcode->add_dependecy( 'snapster_use_title_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_title_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_title_typo', 'snapster_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_subtitle_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_subtitle_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_subtitle_typo', 'snapster_use_subtitle_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_price_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_price_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_price_typo', 'snapster_use_price_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_currency_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_currency_typo', 'template', 'snapster_layout2' );
	$shortcode->add_dependecy( 'snapster_currency_typo', 'snapster_use_currency_typo', 'true' );

	$shortcode->add_params( [
		'snapster_modern' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Pricing items', 'snapster' ),
			'params'  => [

				'snapster_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'snapster' ),
					'description' => esc_html__( 'Please add your image.', 'snapster' ),
				],
				'snapster_title'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'snapster' ),
					'default'    => 'Title',
				],
				'snapster_subtitle'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Subtitle', 'snapster' ),
					'default'    => 'Subtitle',
				],
				'snapster_list'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'List', 'snapster' ),
					'description' => esc_html__( 'Please, separate every list item by line "|". For ex: First item|Second item.', 'snapster' ),
				],
				'snapster_currency'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Сurrency', 'snapster' ),
					'default'    => '$',
					'description' => esc_html__( 'Please, use the same currency for page.', 'snapster' ),
				],
				'snapster_price'          => [
					'type'    => 'text',
					'heading' => esc_html__( 'Price', 'snapster' ),
					'default'    => '20',
				],
			]
		],
		'snapster_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Title?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Title Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__title',
		],
		'snapster_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Subtitle?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Subtitle Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__subtitle',
		],
		'snapster_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Price?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Price Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__price',
		],
		'snapster_use_currency_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Currency?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_currency_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Currency Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__currency',
		],
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Snapster Images size', 'snapster' ),
		'prefix'     => 'snapster_modern_',
		'dependency' => ['template', ['snapster_layout2']]
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'add_label'  => esc_html__( 'Add icon for list items?', 'snapster' ),
		'prefix'     => 'snapster_modern_',
		'exclude'  => ['align'],
	], 'snapster_modern');
}

function snapster_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['snapster_use_title_typo']) && !empty($shortcode->atts['snapster_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing-tables__title'], $shortcode->parse_typography($shortcode->atts['snapster_title_typo']));
	}

	if ( !empty($shortcode->atts['snapster_use_subtitle_typo']) && !empty($shortcode->atts['snapster_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing-tables__subtitle'], $shortcode->parse_typography($shortcode->atts['snapster_subtitle_typo']));
	}

	if ( !empty($shortcode->atts['snapster_use_price_typo']) && !empty($shortcode->atts['snapster_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing-tables__price'], $shortcode->parse_typography($shortcode->atts['snapster_price_typo']));
	}

	if ( !empty($shortcode->atts['snapster_use_currency_typo']) && !empty($shortcode->atts['snapster_currency_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-pricing-tables__currency'], $shortcode->parse_typography($shortcode->atts['snapster_currency_typo']));
	}

	return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'snapster_pricing_tables_layout2_dynamic_css', 10, 2 );
