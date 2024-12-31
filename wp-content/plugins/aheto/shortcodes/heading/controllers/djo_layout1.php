<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'djo_heading_layout1');

/**
 * Heading Shortcode
 */

function djo_heading_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Heading 2', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);
	$shortcode->add_dependecy('djo_subtitle', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_use_descr_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_descr_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_descr_typo', 'djo_use_descr_typo', 'true');
	$shortcode->add_dependecy('djo_use_subtitle_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_subtitle_tag', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_subtitle_typo', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_subtitle_typo', 'djo_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('djo_title_shadow', 'template', 'djo_layout1');
	aheto_demos_add_dependency(['heading', 'alignment','source','text_tag','use_typo','text_typo','description', 'use_typo_hightlight', 'text_typo_hightlight' ], ['djo_layout1'], $shortcode);

	$shortcode->add_params([
		'djo_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Subtitle', 'djo'),
			'description' => esc_html__('Add some text for Subtitle', 'djo'),
			'admin_label' => true,
			'default'     => esc_html__('Add some text for Subtitle', 'djo'),
		],
		'djo_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Subtitle', 'djo'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'p',
			'grid'    => 5,
		],
		'djo_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'djo'),
			'grid'    => 3,
		],

		'djo_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'djo_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'djo'),
			'grid'    => 3,
		],
		'djo_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],
		'djo_title_shadow' => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable shadow for Title?', 'djo'),
			'grid'    => 3,
		],
	]);


}
function djo_heading_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_subtitle_typo']) && $shortcode->atts['djo_use_subtitle_typo'] && isset($shortcode->atts['djo_subtitle_typo']) && !empty($shortcode->atts['djo_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['djo_subtitle_typo']));
	}
	if ( isset($shortcode->atts['djo_use_descr_typo']) && $shortcode->atts['djo_use_descr_typo'] && isset($shortcode->atts['djo_descr_typo']) && !empty($shortcode->atts['djo_descr_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['djo_descr_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'djo_heading_layout1_dynamic_css', 10, 2);

