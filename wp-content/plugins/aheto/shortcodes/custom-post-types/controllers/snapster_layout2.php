<?php

add_action('aheto_before_aheto_custom-post-types_register', 'snapster_custom_post_types_layout2_shortcode');

/**
 * Banner Slider shortcode
 */
function snapster_custom_post_types_layout2_shortcode($shortcode){
	$dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('snapster_layout2', [
		'title' => esc_html__('Snapster Modern Slider', 'snapster'),
		'image' => $dir . 'snapster_layout2.jpg',
	]);

	aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_term', 't_term', 'title_tag', 'skin'], [ 'snapster_layout2' ], $shortcode );

	$shortcode->add_dependecy('snapster_main_image', 'template', 'snapster_layout2');
	$shortcode->add_dependecy('snapster_main_add_image', 'template', 'snapster_layout2');
	$shortcode->add_dependecy('snapster_subtitle', 'template', 'snapster_layout2');
	$shortcode->add_dependecy('snapster_title', 'template', 'snapster_layout2');
	$shortcode->add_dependecy('snapster_link_url', 'template', 'snapster_layout2');


	$shortcode->add_params([
		'snapster_main_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Image for Main item', 'snapster' ),
		],
		'snapster_main_add_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Additional Image for Main item', 'snapster' ),
		],
		'snapster_subtitle'         => [
			'type'    => 'text',
			'heading' => esc_html__( 'Subtitle for Main item', 'snapster' ),
		],
		'snapster_title'         => [
			'type'    => 'text',
			'heading' => esc_html__( 'Title for Main item', 'snapster' ),
		],
		'snapster_link_url' => [
			'type'        => 'link',
			'heading'     => esc_html__('Link for Main item', 'snapster'),
			'default'     => [
				'url' => '#',
			],
		]
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'group'          => esc_html__( 'Snapster Swiper', 'snapster' ),
		'custom_options' => true,
		'prefix' => 'snapster_h_swiper_',
		'include' => ['speed', 'autoplay', 'lazy', 'simulate_touch', 'spaces', 'loop'],
		'dependency' => ['template', 'snapster_layout2']
	]);
}

function snapster_cpt_image_sizer_layout2( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'snapster_layout2';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'snapster_cpt_image_sizer_layout2', 10, 2 );