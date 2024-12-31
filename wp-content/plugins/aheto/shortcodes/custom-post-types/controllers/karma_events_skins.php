<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_events_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_events_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];

	$aheto_addon_skins = array(
		'karma_events_skin-1' => 'Karma Events Skin 1',
	);

	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );

	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('karma_events_use_date_typo', 'skin', ['karma_events_skin-1']);
	$shortcode->add_dependecy('karma_events_date_typo', 'skin', 'karma_events_skin-1');
	$shortcode->add_dependecy('karma_events_date_typo', 'karma_events_use_date_typo', 'true');

	$shortcode->add_dependecy('karma_events_use_footer_typo', 'skin', ['karma_events_skin-1']);
	$shortcode->add_dependecy('karma_events_footer_typo', 'skin', 'karma_events_skin-1');
	$shortcode->add_dependecy('karma_events_footer_typo', 'karma_events_use_footer_typo', 'true');


	$shortcode->add_params( [
		'karma_events_use_date_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_date_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Events Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
		'karma_events_use_footer_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for footer?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_footer_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Events Footer Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__footer-item span',
		],
	] );

}

function karma_events_custom_post_types_skins_dynamic_css( $css, $shortcode ) {
	if ( isset($shortcode->atts['karma_events_use_date_typo']) && $shortcode->atts['karma_events_use_date_typo'] && isset($shortcode->atts['karma_events_date_typo']) && !empty($shortcode->atts['karma_events_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['karma_events_date_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_footer_typo']) && $shortcode->atts['karma_events_use_footer_typo'] && isset($shortcode->atts['karma_events_footer_typo']) && !empty($shortcode->atts['karma_events_footer_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__footer-item span'], $shortcode->parse_typography($shortcode->atts['karma_events_footer_typo']));
	}

	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'karma_events_custom_post_types_skins_dynamic_css', 10, 2 );