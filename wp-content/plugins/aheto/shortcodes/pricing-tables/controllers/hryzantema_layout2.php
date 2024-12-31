<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'hryzantema_pricing_tables_layout2');

/**
 * Heading Shortcode
 */

function hryzantema_pricing_tables_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'Pricing Tables 7', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );
	$shortcode->add_dependecy('hryzantema_pricings', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_use_label_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_label_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_label_typo', 'hryzantema_use_label_typo', 'true');
	$shortcode->add_dependecy('hryzantema_use_links_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_links_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_links_typo', 'hryzantema_use_links_typo', 'true');

	$shortcode->add_params( [
		'hryzantema_pricings' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Pricing Items', 'hryzantema' ),
			'params'  => [
				'hryzantema_pricing_heading_tag' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Element tag for Heading', 'hryzantema' ),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'h4',
					'grid'    => 5,
				],

				'hryzantema_pricings_heading'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Category', 'hryzantema' ),
					'default' => esc_html__( 'Put your text...', 'hryzantema' ),
				],
				'hryzantema_pricings_title'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Category heading', 'hryzantema' ),
					'default' => esc_html__( 'Put your text...', 'hryzantema' ),
				],
				'hryzantema_pricings_label'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Category label', 'hryzantema' ),
					'default' => esc_html__( '', 'hryzantema' ),
				],
				'hryzantema_pricings_price'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Category price', 'hryzantema' ),
					'default' => esc_html__( 'Put your text...', 'hryzantema' ),
				],
				'hryzantema_pricings_descr'        => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Category description', 'hryzantema' ),
					'default' => esc_html__( 'Put your text...', 'hryzantema' ),
				],


			],
		],
		'hryzantema_use_label_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for label?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_label_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__box-title span',
		],
		'hryzantema_use_links_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for links?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_links_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__list-link',
		],
	]);

}
function hryzantema_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_label_typo'] ) && $shortcode->atts['hryzantema_use_label_typo'] && isset( $shortcode->atts['hryzantema_label_typo'] ) && ! empty( $shortcode->atts['hryzantema_label_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__box-title span'], $shortcode->parse_typography( $shortcode->atts['hryzantema_label_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_links_typo'] ) && $shortcode->atts['hryzantema_use_links_typo'] && isset( $shortcode->atts['hryzantema_links_typo'] ) && ! empty( $shortcode->atts['hryzantema_links_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-pricing__list-link'], $shortcode->parse_typography( $shortcode->atts['hryzantema_links_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'hryzantema_pricing_tables_layout2_dynamic_css', 10, 2 );

