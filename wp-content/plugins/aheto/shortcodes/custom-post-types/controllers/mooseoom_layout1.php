<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'mooseoom_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function mooseoom_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Custom Post Type 10', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'use_term', 't_term'], [ 'mooseoom_layout1' ], $shortcode );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'mooseoom_swiper_',
		'include'        => [ 'arrows', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows', 'arrows_style', 'arrows_num_typo', 'arrows_color', 'arrows_size'],
		'dependency'     => [ 'template', [ 'mooseoom_layout1' ] ]
	] );
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'         => 'mooseoom_',
		'dependency' => ['template',  'mooseoom_layout1' ]
	]);

}

function mooseoom_cpt_image_sizer_layout1( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'mooseoom_layout1';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'mooseoom_cpt_image_sizer_layout1', 10, 2 );

function mooseoom_custom_post_types_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['mooseoom_use_subtitle_typo']) && !empty($shortcode->atts['mooseoom_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__sub-title'], $shortcode->parse_typography($shortcode->atts['mooseoom_subtitle_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_use_desc_typo']) && !empty($shortcode->atts['mooseoom_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['mooseoom_desc_typo']));
	}
	
	if ( !empty($shortcode->atts['mooseoom_use_arrows_text_typo']) && !empty($shortcode->atts['mooseoom_arrows_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s div.swiper-button-prev span, %1$s div.swiper-button-next span'], $shortcode->parse_typography($shortcode->atts['mooseoom_arrows_text_typo']));
	}

	if ( !empty($shortcode->atts['mooseoom_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['mooseoom_arrows_color']);
	}
	
	if ( !empty($shortcode->atts['mooseoom_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['mooseoom_arrows_size'] );
    }
	if ( ! empty($shortcode->atts['mooseoom_arrows_num_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .swiper-button-next span, %1$s .swiper-button-prev span'], $shortcode->parse_typography( $shortcode->atts['mooseoom_arrows_num_typo'] ) );
    }



	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'mooseoom_custom_post_types_layout1_dynamic_css', 10, 2);