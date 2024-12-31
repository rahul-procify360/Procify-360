<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'soapy_contact_info_layout4');

/**
 * Contact Info Type Shortcode
 */

function soapy_contact_info_layout4($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('soapy_layout4', [
		'title' => esc_html__('Contact Info 12', 'soapy'),
		'image' => $preview_dir . 'soapy_layout4.jpg',
	]);

	aheto_demos_add_dependency(['title', 'use_typo', 'title_typo', 'address', 'phone', 'email', 'use_typo_text', 'text_typo' ], ['soapy_layout4'], $shortcode);

	$shortcode->add_dependecy('soapy_align', 'template', ['soapy_layout4']);
	$shortcode->add_dependecy('soapy_image', 'template', ['soapy_layout4']);
	$shortcode->add_dependecy('soapy_link_title', 'template', ['soapy_layout4']);
	$shortcode->add_dependecy('soapy_link_url', 'template', ['soapy_layout4']);
	$shortcode->add_dependecy('soapy_link_use_typo', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_link_typo', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_link_typo', 'soapy_link_use_typo', 'true');

	$shortcode->add_params([
		'soapy_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'soapy_image'      => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'soapy'),
		],
		'soapy_link_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'soapy'),
		],
		'soapy_link_url'   => [
			'type'    => 'text',
			'heading' => esc_html__('Link URL', 'soapy'),
		],
		'soapy_link_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_link_typo'                => [
			'type'     => 'typography',
			'group'    => 'Soapy Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__link-arrow',
		],
	]);
}
function soapy_contact_info_layout4_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_link_use_typo']) && $shortcode->atts['soapy_link_use_typo'] && isset($shortcode->atts['soapy_link_typo']) && !empty($shortcode->atts['soapy_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__link-arrow'], $shortcode->parse_typography($shortcode->atts['soapy_link_typo']));
	}
	return $css;
}

add_filter('famulus_contact_info_dynamic_css', 'soapy_contact_info_layout4_dynamic_css', 10, 2);
