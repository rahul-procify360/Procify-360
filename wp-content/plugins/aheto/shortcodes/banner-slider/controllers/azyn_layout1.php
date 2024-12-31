<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'azyn_banner_slider_layout1');

/**
 * Contact forms Shortcode
 */

function azyn_banner_slider_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'azyn_layout1', [
		'title' => esc_html__( 'Azyn Banner Slider', 'aheto' ),
		'image' => $preview_dir . 'azyn_layout1.jpg',
	] );

	$shortcode->add_dependecy('azyn_pagination_color', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_arrows_color', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_lines_color', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_lines_active_color', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_slide_bg', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_modern_banners', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_use_sub_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_sub_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_sub_typo', 'azyn_use_sub_typo', 'true');
	$shortcode->add_dependecy('azyn_use_title_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_title_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_title_typo', 'azyn_use_title_typo', 'true');

	$shortcode->add_params( [
		'azyn_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'aheto' ),
			'params'  => [
				'azyn_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'aheto' ),
				],
				'azyn_subtitle'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Subtitle', 'aheto' ),
				],
				'azyn_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title (first line)', 'aheto' ),
					'admin_label' => true,
				],
				'azyn_title_second'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title (second line)', 'aheto' ),
					'admin_label' => true,
				],
				'azyn_heading_tag'      => [
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

		'azyn_use_sub_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_sub_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .q_slide .slide .caption h6',
		],
		'azyn_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_title_typo' => [
			'type'     => 'typography',
	        'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .q_slide .slide .slide-title',
		],
		'azyn_slide_bg' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Slides Background Color', 'aheto' ),
			'grid'      => 6,
			'selectors' => ['{{WRAPPER}} .q_slide .slide' => 'background: {{VALUE}}']
		],
		'azyn_lines_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Line color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .q_slide .progress' => 'background: {{VALUE}}' ]
		],
		'azyn_lines_active_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Line active color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .q_slide .progress .bar' => 'background: {{VALUE}}' ]
		],
		'azyn_arrows_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Arrows color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .q_slide .arrows .arrow:before' => 'border-color: {{VALUE}}',
				'{{WRAPPER}} .q_slide .arrows .svg' => 'fill: {{VALUE}}' ]
		],

		'azyn_pagination_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Pagination color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .q_slide .pagination .item span strong' => 'color: {{VALUE}}',
				'{{WRAPPER}} .q_slide .pagination .item' => 'color: {{VALUE}}',
				'{{WRAPPER}} .q_slide .pagination .item::after' => 'background: {{VALUE}}' ]
		],
	] );
}

function azyn_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

	if (  $shortcode->atts['azyn_use_sub_typo'] && ! empty( $shortcode->atts['azyn_sub_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s  .q_slide .slide .caption h6'], $shortcode->parse_typography( $shortcode->atts['azyn_sub_typo'] ) );
	}
	if ( $shortcode->atts['azyn_use_title_typo'] && ! empty( $shortcode->atts['azyn_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .q_slide .slide .slide-title'], $shortcode->parse_typography( $shortcode->atts['azyn_title_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['azyn_slide_bg'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_slide_bg'] );
		$css['global']['%1$s .q_slide .slide']['background'] = $color;
	}
	if ( ! empty( $shortcode->atts['azyn_lines_color'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_lines_color'] );
		$css['global']['%1$s .q_slide .progress']['background'] = $color;
	}
	if ( ! empty( $shortcode->atts['azyn_lines_active_color'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_lines_active_color'] );
		$css['global']['%1$s .q_slide .progress .bar']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['azyn_arrows_color'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_arrows_color'] );
		$css['global']['%1$s .q_slide .arrows .arrow:before']['border-color'] = $color;
		$css['global']['%1$s .q_slide .arrows .svg']['fill'] = $color;
	}

	if ( ! empty( $shortcode->atts['azyn_pagination_color'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_pagination_color'] );
		$css['global']['%1$s .q_slide .pagination .item span strong']['color'] = $color;
		$css['global']['%1$s .q_slide .pagination .item']['color'] = $color;
	}
	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'azyn_banner_slider_layout1_dynamic_css', 10, 2 );
