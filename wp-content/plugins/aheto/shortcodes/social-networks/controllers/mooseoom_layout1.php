<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_social-networks_register', 'mooseoom_social_networks_layout1' );

/**
 * Social Networks
 */

function mooseoom_social_networks_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Social Networks 6', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );

	aheto_demos_add_dependency(['color', 'socials_align', 'socials_align_mob', 'scheme', 'networks', 'size', 'style', 'hovercolor_circle', 'hovercolor_default'], ['mooseoom_layout1'], $shortcode);

	$shortcode->add_dependecy( 'mooseoom_use_socials_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_socials_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_socials_typo', 'mooseoom_use_socials_typo', 'true' );

	$shortcode->add_params( [
		'mooseoom_use_socials_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for socials?', 'mooseoom' ),
			'grid'    => 3,
		],
		'mooseoom_socials_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Socials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-socials__link',
		],
	] );
}
function mooseoom_social_networks_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_socials_typo'] ) && ! empty( $shortcode->atts['mooseoom_socials_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-socials__link'], $shortcode->parse_typography( $shortcode->atts['mooseoom_socials_typo'] ) );
	}

	return $css;
}

add_filter('aheto_social_networks_dynamic_css', 'mooseoom_social_networks_layout1_dynamic_css', 10, 2);