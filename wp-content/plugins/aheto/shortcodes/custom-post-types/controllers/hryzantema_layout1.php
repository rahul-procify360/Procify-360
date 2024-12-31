<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'hryzantema_custom_post_types_layout1');

/**
 * Custom post type Shortcode
 */

function hryzantema_custom_post_types_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Custom Post Type 4', 'hryzantema' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );
	aheto_demos_add_dependency(['skin','use_heading','t_heading','image_height' ], ['hryzantema_layout1' ], $shortcode);

	$shortcode->add_dependecy('hryzantema_hide_pagination', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_max_width', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_use_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_arrow_typo', 'hryzantema_use_arrow_typo', 'true');

	$shortcode->add_params( [
		'hryzantema_hide_pagination'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Hide swiper pagination on desktop?', 'hryzantema'),
			'grid'      => 4,
		],
		'hryzantema_max_width'    => [
			'type'      => 'slider',
			'heading'   => esc_html__('Swiper container maximal width', 'hryzantema'),
			'grid'      => 4,
			'size_units' => [ 'px', '%', 'vh' ],
			'range'     => [
				'px' => [
					'min'  => 200,
					'max'  => 2000,
					'step' => 5,
				],
				'%' => [
					'min'  => 0,
					'max'  => 100,
				],
				'vh' => [
					'min'  => 0,
					'max'  => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .swiper-container' => 'max-width: {{SIZE}}{{UNIT}}; margin: auto;',
			],
		],
		'hryzantema_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for arrows?', 'hryzantema'),
			'grid'    => 3,
		],

		'hryzantema_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Arrows Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next',
		],
	]);
	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_swiper_',
		'include'        => [ 'arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'hryzantema_layout1' ] ],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),
	] );
}
function hryzantema_cpt_image_sizer_layout1( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'hryzantema_layout1';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'hryzantema_cpt_image_sizer_layout1', 10, 2 );

function hryzantema_cpt_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_arrow_typo'] ) && $shortcode->atts['hryzantema_use_arrow_typo'] && isset( $shortcode->atts['hryzantema_arrow_typo'] ) && ! empty( $shortcode->atts['hryzantema_arrow_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .swiper-button-prev, %1$s .swiper-button-next'], $shortcode->parse_typography( $shortcode->atts['hryzantema_arrow_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'hryzantema_cpt_layout1_dynamic_css', 10, 2 );
