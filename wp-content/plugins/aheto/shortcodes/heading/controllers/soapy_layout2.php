<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'soapy_heading_layout2');


/**
 * Heading
 */
function soapy_heading_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';
	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Heading 20', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);


	$shortcode->add_dependecy('soapy_add_desc_use_typo', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_desc_editor', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_add_desc_typo', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_add_desc_typo', 'soapy_add_desc_use_typo', 'true');


	$shortcode->add_params([
		'soapy_desc_editor'     => [
			'type'    => 'editor',
			'heading' => esc_html__('Subitle', 'soapy'),
			'grid'    => 12,
		],
		'soapy_add_desc_use_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Description?', 'ninedok' ),
			'grid' => 3,
		],
		'soapy_add_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],

	]);
}


function soapy_heading_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_add_desc_use_typo']) && $shortcode->atts['soapy_add_desc_use_typo'] && isset($shortcode->atts['soapy_add_desc_typo']) && !empty($shortcode->atts['soapy_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['soapy_add_desc_typo']));
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'soapy_heading_layout2_dynamic_css', 10, 2);

