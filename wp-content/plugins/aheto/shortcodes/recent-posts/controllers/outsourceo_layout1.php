<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_recent-posts_register', 'outsourceo_recent_posts_layout1' );

/**
 * Recent Post
 */

function outsourceo_recent_posts_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/recent-posts/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Recent Posts 2', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	aheto_demos_add_dependency( 'limit', [ 'outsourceo_layout1' ], $shortcode );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

}