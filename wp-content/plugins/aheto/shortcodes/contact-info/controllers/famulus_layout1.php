<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'famulus_contact_info_layout1');

/**
 * Contact Info Type Shortcode
 */

function famulus_contact_info_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Contact Info 1', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	$shortcode->add_dependecy('famulus_contact', 'template', 'famulus_layout1');

	$shortcode->add_dependecy('famulus_use_typo_copyright', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_copyright', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_copyright', 'famulus_use_typo_copyright', 'true');

	$shortcode->add_params([
		'famulus_contact' => [
			'type'    => 'group',
			'heading' => esc_html__('Contacts', 'famulus'),
			'params'  => [

				'famulus_copyright' => [
					'type'    => 'text',
					'heading' => esc_html__('Copyright', 'famulus'),
				],
				'famulus_add'       => [
					'type'    => 'textarea',
					'heading' => esc_html__('Address', 'famulus'),
					'grid'    => 12,
				],

				'famulus_footer_social' => [
					'type'    => 'checkbox',
					'heading' => esc_html__('Add socials?', 'famulus'),
				],
			],
		],
		'advanced'        => true,
		'famulus_use_typo_copyright'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for copyright?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_copyright' => [
			'type'     => 'typography',
			'group'    => 'Famulus Copyright Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__copyright',
		],
	]);

	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'famulus_',
		'dependency' => ['famulus_footer_social', 'true']
	], 'famulus_contact');


}
function famulus_aheto_contact_info_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_copyright']) && $shortcode->atts['famulus_use_typo_copyright'] && isset($shortcode->atts['famulus_text_typo_copyright']) && !empty($shortcode->atts['famulus_text_typo_copyright']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__copyright'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_copyright']));
	}

	return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'famulus_aheto_contact_info_layout1_dynamic_css', 10, 2);