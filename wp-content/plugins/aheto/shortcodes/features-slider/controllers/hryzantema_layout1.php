<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'hryzantema_features_slider_layout1');

/**
 * HR Consult features slider shortcode
 */

function hryzantema_features_slider_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Features Slider 3', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );
	aheto_demos_add_dependency( ['t_heading', 'use_heading', 't_description', 'use_description'], [ 'hryzantema_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'hr_features_slider', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_background_color', 'hryzantema_background_type', 'color' );
	$shortcode->add_dependecy( 'hryzantema_bg_image', 'hryzantema_background_type', 'image' ) ;
	$shortcode->add_dependecy( 'hryzantema_hide_pagination', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_bullets_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color', 'hryzantema_use_bullets_color', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_bullets_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color_active', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color_active', 'hryzantema_use_bullets_color', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_title_typo', 'template', ['hryzantema_layout1'] );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'hryzantema_use_title_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_text_typo', 'template', ['hryzantema_layout1'] );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'hryzantema_use_text_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_arrow_typo', 'template', ['hryzantema_layout1'] );
	$shortcode->add_dependecy( 'hryzantema_arrow_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_arrow_typo', 'hryzantema_use_arrow_typo', 'true' );
	$shortcode->add_params( [
		'hr_features_slider' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Features', 'hryzantema' ),
			'params'  => [
				'hryzantema_background_type' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Slider background type', 'hryzantema' ),
					'options' => [
						'color' => esc_html__( 'Color', 'hryzantema' ),
						'image' => esc_html__( 'Image', 'hryzantema' ),
					],
					'default' => 'color',
				],
				'hryzantema_background_color' => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Shape background color', 'hryzantema' ),
					'grid'      => 6,
					'selectors' => [ '{{WRAPPER}} .aheto-features-slider-image-wrap' => 'background-color: {{VALUE}}' ],
				],
				'hryzantema_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'hryzantema' ),
				],
				'hryzantema_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'hryzantema' ),
				],

				'hryzantema_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'hryzantema' ),
					'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'hryzantema' ),
					'admin_label' => true,
					'default'     => esc_html__( 'Heading with [[ hightlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'hryzantema' ),
				],
				'hryzantema_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'hryzantema' ),
				],
				'align'         => true,
				'btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'hryzantema' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'hryzantema' ),
						'is-vertical' => esc_html__( 'Vertical', 'hryzantema' ),
					],
				],
			]
		],
		'hryzantema_hide_pagination'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Hide swiper pagination on desktop?', 'hryzantema'),
			'grid'      => 4,
		],
		'hryzantema_use_bullets_color'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Add your colors for swiper bullets?', 'hryzantema'),
			'grid'      => 4,
		],
		'hryzantema_bullet_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Swiper bullet color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
		],
		'hryzantema_bullet_color_active' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Swiper bullet active color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
		],
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__title',
		],
		'hryzantema_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__info-text',
		],
		'hryzantema_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for arrow?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-button-next::before, {{WRAPPER}} .swiper-button-prev::before',
		],
	] );



	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'include'        => ['arrows', 'pagination', 'delay', 'speed', 'loop', 'simulate_touch', 'autoplay'],
		'prefix' => 'hryzantema_',
		'dependency' => ['template', ['hryzantema_layout1']],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),
	]);

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons'  => true,
	], 'hr_features_slider' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'hryzantema' ),
		'prefix'    => 'hryzantema_add_',
		'icons'  => true,
	], 'hr_features_slider' );

}
function hryzantema_features_slider_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] )  && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-slider__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_text_typo'] ) && $shortcode->atts['hryzantema_use_text_typo'] && isset( $shortcode->atts['hryzantema_text_typo'] )  && ! empty( $shortcode->atts['hryzantema_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-slider__info-text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_text_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_arrow_typo'] ) && $shortcode->atts['hryzantema_use_arrow_typo'] && isset( $shortcode->atts['hryzantema_arrow_typo'] )  && ! empty( $shortcode->atts['hryzantema_arrow_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .swiper-button-next::before, %1$s .swiper-button-prev::before'], $shortcode->parse_typography( $shortcode->atts['hryzantema_arrow_typo'] ) );
	}
	if (!empty($shortcode->atts['hryzantema_bullet_color'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_bullet_color']);
		$css['global']['%1$s .swiper-pagination-bullet']['background'] = $color;
	}
	if (!empty($shortcode->atts['hryzantema_bullet_color_active'])) {
		$color = Sanitize::color($shortcode->atts['hryzantema_bullet_color_active']);
		$css['global']['%1$s .swiper-pagination-bullet-active']['background'] = $color;
	}
	return $css;
}

add_filter( 'aheto_features_slider_dynamic_css', 'hryzantema_features_slider_layout1_dynamic_css', 10, 2 );