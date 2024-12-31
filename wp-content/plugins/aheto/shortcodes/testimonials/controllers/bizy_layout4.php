<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'bizy_testimonials_layout4' );

/**
 * Testimonials
 */

function bizy_testimonials_layout4( $shortcode ) {

    $preview_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout( 'bizy_layout4', [
        'title' => esc_html__( 'Bizy Gradient', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout4.jpg',
    ] );

    $shortcode->add_dependecy( 'bizy_testimonials_items', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_max_width', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_change_author', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_bullet', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_bullet_active', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_use_text_typo', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_text_typo', 'template', [ 'bizy_layout4' ] );
    $shortcode->add_dependecy( 'bizy_text_typo', 'bizy_use_text_typo', 'true' );

	$shortcode->add_dependecy( 'bizy_use_author_typo', 'template', [ 'bizy_layout4' ] );
	$shortcode->add_dependecy( 'bizy_author_typo', 'template', [ 'bizy_layout4' ] );
	$shortcode->add_dependecy( 'bizy_author_typo', 'bizy_use_author_typo', 'true' );

	$shortcode->add_dependecy( 'bizy_use_position_typo', 'template', [ 'bizy_layout4' ] );
	$shortcode->add_dependecy( 'bizy_position_typo', 'template', [ 'bizy_layout4' ] );
	$shortcode->add_dependecy( 'bizy_position_typo', 'bizy_use_position_typo', 'true' );

    $shortcode->add_params( [
        'bizy_testimonials_items' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Modern Testimonials Items', 'bizy' ),
            'params'  => [
                'bizy_name'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Name', 'bizy' ),
                    'default' => esc_html__( 'Author name', 'bizy' ),
                ],
                'bizy_company'     => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Position', 'bizy' ),
                    'default' => esc_html__( 'Author position', 'bizy' ),
                ],
                'bizy_testimonial' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Testimonial', 'bizy' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'bizy' ),
                ],
            ],
        ],
        'bizy_max_width'    => [
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
		        '{{WRAPPER}} .aheto-tm__content' => 'max-width: {{SIZE}}{{UNIT}}; margin: auto;',
	        ],
        ],
        'bizy_change_author' => [
	        'type' => 'switch',
	        'heading' => esc_html__ ( 'Use another style for author?', 'bizy' ),
	        'grid' => 3,
        ],
        'bizy_bullet'    => [
	        'type'      => 'colorpicker',
	        'heading'   => esc_html__( 'Bullet color', 'bizy' ),
	        'grid'      => 6,
	        'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
	        'selectors' => [
		        '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}}'
	        ],
        ],
        'bizy_bullet_active'    => [
	        'type'      => 'colorpicker',
	        'heading'   => esc_html__( 'Bullet active color', 'bizy' ),
	        'grid'      => 6,
	        'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
	        'selectors' => [
		        '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}}'
	        ],
        ],
        'bizy_use_text_typo' => [
	        'type' => 'switch',
	        'heading' => esc_html__ ( 'Use custom font for text?', 'bizy' ),
	        'grid' => 3,
        ],
        'bizy_text_typo' => [
	        'type' => 'typography',
	        'group' => 'Text Typography',
	        'settings' => [
		        'tag' => false,
		        'text_align' => false,
	        ],
	        'selector' => '{{WRAPPER}} .aheto-tm__text',
        ],
        'bizy_use_author_typo' => [
	        'type' => 'switch',
	        'heading' => esc_html__ ( 'Use custom font for author?', 'bizy' ),
	        'grid' => 3,
        ],
        'bizy_author_typo' => [
	        'type' => 'typography',
	        'group' => 'Author Typography',
	        'settings' => [
		        'tag' => false,
		        'text_align' => false,
	        ],
	        'selector' => '{{WRAPPER}} .aheto-tm__name',
        ],
        'bizy_use_position_typo' => [
	        'type' => 'switch',
	        'heading' => esc_html__ ( 'Use custom font for position?', 'bizy' ),
	        'grid' => 3,
        ],
        'bizy_position_typo' => [
	        'type' => 'typography',
	        'group' => 'Position Typography',
	        'settings' => [
		        'tag' => false,
		        'text_align' => false,
	        ],
	        'selector' => '{{WRAPPER}} .aheto-tm__position',
        ],
    ] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        'custom_options' => true,
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows',  'pagination', 'lazy', 'simulate_touch', 'slides', 'spaces'],
        'prefix'         => 'bizy_swiper_',
        'dependency'     => [ 'template', [ 'bizy_layout4' ] ]
    ] );

}


function bizy_testimonials_layout4_dynamic_css ( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['bizy_bullet'] ) ) {
		$color = Sanitize::color( $shortcode->atts['bizy_bullet'] );
		$css['global']['%1$s .swiper-pagination .swiper-pagination-bullet']['background'] = $color;
	}
	if ( ! empty( $shortcode->atts['bizy_bullet_active'] ) ) {
		$size = Sanitize::size( $shortcode->atts['bizy_bullet_active'] );
		$css['global']['%1$s .swiper-pagination .swiper-pagination-bullet-active']['background'] = $size;
	}
	if ( !empty( $shortcode -> atts['bizy_use_text_typo'] ) && !empty( $shortcode -> atts['bizy_text_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-tm__text'], $shortcode -> parse_typography ( $shortcode -> atts['bizy_text_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['bizy_use_author_typo'] ) && !empty( $shortcode -> atts['bizy_author_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-tm__name'], $shortcode -> parse_typography ( $shortcode -> atts['bizy_author_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['bizy_use_position_typo'] ) && !empty( $shortcode -> atts['bizy_position_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-tm__position'], $shortcode -> parse_typography ( $shortcode -> atts['bizy_position_typo'] ) );
	}

	return $css;
}

add_filter ( 'aheto_testimonials_dynamic_css', 'bizy_testimonials_layout4_dynamic_css', 10, 2 );