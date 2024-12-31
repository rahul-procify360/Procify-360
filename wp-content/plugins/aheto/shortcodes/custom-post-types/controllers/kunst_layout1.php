<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'kunst_custom_post_types_layout1' );

/**
 * Custom post type Shortcode
 */

function kunst_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Kunst Slider', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

	aheto_demos_add_dependency( [ 't_heading', 'use_heading', 'title_tag' ], [ 'kunst_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_reverse_cpt', 'template', 'kunst_layout1' );

	$shortcode->add_dependecy( 'kunst_use_pag_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_pag_text_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_pag_text_typo', 'kunst_use_pag_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_link_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'kunst_use_link_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_desc_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_desc_text_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_desc_text_typo', 'kunst_use_desc_typo', 'true' );

	$shortcode->add_params( [

		'kunst_reverse_cpt' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use reverse Custom Post Type', 'kunst' ),
			'grid'    => 3,
		],

		'kunst_use_pag_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Pagination?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_pag_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Pagination Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
		],

		'kunst_use_desc_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_desc_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt > p',
        ],


        'kunst_use_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Link?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Link Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-link',
        ],

    ]);

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'kunst_swiper_',
		'include'        => [ 'arrows', 'effect', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_color', 'arrows_size' ],
		'dependency'     => [ 'template', [ 'kunst_layout1' ] ]
	]);

}

function kunst_cpt_image_sizer_layout1( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'kunst_layout1';

	return $image_sizer_layouts;

}

function kunst_custom_post_types_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_desc_typo']) && !empty($shortcode->atts['kunst_desc_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt > p'], $shortcode->parse_typography($shortcode->atts['kunst_desc_text_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_pag_typo']) && !empty($shortcode->atts['kunst_pag_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-pagination-bullet'], $shortcode->parse_typography($shortcode->atts['kunst_pag_text_typo']));
	}

	if ( !empty($shortcode->atts['kunst_arrows_color']) ) {
		$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['kunst_arrows_color']);
	}

    if ( !empty($shortcode->atts['kunst_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['kunst_arrows_size'] );
    }

	return $css;

}

add_filter( 'aheto_dynamic_css_custom_post_types', 'kunst_custom_post_types_layout1_dynamic_css', 10, 2 );
add_filter( 'aheto_cpt_image_sizer_layout1', 'kunst_cpt_image_sizer_layout1', 10, 2 );
