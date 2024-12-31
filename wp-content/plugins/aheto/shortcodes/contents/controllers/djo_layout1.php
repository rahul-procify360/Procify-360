<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'djo_contents_layout1');

/**
 * Contents shortcode
 */

function djo_contents_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Content 3', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);

	aheto_demos_add_dependency(['faqs','first_is_opened','multi_active','title_typo', 'text_typo'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy( 'djo_light_version', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_use_desc', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'djo_use_desc', 'true' );
	$shortcode->add_params( [
		'djo_light_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light version?', 'djo' ),
			'grid'    => 3,
		],
		'djo_use_desc' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'djo' ),
			'grid'    => 6,
		],

		'djo_desc_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .djo-aheto-contents__desc',
		],
	] );
}
function djo_contents_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_desc']) && $shortcode->atts['djo_use_desc'] && isset($shortcode->atts['djo_desc_typo']) && !empty($shortcode->atts['djo_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .djo-aheto-contents__desc'], $shortcode->parse_typography($shortcode->atts['djo_desc_typo']));
	}

	return $css;
}

add_filter('aheto_contents_dynamic_css', 'djo_contents_layout1_dynamic_css', 10, 2);
