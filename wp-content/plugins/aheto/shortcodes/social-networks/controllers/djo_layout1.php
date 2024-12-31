<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'djo_social_networks_layout1');

/**
 * Social Networks
 */

function djo_social_networks_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Social Networks 2', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	] );

	aheto_demos_add_dependency(['networks', 'size','socials_align_mob','socials_align'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy( 'djo_light_version', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_use_link', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'djo_use_link', 'true' );
	$shortcode->add_params( [
		//Renaming to dark not working. This light set the dark style
		'djo_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark version?', 'djo' ),
			'grid'    => 3,
		],
		'djo_use_link' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'djo' ),
			'grid'    => 6,
		],

		'djo_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-socials__link',
		],
	] );
}
function djo_social_networks_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_link']) && $shortcode->atts['djo_use_link'] && isset($shortcode->atts['djo_link_typo']) && !empty($shortcode->atts['djo_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-socials__link'], $shortcode->parse_typography($shortcode->atts['djo_link_typo']));
	}

	return $css;
}

add_filter('aheto_social_networks_dynamic_css', 'djo_social_networks_layout1_dynamic_css', 10, 2);
