<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'mooseoom_pricing_tables_layout1' );


/**
 * Pricing Tables Shortcode
 */

function mooseoom_pricing_tables_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Pricing Tables 13', 'aheto' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );
	$shortcode->add_dependecy('mooseoom_use_price_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_price_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_price_typo', 'mooseoom_use_price_typo', 'true');

	$shortcode->add_dependecy('mooseoom_heading', 'template', ['mooseoom_layout1']);
	$shortcode->add_dependecy('mooseoom_active', 'template', ['mooseoom_layout1']);

	$shortcode->add_dependecy('mooseoom_use_heading_typo', 'template', ['mooseoom_layout1']);
	$shortcode->add_dependecy('mooseoom_heading_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_heading_typo', 'mooseoom_use_heading_typo', 'true');

	$shortcode->add_dependecy('mooseoom_background', 'template', 'mooseoom_layout1');

	$shortcode->add_dependecy('mooseoom_use_item_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_item_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_item_typo', 'mooseoom_use_item_typo', 'true');

	aheto_demos_add_dependency(['features', 'price'], ['mooseoom_layout1'], $shortcode);


	$shortcode->add_params( [
		'mooseoom_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Background color', 'aheto'),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--mooseoom-classic' => 'background: {{VALUE}}!important',
			],
		],
		'mooseoom_use_price_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'aheto'),
			'grid'    => 3,
		],

		'mooseoom_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],
		'mooseoom_heading'      => [
			'type'        => 'text',
			'heading'     => esc_html__('Heading', 'aheto'),
			'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'aheto'),
			'default'     => esc_html__('Heading with [[ hightlight ]] text.', 'aheto'),
			'admin_label' => true,
		],
		'mooseoom_active'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Mark as active?', 'aheto'),
			'grid'    => 12,
		],
		'mooseoom_use_heading_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'aheto'),
			'grid'    => 3,
		],

		'mooseoom_heading_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'mooseoom_use_item_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for item?', 'aheto'),
			'grid'    => 3,
		],

		'mooseoom_item_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Item Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-item',
		],
	] );

	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'mooseoom_',
		'dependency' => ['template', ['mooseoom_layout1']]
	]);
}
function mooseoom_pricing_tables_layout1_dynamic_css( $css, $shortcode ) {
	if ( ! empty( $shortcode->atts['mooseoom_use_price_typo'] ) && ! empty( $shortcode->atts['mooseoom_price_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['mooseoom_price_typo'] ) );
	}
	if ( !empty($shortcode->atts['mooseoom_background']) ) {
		$color                               = Sanitize::color($shortcode->atts['mooseoom_background']);
		$css['global']['%1$s']['background'] = $color;
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_heading_typo'] ) && ! empty( $shortcode->atts['mooseoom_heading_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography( $shortcode->atts['mooseoom_heading_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_item_typo'] ) && ! empty( $shortcode->atts['mooseoom_item_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__list-item'], $shortcode->parse_typography( $shortcode->atts['mooseoom_item_typo'] ) );
	}

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'mooseoom_pricing_tables_layout1_dynamic_css', 10, 2);

