<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'ewo_contents_layout3');

/**
 * Contents
 */

function ewo_contents_layout3($shortcode)
{

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('ewo_layout3', [
		'title' => esc_html__('Content 4', 'ewo'),
		'image' => $preview_dir . 'ewo_layout3.jpg',
	]);

	aheto_demos_add_dependency(['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], ['ewo_layout3'], $shortcode);

	$shortcode->add_dependecy('ewo_use_arrow_typo', 'template', 'ewo_layout3');
	$shortcode->add_dependecy('ewo_arrow_typo', 'template', 'ewo_layout3');
	$shortcode->add_dependecy('ewo_arrow_typo', 'ewo_use_arrow_typo', 'true');

	$shortcode->add_params([
		'ewo_use_arrow_typo' => [
			'type' => 'switch',
			'heading' => esc_html__('Use custom font for arrow?', 'ewo'),
			'grid' => 12,
			'default' => '',
		],

		'ewo_arrow_typo' => [
			'type' => 'typography',
			'group' => 'Ewo Arrow Typography',
			'settings' => [
				'text_align' => false,
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .ion-ios-arrow-forward',
		],
	]);
}

function ewo_contents_layout3_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['ewo_use_arrow_typo']) && !empty($shortcode->atts['ewo_arrow_typo'])) {
		\aheto_add_props($css['global']['%1$s .ion-ios-arrow-forward'], $shortcode->parse_typography($shortcode->atts['ewo_arrow_typo']));
	}

	return $css;
}

add_filter('aheto_contents_dynamic_css', 'ewo_contents_layout3_dynamic_css', 10, 2);
