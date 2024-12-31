<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'famulus_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function famulus_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'famulus_skin-2' => 'Famulus modern skin',
		'famulus_skin-3' => 'Famulus modern light date skin',
		'famulus_skin-4' => 'Famulus light skin',
		'famulus_skin-5' => 'Famulus light skin category',
		'famulus_skin-6' => 'Famulus modern skin category',
		'famulus_skin-7' => 'Famulus centered',
	);
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('famulus_date_use_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-4', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_date_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-4', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_date_typo', 'famulus_date_use_typo', 'true');

	$shortcode->add_dependecy('famulus_date_loc_use_typo', 'skin', ['famulus_skin-3']);
	$shortcode->add_dependecy('famulus_date_loc_typo', 'skin', ['famulus_skin-3']);
	$shortcode->add_dependecy('famulus_date_loc_typo', 'famulus_date_loc_use_typo', 'true');

	$shortcode->add_dependecy('famulus_desc_use_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_desc_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_desc_typo', 'famulus_desc_use_typo', 'true');
	$shortcode->add_dependecy('famulus_author_use_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-4', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_author_typo', 'skin', ['famulus_skin-2', 'famulus_skin-3', 'famulus_skin-4', 'famulus_skin-7']);
	$shortcode->add_dependecy('famulus_author_typo', 'famulus_author_use_typo', 'true');
	$shortcode->add_dependecy('famulus_highlight_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_highlight_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_highlight_typo', 'famulus_highlight_use_typo', 'true');
	$shortcode->add_dependecy('famulus_link_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_link_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_link_use_typo', 'true');
	$shortcode->add_dependecy('famulus_quote_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_quote_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_quote_typo', 'famulus_quote_use_typo', 'true');
	$shortcode->add_dependecy('famulus_quote_author_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_quote_author_typo', 'skin',  ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_quote_author_typo', 'famulus_quote_author_use_typo', 'true');
	$shortcode->add_dependecy('famulus_arrow_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_arrow_typo', 'skin',  ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_arrow_typo', 'famulus_arrow_use_typo', 'true');
	$shortcode->add_dependecy('famulus_blockq_use_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_blockq_typo', 'skin', ['famulus_skin-7']);
	$shortcode->add_dependecy('famulus_blockq_typo', 'famulus_blockq_use_typo', 'true');
	$shortcode->add_params([

		'famulus_date_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_date_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],

		'famulus_date_loc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date localization?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_date_loc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Date Localization Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date span',
		],

		'famulus_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt',
		],

		'famulus_author_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for author?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_author_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
		],
		'famulus_highlight_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_highlight_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__title  span',
		],

		'famulus_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__btn',
		],

		'famulus_quote_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for quote?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_quote_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Quote Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote',
		],

		'famulus_quote_author_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for quote author?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_quote_author_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Quote Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote cite',
		],
		'famulus_arrow_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for arrow?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_arrow_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__slider .swiper-button-prev, {{WRAPPER}} .aheto-cpt-article__slider .swiper-button-next',
		],
		'famulus_blockq_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for symbol?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_blockq_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote::before',
		],
	]);
}
function famulus_cpt_skin1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_date_use_typo']) && $shortcode->atts['famulus_date_use_typo'] && isset($shortcode->atts['famulus_date_typo']) && !empty($shortcode->atts['famulus_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['famulus_date_typo']));
	}
	if ( isset($shortcode->atts['famulus_date_loc_use_typo']) && $shortcode->atts['famulus_date_loc_use_typo'] && isset($shortcode->atts['famulus_date_loc_typo']) && !empty($shortcode->atts['famulus_date_loc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__date span'], $shortcode->parse_typography($shortcode->atts['famulus_date_loc_typo']));
	}
	if ( isset($shortcode->atts['famulus_desc_use_typo']) && $shortcode->atts['famulus_desc_use_typo'] && isset($shortcode->atts['famulus_desc_typo']) && !empty($shortcode->atts['famulus_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt'], $shortcode->parse_typography($shortcode->atts['famulus_desc_typo']));
	}
	if ( isset($shortcode->atts['famulus_highlight_use_typo']) && $shortcode->atts['famulus_highlight_use_typo'] && isset($shortcode->atts['famulus_highlight_typo']) && !empty($shortcode->atts['famulus_highlight_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__title  span'], $shortcode->parse_typography($shortcode->atts['famulus_highlight_typo']));
	}
	if ( isset($shortcode->atts['famulus_link_use_typo']) && $shortcode->atts['famulus_link_use_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__btn'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}
	if ( isset($shortcode->atts['famulus_quote_use_typo']) && $shortcode->atts['famulus_quote_use_typo'] && isset($shortcode->atts['famulus_quote_typo']) && !empty($shortcode->atts['famulus_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__quote'], $shortcode->parse_typography($shortcode->atts['famulus_quote_typo']));
	}
	if ( isset($shortcode->atts['famulus_quote_author_use_typo']) && $shortcode->atts['famulus_quote_author_use_typo'] && isset($shortcode->atts['famulus_quote_author_typo']) && !empty($shortcode->atts['famulus_quote_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__quote cite'], $shortcode->parse_typography($shortcode->atts['famulus_quote_author_typo']));
	}
	if ( isset($shortcode->atts['famulus_blockq_use_typo']) && $shortcode->atts['famulus_blockq_use_typo'] && isset($shortcode->atts['famulus_blockq_typo']) && !empty($shortcode->atts['famulus_blockq_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__quote::before'], $shortcode->parse_typography($shortcode->atts['famulus_blockq_typo']));
	}
	return $css;
}

add_filter('aheto_cpt_skin_dynamic_css', 'famulus_cpt_skin1_dynamic_css', 10, 2);