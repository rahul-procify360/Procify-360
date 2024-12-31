<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'sterling_heading_layout1');

/**
 * Heading Shortcode
 */
function sterling_heading_layout1($shortcode)
{

	$theme_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Simple', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_subtitle', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_subtitle_tag', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_use_subtitle_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_subtitle_typo', 'sterling_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('sterling_title', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_tag', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_use_title_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_typo', 'sterling_use_title_typo', 'true');
	$shortcode->add_dependecy('sterling_align_mobile', 'template', 'sterling_layout1');

	aheto_demos_add_dependency('alignment', ['sterling_layout1'], $shortcode);


	$shortcode->add_params([
		'sterling_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Subtitle', 'sterling'),
			'description' => esc_html__('Add some text for Subtitle', 'sterling'),
			'admin_label' => true,
			'default'     => esc_html__('Add some text for Subtitle', 'sterling'),
		],
		'sterling_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Subtitle', 'sterling'),
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
			'default' => 'h4',
			'grid'    => 5,
		],
		'sterling_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'sterling_title'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Title', 'sterling'),
			'description' => esc_html__('Add some text for Title', 'sterling'),
			'admin_label' => true,
			'default'     => esc_html__('Add some text for Title', 'sterling'),
		],
		'sterling_title_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Title', 'sterling'),
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
		'sterling_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title?', 'sterling'),
			'grid'    => 3,
		],

		'sterling_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__title',
		],
		'sterling_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__('Align for mobile', 'sterling'),
			'options' => [
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'Left',
		],
	]);
}

function sterling_heading_layout1_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['sterling_use_subtitle_typo']) && !empty($shortcode->atts['sterling_subtitle_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['sterling_subtitle_typo']));
	}

	if (!empty($shortcode->atts['sterling_use_title_typo']) && !empty($shortcode->atts['sterling_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__title'], $shortcode->parse_typography($shortcode->atts['sterling_title_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'sterling_heading_layout1_dynamic_css', 10, 2);