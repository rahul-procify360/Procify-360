<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'acacio_testimonials_layout1' );

/**
 * Testimonials
 */

function acacio_testimonials_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Testimonials 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

    //  Acacio Modern
	$shortcode->add_dependecy( 'acacio_bg_text', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_testimonials', 'template', 'acacio_layout1' );

	$shortcode->add_dependecy( 'acacio_use_name_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_name_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_name_typo', 'acacio_use_name_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_position_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_position_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_position_typo', 'acacio_use_position_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_descr_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_descr_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_descr_typo', 'acacio_use_descr_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout1' );

	$shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bullet_color', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bullet_color', 'acacio_use_bullets_color', 'true' );

	$shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bullet_color_active', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bullet_color_active', 'acacio_use_bullets_color', 'true' );

	$shortcode->add_dependecy( 'acacio_use_bg_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bg_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_bg_text_typo', 'acacio_use_bg_text_typo', 'true' );

	$shortcode->add_params( [
		'acacio_bg_text'         => [
			'type'    => 'text',
			'heading' => esc_html__( 'Background text', 'acacio' ),
			'default' => esc_html__( 'THEY SAY', 'acacio' ),
		],
		'acacio_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'acacio' ),
			'params'  => [
				'g_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'acacio' ),
				],
				'g_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'acacio' ),
					'default' => esc_html__( 'Author name', 'acacio' ),
				],
				'g_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'acacio' ),
					'default' => esc_html__( 'Author position', 'acacio' ),
				],
				'g_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'acacio' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'acacio' ),
				],

			],
		],
		'acacio_hide_pagination'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Hide swiper pagination on desktop?', 'acacio'),
			'grid'      => 4,
		],
		'acacio_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'acacio' ),
			'grid'    => 3,
		],
		'acacio_name_typo' => [
			'type'     => 'typography',
			'group'    => 'Acacio Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'acacio_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'acacio' ),
			'grid'    => 3,
		],
		'acacio_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'acacio_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for testimonials?', 'acacio' ),
			'grid'    => 3,
		],
		'acacio_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Acacio Testimonials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'acacio_use_bullets_color'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Add your colors for swiper bullets?', 'acacio'),
			'grid'      => 4,
		],
		'acacio_bullet_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Swiper bullet color', 'acacio' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
		],
		'acacio_bullet_color_active' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Swiper bullet active color', 'acacio' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
		],
		'acacio_use_bg_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for background text?', 'acacio' ),
			'grid'    => 3,
		],

		'acacio_bg_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Acacio Background Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
		],

	] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_swiper_',
        'include'        => [ 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout1' ] ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for testimonial author ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);

}

function acacio_testimonials_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_name_typo'] ) && ! empty( $shortcode->atts['acacio_name_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['acacio_name_typo'] ) );
    }
	if ( ! empty( $shortcode->atts['acacio_use_bg_text_typo'] ) && ! empty( $shortcode->atts['acacio_bg_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography( $shortcode->atts['acacio_bg_text_typo'] ) );
	}
    if ( ! empty( $shortcode->atts['acacio_use_position_typo'] ) && ! empty( $shortcode->atts['acacio_position_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['acacio_position_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_descr_typo'] ) && ! empty( $shortcode->atts['acacio_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['acacio_descr_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'acacio_testimonials_layout1_dynamic_css', 10, 2 );