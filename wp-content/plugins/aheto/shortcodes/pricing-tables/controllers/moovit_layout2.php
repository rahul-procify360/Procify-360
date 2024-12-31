<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'moovit_pricing_tables_layout2' );


/**
 * Pricing Tables Shortcode
 */

function moovit_pricing_tables_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Pricing Tables 16', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );


	$shortcode->add_dependecy( 'moovit_heading', 'template', [ 'moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_background', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_border', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_use_cost_typo', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_cost_typo', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_cost_typo', 'moovit_use_cost_typo', 'true' );

	aheto_demos_add_dependency( ['price', 'features'], [ 'moovit_layout2' ], $shortcode );


	$shortcode->add_params( [
		'moovit_heading'    => [
			'type'        => 'text',
			'heading'     => esc_html__( 'Heading', 'moovit' ),
			'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'moovit' ),
			'default'     => esc_html__( 'Heading with [[ hightlight ]] text.', 'moovit' ),
			'admin_label' => true,
		],
		'moovit_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'moovit' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--moovin-classic' => 'background: {{VALUE}}',
			],
		],
		'moovit_border'     => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Border color', 'moovit' ),
			'grid'      => 6,
			'default'   => '#223645',
			'selectors' => [
				'{{WRAPPER}} .aheto-pricing--moovin-classic' => 'border-top-color: {{VALUE}}',
			],
		],

		'moovit_use_cost_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for price?', 'moovit' ),
			'grid'    => 6,
		],

		'moovit_cost_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Price Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		]

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => [ 'template', ['moovit_layout2' ] ]
	] );

}

function moovit_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_border'] ) ) {
		$color                                     = Sanitize::color( $shortcode->atts['moovit_border'] );
		$css['global']['%1$s']['border-top-color'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_use_cost_typo'] ) && ! empty( $shortcode->atts['moovit_cost_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['moovit_cost_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'moovit_pricing_tables_layout2_dynamic_css', 10, 2 );
