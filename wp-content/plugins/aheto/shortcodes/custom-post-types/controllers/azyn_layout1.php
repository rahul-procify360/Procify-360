<?php


use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'azyn_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function azyn_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'azyn_layout1', [
		'title' => esc_html__( 'Azyn Modern', 'azyn' ),
		'image' => $preview_dir . 'azyn_layout1.jpg',
	] );

	aheto_demos_add_dependency( [
		'use_heading',
		't_heading',
		'use_term',
		't_term',
		'title_tag'
	], [ 'azyn_layout1' ], $shortcode );

}

function azyn_cpt_image_sizer_layout1( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'azyn_layout1';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'azyn_cpt_image_sizer_layout1', 10, 2 );
