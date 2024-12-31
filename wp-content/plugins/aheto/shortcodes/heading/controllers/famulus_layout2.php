<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'famulus_heading_layout2');


/**
 * Heading
 */
function famulus_heading_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Heading 6', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency(['title_animation', 'heading', 'text_tag', 'text_typo', 'use_typo', 'use_typo_hightlight', 'text_typo_hightlight'], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_link_title', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_url', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_arrow', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_white_text', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_white_add_text', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_hide_line', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_add_link_use_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_add_link_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_add_link_typo', 'famulus_add_link_use_typo', 'true');
	$shortcode->add_params([
		'famulus_white_text' => [
			'type'        => 'switch',
			'heading'     => esc_html__('White Text', 'famulus'),
			'grid'        => 3,
			'description' => esc_html__('It will work if not used custom options. It will colorize all the content in the shortcode except Highlight ', 'famulus'),

		],
		'famulus_hide_line'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Hide Line?', 'famulus'),
			'grid'    => 3,
		],

		'famulus_white_add_text' => [
			'type'        => 'switch',
			'heading'     => esc_html__('White Highlight Text', 'famulus'),
			'grid'        => 3,
			'description' => esc_html__('It will work if not used custom options', 'famulus'),
		],
		'famulus_link_title'     => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'famulus'),
			'grid'    => 12,
		],
		'famulus_link_url'       => [
			'type'    => 'text',
			'heading' => esc_html__('Link Url', 'famulus'),
			'grid'    => 12,
		],
		'famulus_link_arrow'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Add arrow to link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_link_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_add_link_typo'         => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__link',
		],
	]);
}

function famulus_heading_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_add_link_use_typo']) && $shortcode->atts['famulus_add_link_use_typo'] && isset($shortcode->atts['famulus_add_link_typo']) && !empty($shortcode->atts['famulus_add_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__link'], $shortcode->parse_typography($shortcode->atts['famulus_add_link_typo']));
	}
	return $css;
}

add_filter('aheto_heading_dynamic_css', 'famulus_heading_layout2_dynamic_css', 10, 2);