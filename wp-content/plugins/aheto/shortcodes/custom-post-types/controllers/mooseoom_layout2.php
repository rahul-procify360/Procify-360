<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'mooseoom_custom_post_types_layout2' );

/**
 * Custom Post Type
 */

function mooseoom_custom_post_types_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'mooseoom_layout2', [
		'title' => esc_html__( 'Custom Post Type 11', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	] );

	aheto_demos_add_dependency(['skin', 'title_tag', 'item_per_row', 'spaces', 'item_per_row_lg', 'spaces_lg', 'item_per_row_md', 'spaces_md', 'item_per_row_sm', 'spaces_sm', 'item_per_row_xs', 'spaces_xs', 'use_heading', 't_heading', 'use_term', 't_term'], ['mooseoom_layout2' ], $shortcode);

}

function mooseoom_cpt_image_sizer_layout2( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'mooseoom_layout2';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'mooseoom_cpt_image_sizer_layout2', 10, 2 );