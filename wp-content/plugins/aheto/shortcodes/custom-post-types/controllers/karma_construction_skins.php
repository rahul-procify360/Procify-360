<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_construction_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_construction_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];

	$aheto_addon_skins = array(
		'karma_construction_skin-1' => 'Karma Construction Skin 1',
		'karma_construction_skin-2' => 'Karma Construction Skin 2',
	);

	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );

	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('karma_construction_use_date_typo', 'template', ['karma_construction_skin-2']);
	$shortcode->add_dependecy('karma_construction_date_typo', 'template', 'karma_construction_skin-2');
	$shortcode->add_dependecy('karma_construction_date_typo', 'karma_construction_use_date_typo', 'true');

	$shortcode->add_params( [
		'karma_construction_use_date_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_date_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
	] );

}

function karma_construction_custom_post_types_skins_dynamic_css( $css, $shortcode ) {
	if ( isset($shortcode->atts['karma_construction_use_date_typo']) && $shortcode->atts['karma_construction_use_date_typo'] && isset($shortcode->atts['karma_construction_date_typo']) && !empty($shortcode->atts['karma_construction_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['karma_construction_date_typo']));
	}

	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'karma_construction_custom_post_types_skins_dynamic_css', 10, 2 );