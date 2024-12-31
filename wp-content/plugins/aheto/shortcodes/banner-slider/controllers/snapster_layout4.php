<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_banner-slider_register', 'snapster_banner_slider_layout4' );

/**
 *  Banner Slider
 */

function snapster_banner_slider_layout4 ( $shortcode ){

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode -> add_layout ( 'snapster_layout4', [
		'title' => esc_html__ ( 'Snapster Creative', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout4.jpg',
	] );

	$shortcode->add_dependecy ( 'snapster_creative_banners', 'template',  'snapster_layout4' );

	$shortcode->add_dependecy( 'snapster_use_heading', 'template', 'snapster_layout4' );
	$shortcode->add_dependecy( 'snapster_t_heading', 'template', 'snapster_layout4' );
	$shortcode->add_dependecy( 'snapster_t_heading', 'snapster_use_heading', 'true' );
	$shortcode->add_dependecy ( 'snapster_t_align', 'template',  'snapster_layout4' );
	$shortcode->add_dependecy ( 'snapster_navigation', 'template',  'snapster_layout4' );

	$shortcode -> add_params ( [
		'snapster_creative_banners' => [
			'type' => 'group',
			'heading' => esc_html__ ( 'Banners', 'snapster' ),
			'params' => [
				'snapster_image' => [
					'type' => 'attach_image',
					'heading' => esc_html__ ( 'Background Image', 'snapster' ),
				],
				'snapster_text_tag'    => [
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
					'default'    => 'div',
					'grid'    => 6,
				],
				'snapster_title' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Heading', 'snapster' ),
				],
				'snapster_overlay' => [
					'type' => 'colorpicker',
					'heading' => esc_html__ ( 'Overlay color', 'snapster' ),
					'grid' => 6,
					'default' => 'transparent',
					'selectors' => [
						'{{WRAPPER}} .aheto-banner-slider__overlay' => 'background: {{VALUE}}',
					],
				],
				'align'            => true,
				'snapster_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'snapster' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'snapster' ),
						'is-vertical' => esc_html__( 'Vertical', 'snapster' ),
					],
				],
			]
		],
		'snapster_use_heading' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for heading?', 'aheto' ),
			'grid'    => 3,
		],
		'snapster_t_heading'   => [
			'type'     => 'typography',
			'group'    => 'Snapster Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__title',
		],
		'snapster_navigation' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Navigation color', 'snapster' ),
			'grid' => 6,
			'default' => 'var(--c-light)',
			'selectors' => [
				'{{WRAPPER}} div.swiper-button-prev::before, {{WRAPPER}} div.swiper-button-next::before, {{WRAPPER}} div.swiper-pagination' => 'color: {{VALUE}}',
				'{{WRAPPER}} div.swiper-button-prev span:before,{{WRAPPER}} div.swiper-button-prev span:after, {{WRAPPER}} div.swiper-button-next span:before,{{WRAPPER}} div.swiper-button-next span:after' => 'background: {{VALUE}}',
			],
		],

	] );
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'snapster_main_',
	], 'snapster_creative_banners' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'snapster' ),
		'prefix'    => 'snapster_add_',
	], 'snapster_creative_banners' );


	\Aheto\Params ::add_carousel_params ( $shortcode, [
		'custom_options' => true,
		'prefix' => 'snapster_swiper_creative_',
		'include' => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'pagination', 'simulate_touch' ],
		'dependency' => [ 'template', [ 'snapster_layout4' ] ]
	] );
}

function snapster_banner_slider_layout4_dynamic_css ( $css, $shortcode )
{
	if ( !empty( $shortcode -> atts['snapster_overlay'] )) {
		$color = Sanitize ::color ( $shortcode -> atts['snapster_overlay'] );
		$css['global']['%1$s .aheto-banner-slider__overlay']['background'] = $color;
	}
	if (!empty($shortcode->atts['snapster_use_heading']) && !empty($shortcode->atts['snapster_t_heading'])) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__title'], $shortcode->parse_typography($shortcode->atts['snapster_t_heading']));
	}

	return $css;
}

add_filter ( 'aheto_banner_slider_dynamic_css', 'snapster_banner_slider_layout4_dynamic_css', 10, 2 );
