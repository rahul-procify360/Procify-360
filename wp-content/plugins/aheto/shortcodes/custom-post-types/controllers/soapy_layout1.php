<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'soapy_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function soapy_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Custom Post Type 15', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	$shortcode->add_dependecy('soapy_add_filter', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_all_items_text', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_all_items_text', 'soapy_add_filter', 'true');
	$shortcode->add_dependecy('soapy_use_arrow', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_arrow', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_arrow', 'soapy_use_arrow', 'true');

	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading','add_pagination', 'add_load_more', 'load_more_type', 'load_more_text', 'load_more_loading_text', 'spaces', 'spaces_lg', 'spaces_md', 'spaces_sm', 'spaces_xs' ], [ 'soapy_layout1' ], $shortcode );

	$shortcode->add_params( [
		'soapy_add_filter'     => [
			'type'        => 'switch',
			'heading'     => esc_html__('Add filters?', 'soapy'),
			'description' => esc_html__('This will display filters on the top', 'soapy'),
			'grid'        => 6,
		],
		'soapy_all_items_text' => [
			'type'    => 'text',
			'heading' => esc_html__('All items text', 'soapy'),
			'default' => esc_html__('All Projects', 'soapy'),
			'value'   => esc_html__('All Projects', 'soapy'),
			'grid'    => 6,
		],
		'soapy_use_arrow'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for arrows?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_arrow'             => [
			'type'     => 'typography',
			'group'    => 'Soapy Arrows Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .arrow-left, {{WRAPPER}} .arrow-right',
		],
	] );
}

function soapy_cpt_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_use_arrow']) && $shortcode->atts['soapy_use_arrow'] && isset($shortcode->atts['soapy_arrow']) && !empty($shortcode->atts['soapy_arrow']) ) {
		\aheto_add_props($css['global']['%1$s  .arrow-left, %1$s .arrow-right'], $shortcode->parse_typography($shortcode->atts['soapy_arrow']));
	}


	return $css;
}
add_filter( 'aheto_cpt_dynamic_css', 'soapy_cpt_layout1_dynamic_css', 10, 2 );