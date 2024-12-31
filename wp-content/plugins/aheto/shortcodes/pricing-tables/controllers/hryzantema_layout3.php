<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'hryzantema_pricing_tables_layout3');

/**
 * Heading Shortcode
 */

function hryzantema_pricing_tables_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'Pricing Tables 8', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout3.jpg',
	] );
	aheto_demos_add_dependency(['heading','price', 'description', 'features'], ['hryzantema_layout3' ], $shortcode);

	$shortcode->add_dependecy('hryzantema_active', 'template', 'hryzantema_layout3');

	$shortcode->add_dependecy( 'hryzantema_use_title_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'hryzantema_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_price_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_price_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_price_typo', 'hryzantema_use_price_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_features_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_features_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_features_typo', 'hryzantema_use_features_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_time_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_time_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_time_typo', 'hryzantema_use_time_typo', 'true' );

	$shortcode->add_params( [
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'hryzantema_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for price?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],
		'hryzantema_use_features_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for features?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_features_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Features Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__description li',
		],
		'hryzantema_use_time_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for cost time?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_time_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Cost Time Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-time',
		],
		'hryzantema_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Mark as active?', 'hryzantema' ),
			'grid'    => 12,
		],
	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'hryzantema_',
		'dependency' => [ 'template', ['hryzantema_layout3' ] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),

	] );
}
function hryzantema_pricing_tables_layout3_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] ) && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_price_typo'] ) && $shortcode->atts['hryzantema_use_price_typo'] && isset( $shortcode->atts['hryzantema_price_typo'] ) && ! empty( $shortcode->atts['hryzantema_price_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['hryzantema_price_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_features_typo'] ) && $shortcode->atts['hryzantema_use_features_typo'] && isset( $shortcode->atts['hryzantema_features_typo'] ) && ! empty( $shortcode->atts['hryzantema_features_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography( $shortcode->atts['hryzantema_features_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_time_typo'] ) && $shortcode->atts['hryzantema_use_time_typo'] && isset( $shortcode->atts['hryzantema_time_typo'] ) && ! empty( $shortcode->atts['hryzantema_time_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-time'], $shortcode->parse_typography( $shortcode->atts['hryzantema_time_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'hryzantema_pricing_tables_layout3_dynamic_css', 10, 2 );
