<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_testimonials_register', 'kunst_testimonials_layout1' );

function kunst_testimonials_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Kunst Modern', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

	$shortcode->add_dependecy( 'kunst_testimonials', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_style', 'template', 'kunst_layout1' );

	$shortcode->add_dependecy( 'kunst_use_author_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_author_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_author_typo', 'kunst_use_author_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_desc_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_desc_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_desc_typo', 'kunst_use_desc_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_position_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_position_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_position_typo', 'kunst_use_position_typo', 'true' );

	$shortcode->add_params( [

		'kunst_style'     => [
            'type'    => 'select',
            'heading' => esc_html__( 'Testimonial Style', 'kunst' ),
            'options' => [
                ''          => esc_html__( 'Light', 'kunst' ),
                'darkness' => esc_html__( 'Dark', 'kunst' ),
            ],
            'default' => ''
        ],
		'kunst_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'kunst' ),
			'params'  => [
				'kunst_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'kunst' ),
					'default' => esc_html__( 'Author name', 'kunst' ),
				],
				'kunst_position'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'kunst' ),
					'default' => esc_html__( 'Author position', 'kunst' ),
				],
				'kunst_testimonial' => [
					'type'    => 'editor',
					'heading' => esc_html__( 'Testimonial', 'kunst' ),
				],
			],
		],

		'kunst_use_desc_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_desc_typo'     => [
            'type'     => 'typography',
            'group'    => 'Kunst Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__text',
        ],

		'kunst_use_author_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_author_typo'     => [
			'type'     => 'typography',
			'group'    => 'Kunst Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],

		'kunst_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_position_typo'        => [
			'type'     => 'typography',
			'group'    => 'Kunst Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],

	]);

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'include'        => [ 'pagination', 'effect', 'loop', 'autoplay', 'speed', 'direction', 'slides', 'spaces', 'simulate_touch', 'simulate_touch' ],
		'prefix'         => 'kunst_swiper_',
		'dependency'     => [ 'template', [ 'kunst_layout1' ] ]
	]);

}

function kunst_testimonials_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_desc_typo']) && !empty($shortcode->atts['kunst_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['kunst_desc_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_author_typo']) && !empty($shortcode->atts['kunst_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['kunst_author_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_position_typo']) && !empty($shortcode->atts['kunst_position_typo']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['kunst_position_typo']));
    }

	return $css;

}

add_filter( 'aheto_testimonials_dynamic_css', 'kunst_testimonials_layout1_dynamic_css', 10, 2 );
