<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'hryzantema_pricing_tables_layout1');

/**
 * Heading Shortcode
 */

function hryzantema_pricing_tables_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Pricing Tables 6', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_heading', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_active', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_background', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_border', 'template', 'hryzantema_layout1' );

	$shortcode->add_dependecy( 'hryzantema_use_features_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_features', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_features_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_features_typo', 'hryzantema_use_features_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_price_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_price_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_price_typo', 'hryzantema_use_price_typo', 'true' );
	$shortcode->add_params( [
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
		'hryzantema_features'          => [
			'type'    => 'group',
			'heading' => esc_html__('Features', 'hryzantema'),
			'params'  => [
				'hryzantema_feature' => [
					'type'    => 'text',
					'heading' => esc_html__('Feature', 'hryzantema'),
					'description' => esc_html__('Enter [ok] for output check-mark.', 'hryzantema'),
				],
				'hryzantema_crossed' => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Cross feature?', 'hryzantema' ),
				],
			],
		],
		'hryzantema_heading'    => [
			'type'        => 'text',
			'heading'     => esc_html__( 'Heading', 'hryzantema' ),
			'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'hryzantema' ),
			'default'     => esc_html__( 'Heading with [[ hightlight ]] text.', 'hryzantema' ),
			'admin_label' => true,
		],
		'hryzantema_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Mark as active?', 'hryzantema' ),
			'grid'    => 12,
		],
		'hryzantema_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--hr-classic' => 'background: {{VALUE}}',
			],
		],
		'hryzantema_border'     => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Border color', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '#223645',
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--hr-classic' => 'border-top-color: {{VALUE}}',
			],
		],
	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'hryzantema_',
		'dependency' => [ 'template', ['hryzantema_layout1' ] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),

	] );
}
function hryzantema_pricing_tables_layout1_dynamic_css($css, $shortcode) {
	if ( isset( $shortcode->atts['hryzantema_use_price_typo'] ) &&  $shortcode->atts['hryzantema_use_price_typo'] && isset( $shortcode->atts['hryzantema_price_typo'] ) && ! empty( $shortcode->atts['hryzantema_price_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['hryzantema_price_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_features_typo'] ) && $shortcode->atts['hryzantema_use_features_typo'] && isset( $shortcode->atts['hryzantema_features_typo'] ) && ! empty( $shortcode->atts['hryzantema_features_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography( $shortcode->atts['hryzantema_features_typo'] ) );
	}
	if (!empty($shortcode->atts['hryzantema_background'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_background']);
		$css['global']['%1$s .aheto-pricing--hr-classic']['background'] = $color;
	}
	if (!empty($shortcode->atts['hryzantema_border'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_border']);
		$css['global']['%1$s .aheto-pricing--hr-classic']['border-top-color'] = $color;
	}
	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'hryzantema_pricing_tables_layout1_dynamic_css', 10, 2);

