<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'azyn_banner_slider_layout3');

/**
 * Contact forms Shortcode
 */

function azyn_banner_slider_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'azyn_layout3', [
		'title' => esc_html__( 'Azyn Animated', 'aheto' ),
		'image' => $preview_dir . 'azyn_layout3.jpg',
	] );

	$shortcode->add_dependecy('azyn_animate_banners', 'template', 'azyn_layout3');
	$shortcode->add_dependecy('azyn_use_a_title_typo', 'template', 'azyn_layout3');
	$shortcode->add_dependecy('azyn_a_title_typo', 'template', 'azyn_layout3');
	$shortcode->add_dependecy('azyn_a_title_typo', 'azyn_use_a_title_typo', 'true');
	$shortcode->add_dependecy('azyn_use_num_typo', 'template', 'azyn_layout3');
	$shortcode->add_dependecy('azyn_num_typo', 'template', 'azyn_layout3');
	$shortcode->add_dependecy('azyn_num_typo', 'azyn_use_num_typo', 'true');

	$shortcode->add_params( [
		'azyn_animate_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'aheto' ),
			'params'  => [
				'azyn_anim_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'aheto' ),
				],
				'azyn_anim_text'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'aheto' ),
					'admin_label' => true,
				],
				'azyn_anim_heading_tag'      => [
					'type'    => 'select',
					'heading' => esc_html__( 'Element tag for title', 'aheto' ),
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
					'default' => 'h2',
				],
			]
		],

		'azyn_use_a_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_a_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .slide__title',
		],

		'azyn_use_num_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for navigation/numbers?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_num_typo' => [
			'type'     => 'typography',
			'group'    => 'Navigation/Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .slidenav__item, {{WRAPPER}} .slidenav span, {{WRAPPER}} .q_slide .number',
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'azyn_anim_',
	], 'azyn_animate_banners' );

}

function azyn_banner_slider_layout3_dynamic_css( $css, $shortcode ) {

	if (  $shortcode->atts['azyn_use_num_typo'] && ! empty( $shortcode->atts['azyn_num_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .slidenav__item, %1$s .slidenav span'], $shortcode->parse_typography( $shortcode->atts['azyn_num_typo'] ) );
	}
	if ( $shortcode->atts['azyn_use_a_title_typo'] && ! empty( $shortcode->atts['azyn_a_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .slide__title'], $shortcode->parse_typography( $shortcode->atts['azyn_a_title_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'azyn_banner_slider_layout3_dynamic_css', 10, 2 );
