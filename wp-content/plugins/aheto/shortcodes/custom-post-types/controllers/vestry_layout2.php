<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'vestry_custom_post_types_layout2' );

/**
 * Custom Post Type
 */

function vestry_custom_post_types_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'vestry_layout2', [
		'title' => esc_html__( 'Custom Post Type 17', 'vestry' ),
		'image' => $preview_dir . 'vestry_layout2.jpg',
	] );
  
	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'add_pagination', 'add_filter', 'spaces', 'item_per_row', 'spaces_md', 'item_per_row_md', 'spaces_sm', 'item_per_row_sm', 'spaces_xs', 'item_per_row_xs' ], [ 'vestry_layout2' ], $shortcode );

	$shortcode->add_dependecy('vestry_use_paginations', 'template', 'vestry_layout2');
	$shortcode->add_dependecy('vestry_paginations_typo', 'template', 'vestry_layout2');
	$shortcode->add_dependecy('vestry_paginations_typo', 'vestry_use_paginations', 'true');

	$shortcode->add_params([
		'vestry_use_paginations' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add typography for pagination?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_paginations_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Pagination Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .page-numbers',
		],
	]);

}

function vestry_cpt_layout2_dynamic_css($css, $shortcode)
{
	
	if (!empty($shortcode->atts['vestry_use_pagination_top']) && !empty($shortcode->atts['vestry_pagination_typo'])) {
		\aheto_add_props($css['global']['%1$s .page-numbers'], $shortcode->parse_typography($shortcode->atts['vestry_pagination_typo']));
	}

	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'vestry_cpt_layout2_dynamic_css', 10, 2);