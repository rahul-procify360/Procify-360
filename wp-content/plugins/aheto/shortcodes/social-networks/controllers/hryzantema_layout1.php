<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'hryzantema_social_networks_layout1');

/**
 * HR Consult Socials
 */

function hryzantema_social_networks_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Social Networks 5', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_demos_add_dependency(['networks',	'size', 'color', 'socials_align', 'socials_align_mob','scheme'], ['hryzantema_layout1'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_dark_style', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_socials_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_socials_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_socials_typo', 'hryzantema_use_socials_typo', 'true' );
	$shortcode->add_params( [

		'hryzantema_dark_style' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark style for socials?', 'hryzantema' ),
			'grid'    => 3,
		],
		'hryzantema_use_socials_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for socials?', 'hryzantema' ),
			'grid'    => 3,
		],


		'hryzantema_socials_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Socials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-socials__link',
		],
	] );
}
function hryzantema_social_networks_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_socials_typo'] ) && $shortcode->atts['hryzantema_use_socials_typo'] && isset( $shortcode->atts['hryzantema_socials_typo'] ) && ! empty( $shortcode->atts['hryzantema_socials_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-socials__link'], $shortcode->parse_typography( $shortcode->atts['hryzantema_socials_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_social_networks_dynamic_css', 'hryzantema_social_networks_layout1_dynamic_css', 10, 2 );

