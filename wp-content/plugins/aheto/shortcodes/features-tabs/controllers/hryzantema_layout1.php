<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-tabs_register', 'hryzantema_features_tabs_layout1');

/**
 * Tabs shortcode
 */

function hryzantema_features_tabs_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Features Tabs 3', 'hryzantema' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_tabs', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_tab_link_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_tab_link_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_tab_link_typo', 'hryzantema_use_tab_link_typo', 'true' );



	$shortcode->add_params( [
		'hryzantema_tabs' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Tabs Items', 'hryzantema' ),
			'params'  => [
				'hryzantema_tabs_title'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Tab title', 'hryzantema' ),
				],
				'hryzantema_tabs_content'        => [
					'type'    => 'editor',
					'heading' => esc_html__( 'Tab content', 'hryzantema' ),
					'default' => esc_html__( 'Put your text...', 'hryzantema' ),
				],


			],
		],
		'hryzantema_use_tab_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for tab title?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_tab_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Tab link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
		],
	] );
}
function hryzantema_features_tabs_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_tab_link_typo'] ) && $shortcode->atts['hryzantema_use_tab_link_typo'] && isset( $shortcode->atts['hryzantema_tab_link_typo'] )&& ! empty( $shortcode->atts['hryzantema_tab_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-tabs__list-link'], $shortcode->parse_typography( $shortcode->atts['hryzantema_tab_link_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_features_tabs_dynamic_css', 'hryzantema_features_tabs_layout1_dynamic_css', 10, 2 );