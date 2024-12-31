<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'hryzantema_testimonials_layout1');

/**
 * Testimonials Shortcode
 */

function hryzantema_testimonials_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Testimonials 9', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'hryzantema_bg_text', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_testimonials', 'template', 'hryzantema_layout1' );

	$shortcode->add_dependecy( 'hryzantema_use_name_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_name_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_name_typo', 'hryzantema_use_name_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_position_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'hryzantema_use_position_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_descr_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_descr_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_descr_typo', 'hryzantema_use_descr_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_bg_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bg_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bg_typo', 'hryzantema_use_bg_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_hide_pagination', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_bullets_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color', 'hryzantema_use_bullets_color', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_bullets_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color_active', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_bullet_color_active', 'hryzantema_use_bullets_color', 'true' );

	$shortcode->add_params( [
		'hryzantema_bg_text'         => [
			'type'    => 'text',
			'heading' => esc_html__( 'Background text', 'hryzantema' ),
			'default' => esc_html__( 'THEY SAY', 'hryzantema' ),
		],
		'hryzantema_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'hryzantema' ),
			'params'  => [
				'g_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'hryzantema' ),
				],
				'g_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'hryzantema' ),
					'default' => esc_html__( 'Author name', 'hryzantema' ),
				],
				'g_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'hryzantema' ),
					'default' => esc_html__( 'Author position', 'hryzantema' ),
				],
				'g_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'hryzantema' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'hryzantema' ),
				],
				'g_rating' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Rate testimonials', 'hryzantema' ),
					'options' => [
						'1'  => 1,
						'2'  => 2,
						'3'  => 3,
						'4'  => 4,
						'5'  => 5,

					],
					'default' => '3',
					'grid'    => 5,
				],

			],
		],
		'hryzantema_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_name_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'hryzantema_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'hryzantema_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
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
		'hryzantema_use_bg_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for background text?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_bg_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Background Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
		],
	] );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_swiper_',
		'include'        => ['pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'hryzantema_layout1' ] ],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Images size for testimonial author ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout1'] ]
	]);

}


function hryzantema_testimonials_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_name_typo'] ) && $shortcode->atts['hryzantema_use_name_typo'] && isset( $shortcode->atts['hryzantema_name_typo'] ) && ! empty( $shortcode->atts['hryzantema_name_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['hryzantema_name_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_position_typo'] ) && $shortcode->atts['hryzantema_use_position_typo'] && isset( $shortcode->atts['hryzantema_position_typo'] ) && ! empty( $shortcode->atts['hryzantema_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['hryzantema_position_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_descr_typo'] ) && $shortcode->atts['hryzantema_use_descr_typo'] && isset( $shortcode->atts['hryzantema_descr_typo'] ) && ! empty( $shortcode->atts['hryzantema_descr_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_descr_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_bg_typo'] ) && $shortcode->atts['hryzantema_use_bg_typo'] && isset( $shortcode->atts['hryzantema_bg_typo'] ) && ! empty( $shortcode->atts['hryzantema_bg_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_bg_typo'] ) );
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

add_filter( 'aheto_testimonials_dynamic_css', 'hryzantema_testimonials_layout1_dynamic_css', 10, 2 );
