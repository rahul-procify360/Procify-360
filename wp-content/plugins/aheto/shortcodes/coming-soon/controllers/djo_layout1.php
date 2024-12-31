<?php

use Aheto\Helper;

add_action('aheto_before_aheto_coming-soon_register', 'djo_coming_soon_layout1');

/**
 * Coming Soon shortcode
 */

function djo_coming_soon_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/coming-soon/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Coming Soon 2', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);
	aheto_demos_add_dependency(['light','days_desktop','days_mobile','hours_desktop','hours_mobile','mins_desktop','mins_mobile','secs_desktop','secs_mobile', 'use_typo_numbers', 'typo_numbers', 'use_typo_caption', 'typo_caption'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy( 'djo_use_dot', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_dot_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_dot_typo', 'djo_use_dot', 'true' );
	$shortcode->add_params( [
		'djo_use_dot' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for dot?', 'djo' ),
			'grid'    => 6,
		],

		'djo_dot_typo' => [
			'type'     => 'typography',
			'group'    => 'Dot Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
		],
	] );
}
function djo_coming_soon_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_dot']) && $shortcode->atts['djo_use_dot'] && isset($shortcode->atts['djo_dot_typo']) && !empty($shortcode->atts['djo_dot_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography($shortcode->atts['djo_dot_typo']));
	}

	return $css;
}

add_filter('aheto_coming_soon_dynamic_css', 'djo_coming_soon_layout1_dynamic_css', 10, 2);
