<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'famulus_banner_slider_layout3');

/**
 *  Banner Slider
 */

function famulus_banner_slider_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('famulus_layout3', [
		'title' => esc_html__('Banner Slider 9', 'aheto'),
		'image' => $preview_dir . 'famulus_layout3.jpg',
	]);

	$shortcode->add_dependecy('famulus_image_bc', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_bc', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_img_overlay_bc', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_white_bc', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_links_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_links_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_links_typo', 'famulus_links_use_typo', 'true');

	$shortcode->add_params([

		'famulus_image_bc' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'aheto'),
		],
		'famulus_title_bc' => [
			'type'    => 'textarea',
			'heading' => esc_html__('Title', 'aheto'),
		],

		'famulus_img_overlay_bc' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add overlay to image?', 'aheto'),
			'grid'    => 12,
		],
		'famulus_white_bc'       => [
			'type'    => 'switch',
			'heading' => esc_html__('White text?', 'aheto'),
			'grid'    => 12,
		],
		'famulus_links_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Links?', 'aheto'),
			'grid'    => 3,
		],
		'famulus_links_typo'        => [
			'type'     => 'typography',
			'group'    => 'Breadcrumbs Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-wrap__breadcrumbs li',
		],
	]);
}

function famulus_banner_slider_layout3_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['famulus_links_use_typo']) && $shortcode->atts['famulus_links_use_typo'] && isset($shortcode->atts['famulus_links_typo']) && !empty($shortcode->atts['famulus_links_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-wrap__breadcrumbs li'], $shortcode->parse_typography($shortcode->atts['famulus_links_typo']));
	}
	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'famulus_banner_slider_layout3_dynamic_css', 10, 2);
