<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'funero_heading_layout1');


/**
 * Heading Shortcode
 */
function funero_heading_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Heading 7', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	aheto_demos_add_dependency(['use_typo', 'text_typo'], ['funero_layout1'], $shortcode);

	$shortcode->add_dependecy('funero_add_subtitle_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_subtitle_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_subtitle_typo', 'funero_add_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('funero_add_bg_text_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_bg_text_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_bg_text_typo', 'funero_add_bg_text_use_typo', 'true');
	$shortcode->add_dependecy('funero_add_desc_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_add_desc_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_desc_typo', 'funero_add_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_subtitle', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_subtitle_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle_space', 'funero_use_subtitle_space', 'true');
	$shortcode->add_dependecy('funero_title', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_tag', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_title_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_space', 'funero_use_title_space', 'true');
	$shortcode->add_dependecy('funero_desc', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_desc_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desc_space', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desc_space', 'funero_use_desc_space', 'true');
	$shortcode->add_dependecy('funero_bottom_image', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_title_bg', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_align', 'template', 'funero_layout1');


	$shortcode->add_params([

		'funero_subtitle'           => [
			'type'    => 'text',
			'heading' => esc_html__('Subitle', 'funero'),
			'grid'    => 12,
		],
		'funero_use_subtitle_space' => [
			'type'    => 'switch',
			'heading' => esc_html__('Change space under the subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_subtitle_space'     => [
			'type'        => 'text',
			'heading'     => esc_html__('Space Subtitle', 'funero'),
			'grid'        => 12,
			'description' => esc_html__('Write only the number (value will be in px)', 'funero'),

		],
		'funero_title'              => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'funero'),
			'grid'    => 12,
		],
		'funero_title_bg'           => [
			'type'    => 'text',
			'heading' => esc_html__('Text on Background', 'funero'),
			'grid'    => 12,
		],
		'funero_title_tag'          => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Title', 'funero'),
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
			'default' => 'h2',
			'grid'    => 5,
		],
		'funero_use_title_space'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Change space under the title?', 'funero'),
			'grid'    => 3,
		],
		'funero_title_space'        => [
			'type'        => 'text',
			'heading'     => esc_html__('Space Title', 'funero'),
			'grid'        => 12,
			'description' => esc_html__('Write only the number (value will be in px)', 'funero'),

		],
		'funero_desc'               => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'funero'),
			'grid'    => 12,
		],
		'funero_use_desc_space'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Change space under the description?', 'funero'),
			'grid'    => 3,
		],
		'funero_desc_space'         => [
			'type'        => 'text',
			'heading'     => esc_html__('Space Description', 'funero'),
			'grid'        => 12,
			'description' => esc_html__('Write only the number (value will be in px)', 'funero'),

		],
		'funero_add_desc_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_desc_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],

		'funero_add_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'funero_bottom_image'          => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image Bottom', 'funero'),
		],
		'funero_align'                 => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'funero'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'funero_add_bg_text_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Background Text?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_bg_text_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Background Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__title-bg',
		],
	]);
}

function funero_heading_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_add_subtitle_use_typo']) && $shortcode->atts['funero_add_subtitle_use_typo'] && isset($shortcode->atts['funero_add_subtitle_typo']) && !empty($shortcode->atts['funero_add_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_add_subtitle_typo']));
	}
	if ( isset($shortcode->atts['funero_add_desc_use_typo']) && $shortcode->atts['funero_add_desc_use_typo'] && isset($shortcode->atts['funero_add_desc_typo']) && !empty($shortcode->atts['funero_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['funero_add_desc_typo']));
	}
	if ( isset($shortcode->atts['funero_add_bg_text_use_typo']) && $shortcode->atts['funero_add_bg_text_use_typo'] && isset($shortcode->atts['funero_add_bg_text_typo'])  && !empty($shortcode->atts['funero_add_bg_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__title-bg'], $shortcode->parse_typography($shortcode->atts['funero_add_bg_text_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'funero_heading_layout1_dynamic_css', 10, 2);
