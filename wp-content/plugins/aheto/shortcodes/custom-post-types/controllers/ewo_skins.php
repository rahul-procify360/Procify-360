<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'ewo_custom_post_types_skins');

/**
 * Custom Post Type
 */

function ewo_custom_post_types_skins($shortcode)
{

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'ewo_skin-1' => esc_html__('Ewo skin 1', 'ewo'),
		'ewo_skin-2' => esc_html__('Ewo skin 2', 'ewo'),
		'ewo_skin-3' => esc_html__('Ewo skin 3', 'ewo'),
		'ewo_skin-4' => esc_html__('Ewo skin 4', 'ewo'),
		'ewo_skin-5' => esc_html__('Ewo skin 5', 'ewo'),
		'ewo_skin-6' => esc_html__('Ewo skin 6', 'ewo'),
	);

	$all_skins = array_merge($aheto_skins, $aheto_addon_skins);
	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('ewo_dark_mod', 'skin', 'ewo_skin-1');

	$shortcode->add_dependecy('ewo_use_excerpt_typo', 'skin', ['ewo_skin-4', 'ewo_skin-5']);
	$shortcode->add_dependecy('ewo_link', 'skin', ['ewo_skin-2', 'ewo_skin-3']);
	$shortcode->add_dependecy('ewo_excerpt_typo', 'skin', ['ewo_skin-4', 'ewo_skin-5']);
	$shortcode->add_dependecy('ewo_excerpt_typo', 'ewo_use_excerpt_typo', 'true');

	$shortcode->add_dependecy('ewo_use_dated_typo', 'skin', ['ewo_skin-6']);
	$shortcode->add_dependecy('ewo_dated_typo', 'skin', ['ewo_skin-6']);
	$shortcode->add_dependecy('ewo_dated_typo', 'ewo_use_dated_typo', 'true');

	// CUSTOM SKIN 

	$shortcode->add_params([
		'ewo_dark_mod' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use dark mod?', 'ewo'),
			'grid'    => 3,
		],
		'ewo_use_excerpt_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for excerpt?', 'ewo'),
			'grid'    => 2,
		],
		'ewo_excerpt_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Excerpt Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],
		'ewo_use_dated_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for day?', 'ewo'),
			'grid'    => 2,
		],
		'ewo_dated_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Day Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__footer-item--dateD',
		],
		'ewo_link' => [
			'type'    => 'text',
			'heading' => esc_html__('Text for read more link', 'ewo'),
			'default' => esc_html__('READ FULL POST', 'ewo'),
			'value'   => esc_html__('READ FULL POST', 'ewo'),
			'grid'    => 6,
		],
	]);
}

function ewo_custom_post_types_skins_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['ewo_use_excerpt_typo']) && !empty($shortcode->atts['ewo_excerpt_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['ewo_excerpt_typo']));
	}
	if (!empty($shortcode->atts['ewo_use_dated_typo']) && !empty($shortcode->atts['ewo_dated_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__footer-item--dateD'], $shortcode->parse_typography($shortcode->atts['ewo_dated_typo']));
	}

	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'ewo_custom_post_types_skins_dynamic_css', 10, 2);
