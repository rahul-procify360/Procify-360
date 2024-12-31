<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout2');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('hryzantema_layout2', [
		'title' => esc_html__('Features Single 20', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	]);
	aheto_demos_add_dependency('s_image', ['hryzantema_layout2'], $shortcode);
	$shortcode->add_dependecy('hryzantema_title', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_description', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_content_orientation', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_use_title_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_title_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_title_typo', 'hryzantema_use_title_typo', 'true');

	$shortcode->add_dependecy('hryzantema_use_description_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_description_typo', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_description_typo', 'hryzantema_use_description_typo', 'true');

	$shortcode->add_params([
		'hryzantema_title' => [
			'type'     => 'text',
			'heading' => esc_html__( 'Add your title', 'hryzantema' ),
			'grid' =>  1
		],
		'hryzantema_description' => [
			'type'     => 'textarea',
			'heading' => esc_html__( 'Add your description', 'hryzantema' ),
			'grid' => 3
		],
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-block__title, {{WRAPPER}} .aheto-features-block__title h5',
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
			'selector' => '{{WRAPPER}} .aheto-features-block__info-text',
		],
		'hryzantema_content_orientation' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Content orientation', 'hryzantema' ),
			'options' => [
				''            => esc_html__( 'Line', 'hryzantema' ),
				'column' => esc_html__( 'Column', 'hryzantema' ),
			],
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout2'] ]
	]);
}
function hryzantema_features_single_layout2_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] ) && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-block__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_description_typo'] ) && $shortcode->atts['hryzantema_use_description_typo'] && isset( $shortcode->atts['hryzantema_description_typo'] ) && ! empty( $shortcode->atts['hryzantema_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-block__info-text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_description_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'hryzantema_features_single_layout2_dynamic_css', 10, 2 );

