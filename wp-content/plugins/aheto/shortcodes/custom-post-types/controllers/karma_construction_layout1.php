<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_construction_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function karma_construction_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('karma_construction_layout1', [
		'title' => esc_html__('Custom Post Type 6', 'karma'),
		'image' => $preview_dir . 'karma_construction_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_construction_title', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_add_filter', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_all_items_text', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_all_items_text', 'karma_construction_add_filter', 'true');
	$shortcode->add_dependecy('karma_construction_use_title_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_title_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_title_typo', 'karma_construction_use_title_typo', 'true');
	$shortcode->add_dependecy('karma_construction_use_filter_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_filter_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_filter_typo', 'karma_construction_use_filter_typo', 'true');
	$shortcode->add_dependecy('karma_construction_use_active_filter_typo', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_active_filter_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_active_filter_typo', 'karma_construction_use_active_filter_typo', 'true');

	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading','add_pagination', 'add_load_more', 'load_more_type', 'load_more_text', 'load_more_loading_text', 'spaces', 'spaces_lg', 'spaces_md', 'spaces_sm', 'spaces_xs' ], [ 'karma_construction_layout1' ], $shortcode );

	$shortcode->add_params( [
		'karma_construction_add_filter'     => [
			'type'        => 'switch',
			'heading'     => esc_html__('Add filters?', 'karma'),
			'description' => esc_html__('This will display filters on the top', 'karma_construction'),
			'grid'        => 6,
		],
		'karma_construction_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'karma'),
			'grid'    => 6,
		],
		'karma_construction_all_items_text' => [
			'type'    => 'text',
			'heading' => esc_html__('All items text', 'karma'),
			'default' => esc_html__('All Projects', 'karma'),
			'value'   => esc_html__('All Projects', 'karma'),
			'grid'    => 6,
		],
		'karma_construction_use_title_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_title_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-filter__name',
		],
		'karma_construction_use_filter_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for filter?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_filter_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Filter Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-filter__item a',
		],
		'karma_construction_use_active_filter_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for active filter?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_active_filter_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Active Filter Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-filter__item a.is-active',
		],
	] );
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'karma_construction_main_',
		'group' => 'Karma Construction Button',
		'dependency' => ['template', 'karma_construction_layout1']
	]);

}

function karma_construction_cpt_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_construction_use_title_typo']) && $shortcode->atts['karma_construction_use_title_typo'] && isset($shortcode->atts['karma_construction_title_typo']) && !empty($shortcode->atts['karma_construction_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-filter__name'], $shortcode->parse_typography($shortcode->atts['karma_construction_title_typo']));
	}

	if ( isset($shortcode->atts['karma_construction_use_filter_typo']) && $shortcode->atts['karma_construction_use_filter_typo'] && isset($shortcode->atts['karma_construction_filter_typo']) && !empty($shortcode->atts['karma_construction_filter_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-filter__item a'], $shortcode->parse_typography($shortcode->atts['karma_construction_filter_typo']));
	}
	if ( isset($shortcode->atts['karma_construction_use_active_filter_typo']) && $shortcode->atts['karma_construction_use_active_filter_typo'] && isset($shortcode->atts['karma_construction_active_filter_typo']) && !empty($shortcode->atts['karma_construction_active_filter_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-filter__item a.is-active'], $shortcode->parse_typography($shortcode->atts['karma_construction_active_filter_typo']));
	}


	return $css;
}
add_filter( 'aheto_cpt_dynamic_css', 'karma_construction_cpt_layout1_dynamic_css', 10, 2 );