<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'vestry_heading_layout1');


/**
 * Heading
 */
function vestry_heading_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Heading 21', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
	]);

	$shortcode->add_dependecy('vestry_subtitle', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_subtitle_tag', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_use_subtitle_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_subtitle_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_subtitle_typo', 'vestry_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('vestry_use_title_quote_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_quote_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_quote_typo', 'vestry_use_title_quote_typo', 'true');

	$shortcode->add_dependecy('vestry_align_mobile', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_use_grey_border', 'template', 'vestry_layout1');
	aheto_demos_add_dependency(['heading', 'text_typo', 'alignment', 'text_tag', 'use_typo'], ['vestry_layout1'], $shortcode);

	$shortcode->add_params([
		'vestry_subtitle' => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Subtitle', 'vestry'),
			'description' => esc_html__('Add some text for Subtitle', 'vestry'),
			'admin_label' => true,
		],
		'heading'     => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Title', 'vestry'),
			'description' => esc_html__('Add some text for Title', 'vestry'),
			'admin_label' => true,
		],
		'vestry_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Subtitle', 'vestry'),
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
		'vestry_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subitle?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'vestry_use_title_quote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title[[Highlight]]?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_title_quote_typo' => [
			'type'     => 'typography',
			'group'    => 'Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__title span',
		],
		'vestry_use_grey_border' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use grey border for subtitle?', 'vestry'),
			'grid'    => 3,
		],

		'vestry_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__('Align for mobile', 'vestry'),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],
	]);
}

function vestry_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['vestry_use_subtitle_typo'] ) && ! empty( $shortcode->atts['vestry_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['vestry_subtitle_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['vestry_use_title_quote_typo'] ) && ! empty( $shortcode->atts['vestry_title_quote_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__title span'], $shortcode->parse_typography( $shortcode->atts['vestry_title_quote_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'vestry_heading_layout1_dynamic_css', 10, 2 );