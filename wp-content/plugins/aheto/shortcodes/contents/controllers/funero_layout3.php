<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'funero_contents_layout3');

/**
 * Contents shortcode
 */

function funero_contents_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('funero_layout3', [
		'title' => esc_html__('Content 14', 'funero'),
		'image' => $preview_dir . 'funero_layout3.jpg',
	]);
	$shortcode->add_dependecy('funero_obituaries_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_photographs_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_service_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_condolences_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_add_desc_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_add_desc_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_add_desc_typo', 'funero_add_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_add_item_title_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_add_item_title_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_add_item_title_typo', 'funero_add_item_title_use_typo', 'true');

	$shortcode->add_dependecy('funero_obituaries', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_service', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_photographs', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_bottom_img', 'template', 'funero_layout3');

	$shortcode->add_params([
		'funero_obituaries_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Obituaries', 'funero'),
			'default' => esc_html__('Obituaries', 'funero'),
			'grid'    => 3,
		],
		'funero_photographs_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Photographs', 'funero'),
			'default' => esc_html__('Photographs', 'funero'),
			'grid'    => 3,
		],
		'funero_service_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Service', 'funero'),
			'default' => esc_html__('Service', 'funero'),
			'grid'    => 3,
		],
		'funero_condolences_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Condolences', 'funero'),
			'default' => esc_html__('Condolences', 'funero'),
			'grid'    => 3,
		],
		'funero_obituaries'        => [
			'type'    => 'editor',
			'heading' => esc_html__('Obituaries', 'funero'),
			'grid'    => 3,
		],
		'funero_photographs'       => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Photographs', 'funero'),
		],
		'funero_service'           => [
			'type'    => 'editor',
			'heading' => esc_html__('Service', 'funero'),
			'grid'    => 3,
		],
		'funero_bottom_img'        => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image Bottom', 'funero'),
		],
		'funero_add_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__desc, {{WRAPPER}}  .aheto-contents__desc *',
		],
		'funero_add_item_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title Item?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_item_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Title Item Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title',
		],
	]);
}

function funero_contents_layout3_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_add_desc_use_typo']) && $shortcode->atts['funero_add_desc_use_typo'] && isset($shortcode->atts['funero_add_desc_typo']) && !empty($shortcode->atts['funero_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__desc, %1$s .aheto-contents__desc *'], $shortcode->parse_typography($shortcode->atts['funero_add_desc_typo']));
	}
	if ( isset($shortcode->atts['funero_add_item_title_use_typo']) && $shortcode->atts['funero_add_item_title_use_typo'] && isset($shortcode->atts['funero_add_item_title_typo']) && !empty($shortcode->atts['funero_add_item_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography($shortcode->atts['funero_add_item_title_typo']));
	}

	return $css;
}
add_filter('aheto_contents_dynamic_css', 'funero_contents_layout3_dynamic_css', 10, 2);
