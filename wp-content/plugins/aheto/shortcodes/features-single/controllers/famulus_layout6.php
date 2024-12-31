<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout6');


/**
 * Feature Single
 */

function famulus_features_single_layout6($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout6', [
		'title' => esc_html__('Features Single 12', 'famulus'),
		'image' => $preview_dir . 'famulus_layout6.jpg',
	]);

	aheto_demos_add_dependency(['s_image', 's_heading', 's_description', 'link_url', 'link_title'], ['famulus_layout6'], $shortcode);

	$shortcode->add_dependecy('famulus_title_use_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_highlight_use_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_highlight_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_highlight_typo', 'famulus_highlight_use_typo', 'true');
	$shortcode->add_dependecy('famulus_active', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_img_full', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('align', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_link_use_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_link_typo', 'template', 'famulus_layout6');
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_link_use_typo', 'true');
	$shortcode->add_params([
		'famulus_active'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable active item?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_img_full' => [
			'type'        => 'switch',
			'heading'     => esc_html__('Full width image?', 'famulus'),
			'description' => esc_html__('If you use this option, Image size option will not work', 'famulus'),
			'grid'        => 3,
		],

		'align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'famulus'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'famulus_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title, .aheto-content-block__num-wrap, .aheto-content-block__num',
		],
		'famulus_highlight_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_highlight_typo'        => [
			'type'     => 'typography',
			'group'    => 'Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title span',
		],
		'famulus_link_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'         => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link-wrap a, .aheto-content-block__link-text ',
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'famulus_',
		'dependency' => ['template', ['famulus_layout6']]
	]);
}


function famulus_features_single_layout6_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_title_use_typo']) && $shortcode->atts['famulus_title_use_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_link_use_typo']) && $shortcode->atts['famulus_link_use_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-content-block__link-wrap a, .aheto-content-block__link-text '], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout6_dynamic_css', 10, 2);

