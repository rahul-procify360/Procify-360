<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'vestry_custom_post_types_skins');

/**
 * Custom Post Type
 */

function vestry_custom_post_types_skins($shortcode)
{

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'vestry_skin-1' => esc_html__('Vestry skin 1', 'vestry'),
		'vestry_skin-2' => esc_html__('Vestry skin 2', 'vestry'),
		'vestry_skin-3' => esc_html__('Vestry skin 3', 'vestry'),
		'vestry_skin-4' => esc_html__('Vestry skin 4', 'vestry'),
		'vestry_skin-5' => esc_html__('Vestry skin 5', 'vestry'),
		'vestry_skin-6' => esc_html__('Vestry skin 6', 'vestry'),
		'vestry_skin-7' => esc_html__('Vestry skin 7', 'vestry'),
	);

	$all_skins = array_merge($aheto_skins, $aheto_addon_skins);

	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy('vestry_link_text', 'skin', ['vestry_skin-1', 'vestry_skin-2', 'vestry_skin-3', 'vestry_skin-5', 'vestry_skin-6', 'vestry_skin-7']);

	$shortcode->add_dependecy('vestry_use_date', 'skin', ['vestry_skin-1', 'vestry_skin-2', 'vestry_skin-5', 'vestry_skin-7']);
	$shortcode->add_dependecy('vestry_date_typo', 'skin', ['vestry_skin-1', 'vestry_skin-2', 'vestry_skin-5', 'vestry_skin-7']);
	$shortcode->add_dependecy('vestry_date_typo', 'vestry_use_date', 'true');

	$shortcode->add_dependecy('vestry_audio_page', 'skin', 'vestry_skin-6');

	$shortcode->add_dependecy('vestry_use_terms', 'skin', ['vestry_skin-6']);
	$shortcode->add_dependecy('vestry_terms_typo', 'skin', ['vestry_skin-6']);
	$shortcode->add_dependecy('vestry_terms_typo', 'vestry_use_terms', 'true');

	$shortcode->add_dependecy('vestry_use_detail_typo', 'skin', ['vestry_skin-7']);
	$shortcode->add_dependecy('vestry_detail_typo', 'skin', ['vestry_skin-7']);
	$shortcode->add_dependecy('vestry_detail_typo', 'vestry_use_detail_typo', 'true');

	$shortcode->add_dependecy('vestry_use_icon_size', 'skin', 'vestry_skin-6' );
	$shortcode->add_dependecy('vestry_icon_size', 'skin', 'vestry_skin-6' );
	$shortcode->add_dependecy('vestry_icon_size', 'vestry_use_icon_size', 'true');
	// Quad form
	$shortcode->add_dependecy('vestry_use_square', 'template', 'vestry_skin-6');

	$shortcode->add_params([
		'vestry_link_text' => [
			'type'    => 'text',
			'heading' => esc_html__('Text for button', 'vestry'),
			'default' => '+ READ MORE',
		],
		'vestry_audio_page' => [
			'type'    => 'text',
			'heading' => esc_html__('Link to page with audio sermons', 'vestry'),
			'default' => '',
		],
		'vestry_use_square' => [
			'type'    => 'switch',
			'heading' => esc_html__('Make slide square?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_use_date' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date span',
		],
		'vestry_use_terms' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for term?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_terms_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Term Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__terms',
		],
		'vestry_use_detail_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for event detail?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_detail_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Event Detail Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__infos p',
		],
		'vestry_use_icon_size' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add size for icon?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_icon_size' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Icon font size', 'vestry' ),
		]
	]);
}

function vestry_cpt_skins_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['vestry_use_date']) && !empty($shortcode->atts['vestry_date_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__date span'], $shortcode->parse_typography($shortcode->atts['vestry_date_typo']));
    }
    if (!empty($shortcode->atts['vestry_use_terms']) && !empty($shortcode->atts['vestry_terms_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__terms'], $shortcode->parse_typography($shortcode->atts['vestry_terms_typo']));
    }
    if (!empty($shortcode->atts['vestry_use_detail_typo']) && !empty($shortcode->atts['vestry_detail_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__infos p'], $shortcode->parse_typography($shortcode->atts['vestry_detail_typo']));
    }

    return $css;
}

add_filter('aheto_cpt_dynamic_css', 'vestry_cpt_skins_dynamic_css', 10, 2);
