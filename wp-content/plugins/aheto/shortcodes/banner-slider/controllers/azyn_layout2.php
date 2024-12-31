<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'azyn_banner_slider_layout2');

/**
 * Contact forms Shortcode
 */

function azyn_banner_slider_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'azyn_layout2', [
		'title' => esc_html__( 'Azyn Creative', 'aheto' ),
		'image' => $preview_dir . 'azyn_layout2.jpg',
	] );

	$shortcode->add_dependecy('azyn_slide_bg', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_arrow_color', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_creative_banners', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_use_subtitle_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_subtitle_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_subtitle_typo', 'azyn_use_subtitle_typo', 'true');
	$shortcode->add_dependecy('azyn_use_title_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_title_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_title_typo', 'azyn_use_title_typo', 'true');
	$shortcode->add_dependecy('azyn_use_num_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_num_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy('azyn_num_typo', 'azyn_use_num_typo', 'true');

	$shortcode->add_params( [
		'azyn_creative_banners' => [
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
				'azyn_first_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title (first line)', 'aheto' ),
					'admin_label' => true,
				],
				'azyn_second_title'         => [
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

		'azyn_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .q_slide .slide .q_split.subtitle h6',
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

		'azyn_use_num_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for slide number?', 'aheto' ),
			'grid'    => 3,
		],

		'azyn_num_typo' => [
			'type'     => 'typography',
			'group'    => 'Slide Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .slidenav__item, {{WRAPPER}} .slidenav span, {{WRAPPER}} .q_slide .number',
		],
		'azyn_slide_bg' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Slides Background Color', 'aheto' ),
			'grid'      => 6,
			'selectors' => ['{{WRAPPER}} .q_slide .slide' => 'background: {{VALUE}}']
		],
		'azyn_arrow_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Arrows color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .q_slide .arrows .arrow i' => 'color: {{VALUE}}',
				'{{WRAPPER}} .q_slide .arrows .arrow-line' => 'background: {{VALUE}}' ]
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'azyn_btn_',
	], 'azyn_creative_banners' );

}

function azyn_banner_slider_layout2_dynamic_css( $css, $shortcode ) {

	if (  $shortcode->atts['azyn_use_subtitle_typo'] && ! empty( $shortcode->atts['azyn_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s  .q_slide .slide .q_split.subtitle h6'], $shortcode->parse_typography( $shortcode->atts['azyn_subtitle_typo'] ) );
	}
	if ( $shortcode->atts['azyn_use_title_typo'] && ! empty( $shortcode->atts['azyn_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .q_slide .slide .slide-title'], $shortcode->parse_typography( $shortcode->atts['azyn_title_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['azyn_arrow_color'] ) ) {
		$color  = Sanitize::color( $shortcode->atts['azyn_arrow_color'] );
		$css['global']['%1$s .q_slide .arrows .arrow i']['color'] = $color;
		$css['global']['%1$s .q_slide .arrows .arrow-line']['background'] = $color;
	}
	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'azyn_banner_slider_layout2_dynamic_css', 10, 2 );
