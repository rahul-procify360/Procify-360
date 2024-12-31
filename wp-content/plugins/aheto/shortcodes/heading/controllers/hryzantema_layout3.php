<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'hryzantema_heading_layout3');

/**
 * Heading Shortcode
 */

function hryzantema_heading_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'Heading 10)', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout3.jpg',
	] );
	$shortcode->add_dependecy( 'hryzantema_align_mobile', 'template', ['hryzantema_layout3'] );
	$shortcode->add_dependecy( 'hryzantema_text_image', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_description', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_use_picture_text_colors', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_picture_text_color', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_picture_text_color', 'hryzantema_use_picture_text_colors', 'true' );
	$shortcode->add_dependecy( 'hryzantema_picture_text_special_color', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_picture_text_special_color', 'hryzantema_use_picture_text_colors', 'true' );
	aheto_demos_add_dependency(['heading','alignment', 'text_tag', 'source', 'use_typo', 'text_typo'], ['hryzantema_layout3'], $shortcode);


	$shortcode->add_params([
		'hryzantema_text_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Background Image for text', 'hryzantema' ),
		],
		'hryzantema_description'   => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Description', 'hryzantema' ),
			'description' => esc_html__( 'Add some text for description', 'hryzantema' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for description', 'hryzantema' ),
		],
		'hryzantema_use_picture_text_colors' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom colors for title?', 'hryzantema' ),
			'grid'    => 3,
		],
		'hryzantema_picture_text_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Title color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-heading__title .colorful' => 'background-color: {{VALUE}}' ],
		],
		'hryzantema_picture_text_special_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Marked text color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-heading__title .colorful span' => 'background-color: {{VALUE}}' ],
		],
		'hryzantema_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for mobile', 'hryzantema' ),
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
function hryzantema_heading_layout3_dynamic_css($css, $shortcode) {

	if (isset($shortcode->atts['hryzantema_use_picture_text_colors']) && $shortcode->atts['hryzantema_use_picture_text_colors'] && isset($shortcode->atts['hryzantema_picture_text_color']) && !empty($shortcode->atts['hryzantema_picture_text_color'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_picture_text_color']);
		$css['global']['%1$s .aheto-heading__title .colorful']['background-color'] = $color;
	}
	if (isset($shortcode->atts['hryzantema_use_picture_text_colors']) && $shortcode->atts['hryzantema_use_picture_text_colors'] && isset($shortcode->atts['hryzantema_picture_text_special_color']) && !empty($shortcode->atts['hryzantema_picture_text_special_color'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_picture_text_special_color']);
		$css['global']['%1$s .aheto-heading__title .colorful span']['background-color'] = $color;
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'hryzantema_heading_layout3_dynamic_css', 10, 2);