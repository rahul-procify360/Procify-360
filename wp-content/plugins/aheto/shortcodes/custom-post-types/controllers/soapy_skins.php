<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'soapy_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function soapy_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'soapy_skin-1'  => 'Soapy skin 1',
		'soapy_skin-2'  => 'Soapy skin 2 (Active element)',
		'soapy_skin-3'  => 'Soapy skin 3 (Overlay)',
		'soapy_skin-4'  => 'Soapy skin 4 (For Product)',
		'soapy_skin-5'  => 'Soapy skin 5 (Labels) (For Product)',
		'soapy_skin-6'  => 'Soapy skin 6 (For Product)',
		'soapy_skin-7'  => 'Soapy skin 7 (Labels) (For Product Masonry)',
		'soapy_skin-8'  => 'Soapy skin 8 (Labels) (For Product Masonry)',
		'soapy_skin-9'  => 'Soapy skin 9 (Labels) (For Product Masonry)',
		'soapy_skin-10' => 'Soapy skin 10 (Border Soap)',
	);
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;
	$shortcode->add_dependecy('soapy_use_excerpt', 'skin', ['soapy_skin-1', 'soapy_skin-2','soapy_skin-3','soapy_skin-4','soapy_skin-5','soapy_skin-6',     'soapy_skin-7','soapy_skin-8',  'soapy_skin-9','soapy_skin-10']);
	$shortcode->add_dependecy('soapy_excerpt', 'skin',  ['soapy_skin-1', 'soapy_skin-2','soapy_skin-3','soapy_skin-4','soapy_skin-5','soapy_skin-6',     'soapy_skin-7','soapy_skin-8',  'soapy_skin-9','soapy_skin-10']);
	$shortcode->add_dependecy('soapy_excerpt', 'soapy_use_excerpt', 'true');
	$shortcode->add_dependecy('soapy_use_regular_price', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_regular_price', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_regular_price', 'soapy_use_regular_price', 'true');
	$shortcode->add_dependecy('soapy_use_sale_price', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_sale_price', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_sale_price', 'soapy_use_sale_price', 'true');
	$shortcode->add_dependecy('soapy_use_label', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_label', 'skin', ['soapy_skin-5', 'soapy_skin-7', 'soapy_skin-9']);
	$shortcode->add_dependecy('soapy_label', 'soapy_use_label', 'true');
	$shortcode->add_dependecy('soapy_date_use_typo', 'skin', ['soapy_skin-1', 'soapy_skin-2', 'soapy_skin-3', 'soapy_skin-10']);
	$shortcode->add_dependecy('soapy_date_typo', 'skin', ['soapy_skin-1', 'soapy_skin-2', 'soapy_skin-3', 'soapy_skin-10']);
	$shortcode->add_dependecy('soapy_date_typo', 'soapy_date_use_typo', 'true');
	$shortcode->add_dependecy('soapy_remove_arrow', 'skin', ['soapy_skin-10']);
	$shortcode->add_dependecy('soapy_link_use_typo', 'skin', ['soapy_skin-10']);
	$shortcode->add_dependecy('soapy_link_typo', 'skin', ['soapy_skin-10']);
	$shortcode->add_dependecy('soapy_link_typo', 'soapy_link_use_typo', 'true');
	$shortcode->add_params([
		'soapy_use_excerpt'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for excerpt?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_excerpt'           => [
			'type'     => 'typography',
			'group'    => 'Soapy Excerpt Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],
		'soapy_use_regular_price' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for old price?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_regular_price'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Old Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__price del .amount',
		],
		'soapy_use_sale_price'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for current price?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_sale_price'        => [
			'type'     => 'typography',
			'group'    => 'Soapy Current Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__price ins .amount, .aheto-cpt-article__price  .amount, .aheto-cpt-article__price .price',
		],
		'soapy_use_label'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_label'             => [
			'type'     => 'typography',
			'group'    => 'Soapy Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__label',
		],
		'soapy_date_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_date_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
		'soapy_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__links a',
		],
		'soapy_remove_arrow' => [
			'type'    => 'switch',
			'heading' => esc_html__('Remove arrow from link?', 'soapy'),
			'grid'    => 3,
		],
	]);
}

function soapy_cpt_skins_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_use_excerpt']) && $shortcode->atts['soapy_use_excerpt'] && isset($shortcode->atts['soapy_excerpt'])  && !empty($shortcode->atts['soapy_excerpt']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['soapy_excerpt']));
	}
	if ( isset($shortcode->atts['soapy_link_use_typo']) && $shortcode->atts['soapy_link_use_typo'] && isset($shortcode->atts['soapy_link_typo']) && !empty($shortcode->atts['soapy_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__links a'], $shortcode->parse_typography($shortcode->atts['soapy_link_typo']));
	}
	if ( isset($shortcode->atts['soapy_date_use_typo']) && $shortcode->atts['soapy_date_use_typo'] && isset($shortcode->atts['soapy_date_typo']) && !empty($shortcode->atts['soapy_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['soapy_date_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_regular_price']) && $shortcode->atts['soapy_use_regular_price'] && isset($shortcode->atts['soapy_regular_price']) && !empty($shortcode->atts['soapy_regular_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__price del .amount'], $shortcode->parse_typography($shortcode->atts['soapy_regular_price']));
	}
	if ( isset($shortcode->atts['soapy_use_sale_price']) && $shortcode->atts['soapy_use_sale_price'] && isset($shortcode->atts['soapy_sale_price']) && !empty($shortcode->atts['soapy_sale_price']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__price ins .amount , .aheto-cpt-article__price .amount, .aheto-cpt-article__price .price'], $shortcode->parse_typography($shortcode->atts['soapy_sale_price']));
	}
	if ( isset($shortcode->atts['soapy_use_label']) && $shortcode->atts['soapy_use_label'] && isset($shortcode->atts['soapy_sale_label']) && !empty($shortcode->atts['soapy_sale_label']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__label'], $shortcode->parse_typography($shortcode->atts['soapy_label']));
	}
	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'soapy_cpt_skins_dynamic_css', 10, 2 );