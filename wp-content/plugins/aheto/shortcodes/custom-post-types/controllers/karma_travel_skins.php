<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_travel_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_travel_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'karma_travel_skin-1'  => 'Karma Travel skin 1 (For Product Masonry)',
		'karma_travel_skin-2'  => 'Karma Travel skin 2',
	);
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('karma_travel_use_excerpt', 'skin', ['karma_travel_skin-1']);
	$shortcode->add_dependecy('karma_travel_excerpt', 'skin',  ['karma_travel_skin-1']);
	$shortcode->add_dependecy('karma_travel_excerpt', 'karma_travel_use_excerpt', 'true');

	$shortcode->add_dependecy('karma_travel_use_price', 'skin', ['karma_travel_skin-1']);
	$shortcode->add_dependecy('karma_travel_price', 'skin',  ['karma_travel_skin-1']);
	$shortcode->add_dependecy('karma_travel_price', 'karma_travel_use_price', 'true');


	$shortcode->add_dependecy('karma_travel_use_footer_typo', 'skin', ['karma_travel_skin-2']);
	$shortcode->add_dependecy('karma_travel_footer_typo', 'skin', 'karma_travel_skin-2');
	$shortcode->add_dependecy('karma_travel_footer_typo', 'karma_travel_use_footer_typo', 'true');


	$shortcode->add_params([
		'karma_travel_use_excerpt'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for excerpt?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_excerpt'           => [
			'type'     => 'typography',
			'group'    => 'Karma Travel Excerpt Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],
		'karma_travel_use_price'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_price'           => [
			'type'     => 'typography',
			'group'    => 'Karma Travel Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__price',
		],
		'karma_travel_use_footer_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for footer?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_footer_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Travel Footer Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__footer-item span',
		],
	]);
}

function karma_travel_cpt_skins_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['karma_travel_use_excerpt']) && $shortcode->atts['karma_travel_use_excerpt'] && isset($shortcode->atts['karma_travel_excerpt'])  && !empty($shortcode->atts['karma_travel_excerpt']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['karma_travel_excerpt']));
	}
	if ( isset($shortcode->atts['karma_travel_use_price']) && $shortcode->atts['karma_travel_use_price'] && isset($shortcode->atts['karma_travel_price'])  && !empty($shortcode->atts['karma_travel_price']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__price'], $shortcode->parse_typography($shortcode->atts['karma_travel_price']));
	}
	if ( isset($shortcode->atts['karma_travel_use_footer_typo']) && $shortcode->atts['karma_travel_use_footer_typo'] && isset($shortcode->atts['karma_travel_footer_typo']) && !empty($shortcode->atts['karma_travel_footer_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__footer-item span'], $shortcode->parse_typography($shortcode->atts['karma_travel_footer_typo']));
	}

	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'karma_travel_cpt_skins_dynamic_css', 10, 2 );