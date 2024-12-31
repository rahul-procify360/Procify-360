<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_pricing-tables_register', 'snapster_pricing_tables_layout7' );


/**
 * Pricing Tables Shortcode
 */

function snapster_pricing_tables_layout7( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'snapster_layout7', [
		'title' => esc_html__( 'Snapster Simple list', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout7.jpg',
	] );

	$shortcode->add_dependecy( 'snapster_simple_list', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_first_cell', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_second_cell', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_third_cell', 'template', 'snapster_layout7' );

	$shortcode->add_dependecy( 'snapster_use_title_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_title_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_title_typo', 'snapster_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_price_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_price_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_price_typo', 'snapster_use_price_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_currency_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_currency_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_currency_typo', 'snapster_use_currency_typo', 'true' );

	$shortcode->add_dependecy( 'snapster_use_cell_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_cell_typo', 'template', 'snapster_layout7' );
	$shortcode->add_dependecy( 'snapster_cell_typo', 'snapster_use_cell_typo', 'true' );

	$shortcode->add_params( [
		'snapster_first_cell'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for first cell', 'snapster' ),
			'default' => 'Name',
		],
		'snapster_second_cell'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for second cell', 'snapster' ),
			'default' => 'Price',
		],
		'snapster_third_cell'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for third cell', 'snapster' ),
			'default' => 'Add',
		],
		'snapster_simple_list'        => [
			'type'    => 'group',
			'heading' => esc_html__( 'Pricing items', 'snapster' ),
			'params'  => [

				'snapster_title'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'snapster' ),
					'default' => 'Title',
				],
				'snapster_currency' => [
					'type'        => 'text',
					'heading'     => esc_html__( 'Сurrency', 'snapster' ),
					'default'     => '$',
					'description' => esc_html__( 'Please, use the same currency for page.', 'snapster' ),
				],
				'snapster_price'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Price', 'snapster' ),
					'default' => '20',
				],

			]
		],
		'snapster_use_cell_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Cell text?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_cell_typo'     => [
			'type'     => 'typography',
			'group'    => 'Snapster Cell text Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__top-wrap > div',
		],
		'snapster_use_title_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Title?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Snapster Title Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__title',
		],
		'snapster_use_price_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Price?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_price_typo'        => [
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
		'snapster_currency_typo'     => [
			'type'     => 'typography',
			'group'    => 'Snapster Currency Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing-tables__currency',
		],
	] );
}

function snapster_pricing_tables_layout7_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['snapster_use_title_typo'] ) && ! empty( $shortcode->atts['snapster_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing-tables__title'], $shortcode->parse_typography( $shortcode->atts['snapster_title_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['snapster_use_price_typo'] ) && ! empty( $shortcode->atts['snapster_price_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing-tables__price'], $shortcode->parse_typography( $shortcode->atts['snapster_price_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['snapster_use_currency_typo'] ) && ! empty( $shortcode->atts['snapster_currency_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing-tables__currency'], $shortcode->parse_typography( $shortcode->atts['snapster_currency_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['snapster_use_cell_typo'] ) && ! empty( $shortcode->atts['snapster_cell_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing-tables__top-wrap > div'], $shortcode->parse_typography( $shortcode->atts['snapster_cell_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'snapster_pricing_tables_layout7_dynamic_css', 10, 2 );
