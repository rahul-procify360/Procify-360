<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_pricing-tables_register', 'ninedok_pricing_tables_layout1' );


/**
 * Pricing Tables Shortcode
 */

function ninedok_pricing_tables_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Pricing Tables 17', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );


	$shortcode -> add_dependecy ( 'ninedok_heading', 'template', 'ninedok_layout1');
	$shortcode -> add_dependecy ( 'ninedok_active', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_features', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_heading_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_heading_typo', 'ninedok_use_heading_typo', 'true' );
	$shortcode -> add_dependecy ( 'ninedok_use_price_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_price_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_price_typo', 'ninedok_use_price_typo', 'true' );

	aheto_demos_add_dependency ( ['description','price' ], [ 'ninedok_layout1' ], $shortcode );


	$shortcode -> add_params ( [
		'ninedok_heading' => [
			'type' => 'text',
			'heading' => esc_html__ ( 'Heading', 'ninedok' ),
			'description' => esc_html__ ( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'ninedok' ),
			'default' => esc_html__ ( 'Heading with [[ hightlight ]] text.', 'ninedok' ),
			'admin_label' => true,
		],
		'ninedok_heading_typo' => [
			'type' => 'typography',
			'group' => 'Ninedok Heading Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'ninedok_active' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Mark as active?', 'ninedok' ),
			'grid' => 12,
		],
		'ninedok_use_heading_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for heading?', 'ninedok' ),
			'grid' => 12,
		],
		'ninedok_box_shadow' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Enable box shadow?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_use_price_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Price?', 'ninedok' ),
			'grid'    => 12,
		],
		'ninedok_price_typo' => [
			'type'     => 'typography',
			'group'    => 'Ninedok Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		],
		'ninedok_features' => [
			'type' => 'group',
			'heading' => esc_html__('Features', 'ninedok'),
			'params' => [
				'ninedok_feature' => [
					'type' => 'text',
					'heading' => esc_html__('Feature', 'ninedok'),
				],
				'ninedok_mark' => [
					'type' => 'select',
					'heading' => esc_html__('Decoration', 'ninedok'),
					'default' => 'default',
					'options' => [
						'default' => esc_html__('Default', 'ninedok'),
						'line-through' => esc_html__('Line-through', 'ninedok'),
						'opacity' => esc_html__('Opacity', 'ninedok'),
					],
				],
			],
		],


	] );
	\Aheto\Params ::add_button_params ( $shortcode, [
		'add_button' => true,
		'prefix' => 'ninedok_narrow_',
		'dependency' => [ 'template', 'ninedok_layout1' ]
	] );

}

function ninedok_pricing_tables_layout1_dynamic_css ( $css, $shortcode )
{

	if ( !empty( $shortcode -> atts['ninedok_use_description_typo'] ) && !empty( $shortcode -> atts['ninedok_heading_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-pricing__title'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_heading_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['ninedok_use_price_typo'] ) && !empty( $shortcode -> atts['ninedok_use_price_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_use_price_typo'] ) );
	}
	return $css;
}

add_filter ( 'aheto_pricing_tables_dynamic_css', 'ninedok_pricing_tables_layout1_dynamic_css', 10, 2 );