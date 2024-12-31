<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'moovit_testimonials_layout1' );

/**
 * Testimonials
 */

function moovit_testimonials_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Testimonials 17', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_bg_text', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_testimonials', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_dark_version', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_bg_text_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_bg_text_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_bg_text_typo', 'moovit_use_bg_text_typo', 'true' );
    $shortcode->add_dependecy( 'moovit_use_dot', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_dot_color', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );

	$shortcode->add_params( [
		'moovit_dark_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark version?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_bg_text'      => [
			'type'    => 'text',
			'heading' => esc_html__( 'Background text', 'moovit' ),
			'default' => esc_html__( 'THEY SAY', 'moovit' ),
		],
		'moovit_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'moovit' ),
			'params'  => [
				'moovit_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'moovit' ),
				],
				'moovit_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'moovit' ),
					'default' => esc_html__( 'Author name', 'moovit' ),
				],
				'moovit_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'moovit' ),
					'default' => esc_html__( 'Author position', 'moovit' ),
				],
				'moovit_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'moovit' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'moovit' ),
				],
			],
		],
        'moovit_use_dot'       => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dot in the end author name?', 'moovit' ),
            'grid'    => 12,
        ],
        'moovit_dot_color'     => [
            'type'    => 'select',
            'heading' => esc_html__( 'Color for dot', 'moovit' ),
            'options' => [
                'primary' => esc_html__( 'Primary', 'moovit' ),
                'dark'    => esc_html__( 'Dark', 'moovit' ),
                'white'   => esc_html__( 'White', 'moovit' ),
            ],
            'default' => 'primary',
        ],
		'moovit_use_bg_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for background text?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_bg_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Background Text Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
		],
	] );


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'include'        => [ 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
		'prefix'         => 'moovit_swiper_',
		'dependency'     => [ 'template', [ 'moovit_layout1' ] ]
	] );

}


function moovit_testimonials_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_bg_text_typo'] ) && ! empty( $shortcode->atts['moovit_bg_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography( $shortcode->atts['moovit_bg_text_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'moovit_testimonials_layout1_dynamic_css', 10, 2 );