<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'hryzantema_heading_layout2');

/**
 * Heading Shortcode
 */

function hryzantema_heading_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout('hryzantema_layout2', [
		'title' => esc_html__('Heading 9', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	]);

	$shortcode->add_dependecy('hryzantema_align_mobile', 'template', ['hryzantema_layout2']);
	$shortcode->add_dependecy('hryzantema_description', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_use_description_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_description_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_description_typo', 'hryzantema_use_description_typo', 'true');
	$shortcode->add_dependecy('hryzantema_highlighted_text', 'template', 'hryzantema_layout2');
	aheto_demos_add_dependency(['heading','alignment', 'text_tag', 'use_typo', 'text_typo'], ['hryzantema_layout2'], $shortcode);

	$shortcode->add_params([
		'hryzantema_description'   => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Description', 'hryzantema' ),
			'description' => esc_html__( 'Add some text for description', 'hryzantema' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for description', 'hryzantema' ),
		],
		'hryzantema_use_description_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_description_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__desc',
		],
		'hryzantema_highlighted_text' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Disable secondary text highlighting?', 'hryzantema' ),
			'grid'    => 12,
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

function hryzantema_heading_layout2_dynamic_css($css, $shortcode) {

	if ( isset( $shortcode->atts['hryzantema_use_description_typo'] ) &&  $shortcode->atts['hryzantema_use_description_typo']  && isset( $shortcode->atts['hryzantema_description_typo'] ) && ! empty( $shortcode->atts['hryzantema_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography( $shortcode->atts['hryzantema_description_typo'] ) );
	}

	return $css;
}

add_filter('aheto_heading_dynamic_css', 'hryzantema_heading_layout2_dynamic_css', 10, 2);

