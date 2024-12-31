<?php

add_action('aheto_before_aheto_custom-post-types_register', 'snapster_custom_post_types_layout3_shortcode');

/**
 * Banner Slider shortcode
 */
function snapster_custom_post_types_layout3_shortcode($shortcode){
	$dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('snapster_layout3', [
		'title' => esc_html__('Snapster Horizontal Slider', 'snapster'),
		'image' => $dir . 'snapster_layout3.jpg',
	]);

	aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_term', 't_term', 'title_tag', 'skin'], [ 'snapster_layout3' ], $shortcode );


	\Aheto\Params::add_carousel_params($shortcode, [
		'group'          => esc_html__( 'Snapster Swiper', 'snapster' ),
		'custom_options' => true,
		'prefix' => 'snapster_t_swiper_',
		'include' => ['speed', 'autoplay', 'lazy', 'simulate_touch', 'spaces', 'loop'],
		'dependency' => ['template', 'snapster_layout3']
	]);
}

function snapster_cpt_image_sizer_layout3( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'snapster_layout3';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'snapster_cpt_image_sizer_layout3', 10, 2 );