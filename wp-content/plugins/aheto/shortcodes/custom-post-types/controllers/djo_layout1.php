<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'djo_custom_post_types_layout1');

/**
 * Custom Post Type Shortcode
 */

function djo_custom_post_types_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Custom Post Type 3', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);


	aheto_demos_add_dependency(['skin','use_heading', 't_heading','title_tag','use_term','t_term'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy('djo_align', 'template', 'djo_layout1');

	$shortcode->add_params([
		'djo_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'djo'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	]);


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'djo_swiper_',
		'include'        => [ 'loop', 'arrows', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'djo_layout1' ] ]
	]);
}
function djo_cpt_image_sizer_layouts( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'djo_layout1';
	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'djo_cpt_image_sizer_layouts', 10, 2 );
