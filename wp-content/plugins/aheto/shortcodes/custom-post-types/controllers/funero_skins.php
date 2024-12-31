<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'funero_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function funero_custom_post_types_layout1($shortcode) {

	// Custom skins
	$aheto_skins  = $shortcode->params['skin']['options'];
	$funero_skins = array(
		'funero_skin-1' => 'Funero skin 1 (Quote Format)',
		'funero_skin-2' => 'Funero skin 2 (Donations)',
		'funero_skin-3' => 'Funero skin 3 (Products)',
	);

	$all_skins                            = array_merge($aheto_skins, $funero_skins);
	$shortcode->params['skin']['options'] = $all_skins;
	$shortcode->add_dependecy('funero_link_text_skin', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_subtitle', 'skin', ['funero_skin-1']);

	$shortcode->add_dependecy('funero_link_text', 'skin', ['funero_skin-2']);

	$shortcode->add_dependecy('funero_use_excerpt', 'skin', 'funero_skin-2');
	$shortcode->add_dependecy('funero_excerpt', 'skin', 'funero_skin-2');
	$shortcode->add_dependecy('funero_excerpt', 'funero_use_excerpt', 'true');


	$shortcode->add_dependecy('funero_use_quote', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_quote', 'skin', 'funero_skin-1');
	$shortcode->add_dependecy('funero_quote', 'funero_use_quote', 'true');

	$shortcode->add_dependecy('funero_use_name', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_name', 'skin', 'funero_skin-1');
	$shortcode->add_dependecy('funero_name', 'funero_use_name', 'true');

	$shortcode->add_dependecy('funero_use_subtitle_typo', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_subtitle_typo', 'skin', 'funero_skin-1');
	$shortcode->add_dependecy('funero_subtitle_typo', 'funero_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('funero_use_link_typo', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_link_typo', 'skin', 'funero_skin-1');
	$shortcode->add_dependecy('funero_link_typo', 'funero_use_link_typo', 'true');

	$shortcode->add_dependecy('funero_use_quote_symbol', 'skin', ['funero_skin-1']);
	$shortcode->add_dependecy('funero_quote_symbol', 'skin', 'funero_skin-1');
	$shortcode->add_dependecy('funero_quote_symbol', 'funero_use_quote_symbol', 'true');


	$shortcode->add_params([
		'funero_link_text_skin' => [
			'type'    => 'text',
			'heading' => esc_html__('Text for button', 'funero'),
			'default' => 'Learn More',
		],
		'funero_subtitle' => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'funero'),
			'default' => 'We help with',
		],
		'funero_link_text' => [
			'type'    => 'text',
			'heading' => esc_html__('Text for button', 'funero'),
			'default' => '+ READ MORE',
		],
		'funero_use_excerpt' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Excerpt?', 'funero'),
			'grid'    => 3,
		],
		'funero_excerpt'     => [
			'type'     => 'typography',
			'group'    => 'Funero Excerpt Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],
		'funero_use_quote'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Quote?', 'funero'),
			'grid'    => 3,
		],
		'funero_quote'       => [
			'type'     => 'typography',
			'group'    => 'Funero Quote Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote h3',
		],
		'funero_use_name'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'funero'),
			'grid'    => 3,
		],
		'funero_name'        => [
			'type'     => 'typography',
			'group'    => 'Funero Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote cite',
		],
		'funero_use_subtitle_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_subtitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__subtitle',
		],
		'funero_use_link_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'funero'),
			'grid'    => 3,
		],
		'funero_link_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__links a',
		],
		'funero_use_quote_symbol'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for quote symbol?', 'funero'),
			'grid'    => 3,
		],
		'funero_quote_symbol'        => [
			'type'     => 'typography',
			'group'    => 'Funero Quote Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__quote::after',
		],
	]);
}

function funero_custom_post_types_skins_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_use_excerpt']) && $shortcode->atts['funero_use_excerpt'] && isset($shortcode->atts['funero_excerpt']) && !empty($shortcode->atts['funero_excerpt']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['funero_excerpt']));
	}

	if ( isset($shortcode->atts['funero_use_quote']) && $shortcode->atts['funero_use_quote'] && isset($shortcode->atts['funero_quote']) && !empty($shortcode->atts['funero_quote']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__quote h3'], $shortcode->parse_typography($shortcode->atts['funero_quote']));
	}
	if ( isset($shortcode->atts['funero_use_name']) && $shortcode->atts['funero_use_name'] && isset($shortcode->atts['funero_name']) && !empty($shortcode->atts['funero_name']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__quote cite'], $shortcode->parse_typography($shortcode->atts['funero_name']));
	}
	if ( isset($shortcode->atts['funero_use_subtitle_typo']) && $shortcode->atts['funero_use_subtitle_typo'] && isset($shortcode->atts['funero_subtitle_typo']) && !empty($shortcode->atts['funero_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_subtitle_typo']));
	}
	if ( isset($shortcode->atts['funero_use_link_typo']) && $shortcode->atts['funero_use_link_typo'] && isset($shortcode->atts['funero_link_typo']) && !empty($shortcode->atts['funero_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__links a'], $shortcode->parse_typography($shortcode->atts['funero_link_typo']));
	}
	if ( isset($shortcode->atts['funero_use_quote_symbol']) && $shortcode->atts['funero_use_quote_symbol'] && isset($shortcode->atts['funero_quote_symbol']) && !empty($shortcode->atts['funero_quote_symbol']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-cpt-article__quote::after'], $shortcode->parse_typography($shortcode->atts['funero_quote_symbol']));
	}
	return $css;
}
add_filter( 'aheto_cpt_skin_dynamic_css', 'funero_custom_post_types_skins_dynamic_css', 10, 2 );