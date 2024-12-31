<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_shop_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_shop_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'karma_shop_skin-1'  => 'Karma Shop skin 1 (For Product)',
		'karma_shop_skin-2'  => 'Karma Shop skin 2',
	);
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;

	
	$shortcode->add_dependecy('karma_shop_use_regular_price', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_regular_price', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_regular_price', 'karma_shop_use_regular_price', 'true');

	$shortcode->add_dependecy('karma_shop_use_sale_price', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_sale_price', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_sale_price', 'karma_shop_use_sale_price', 'true');

	$shortcode->add_dependecy('karma_shop_use_label', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_label', 'skin', ['karma_shop_skin-1']);
	$shortcode->add_dependecy('karma_shop_label', 'karma_shop_use_label', 'true');

	$shortcode->add_dependecy('karma_shop_use_term_price', 'skin', ['karma_shop_skin-2']);
	$shortcode->add_dependecy('karma_shop_term_price', 'skin', ['karma_shop_skin-2']);
	$shortcode->add_dependecy('karma_shop_term_price', 'karma_shop_use_term_price', 'true');

	$shortcode->add_dependecy('karma_shop_use_term_span_price', 'skin', ['karma_shop_skin-2']);
	$shortcode->add_dependecy('karma_shop_term_span_price', 'skin', ['karma_shop_skin-2']);
	$shortcode->add_dependecy('karma_shop_term_span_price', 'karma_shop_use_term_span_price', 'true');
	$shortcode->add_params([
		'karma_shop_use_term_span_price' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for category?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_term_span_price'     => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Category Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__term span',
		],
		'karma_shop_use_term_price' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for term and date?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_term_price'     => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Term Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__term',
		],
		'karma_shop_use_regular_price' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for regular price?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_regular_price'     => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Regular Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__price del .amount, {{WRAPPER}} .aheto-cpt-article__price  .amount,{{WRAPPER}}  .aheto-cpt-article__price .price',
		],
		'karma_shop_use_sale_price'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for sale price?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_sale_price'        => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Sale Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__price ins .amount',
		],
		'karma_shop_use_label'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_label'             => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__label',
		],
		
	]);
}
function karma_shop_cpt_skins_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_shop_use_regular_price']) && $shortcode->atts['karma_shop_use_regular_price'] && isset($shortcode->atts['karma_shop_regular_price']) && !empty($shortcode->atts['karma_shop_regular_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__price del .amount,%1$s  .aheto-cpt-article__price .amount, %1$s .aheto-cpt-article__price .price'], $shortcode->parse_typography($shortcode->atts['karma_shop_regular_price']));
	}
	if ( isset($shortcode->atts['karma_shop_use_term_price']) && $shortcode->atts['karma_shop_use_term_price'] && isset($shortcode->atts['karma_shop_term_price']) && !empty($shortcode->atts['karma_shop_term_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__term'], $shortcode->parse_typography($shortcode->atts['karma_shop_term_price']));
	}
	if ( isset($shortcode->atts['karma_shop_use_term_span_price']) && $shortcode->atts['karma_shop_use_term_span_price'] && isset($shortcode->atts['karma_shop_term_span_price']) && !empty($shortcode->atts['karma_shop_term_span_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__term span'], $shortcode->parse_typography($shortcode->atts['karma_shop_term_span_price']));
	}
	if ( isset($shortcode->atts['karma_shop_use_sale_price']) && $shortcode->atts['karma_shop_use_sale_price'] && isset($shortcode->atts['karma_shop_sale_price']) && !empty($shortcode->atts['karma_shop_sale_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__price ins .amount '], $shortcode->parse_typography($shortcode->atts['karma_shop_sale_price']));
	}
	if ( isset($shortcode->atts['karma_shop_use_label']) && $shortcode->atts['karma_shop_use_label'] && isset($shortcode->atts['karma_shop_sale_label']) && !empty($shortcode->atts['karma_shop_sale_label']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__label'], $shortcode->parse_typography($shortcode->atts['karma_shop_sale_label']));
	}
	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'karma_shop_cpt_skins_dynamic_css', 10, 2 );