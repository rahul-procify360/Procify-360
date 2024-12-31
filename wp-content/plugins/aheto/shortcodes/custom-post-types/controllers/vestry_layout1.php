<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'vestry_custom_post_types_layout1');

/**
 * Custom Post Type
 */

function vestry_custom_post_types_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Custom Post Type 16', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
	]);


	$shortcode->add_dependecy('vestry_use_arrow_top', 'template', 'vestry_layout1');

	$shortcode->add_dependecy('vestry_subtitle', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_subtitle_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_subtitle_typo', 'vestry_use_arrow_top', 'true');
	$shortcode->add_dependecy('vestry_subtitle', 'vestry_use_arrow_top', 'true');
	
	$shortcode->add_dependecy('vestry_title', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'vestry_use_arrow_top', 'true');
	$shortcode->add_dependecy('vestry_title', 'vestry_use_arrow_top', 'true');

	aheto_demos_add_dependency(['skin', 'use_heading', 't_heading', 'image_height'], ['vestry_layout1'], $shortcode);

	$shortcode->add_params([
		'vestry_use_arrow_top' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add heading with slider arrow on the top?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Subtitle', 'vestry'),
			'description' => esc_html__('Use custom font for subtitle', 'vestry'),
			'admin_label' => true,
		],
		'vestry_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'vestry_title'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Title', 'vestry'),
			'description' => esc_html__('Use custom font for title', 'vestry'),
			'admin_label' => true,
		],
		'vestry_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__title',
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'vestry_swiper_',
		'include'        => ['arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
		'dependency'     => ['template', ['vestry_layout1']]
	]);
}

function vestry_cpt_image_sizer_layout1($image_sizer_layouts)
{

	$image_sizer_layouts[] = 'vestry_layout1';

	return $image_sizer_layouts;
}

add_filter('aheto_cpt_image_sizer_layouts', 'vestry_cpt_image_sizer_layout1', 10, 2);


function vestry_cpt_layout1_dynamic_css($css, $shortcode)
{
	
	if (!empty($shortcode->atts['vestry_use_arrow_top']) && !empty($shortcode->atts['vestry_subtitle_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['vestry_subtitle_typo']));
	}
	if (!empty($shortcode->atts['vestry_use_arrow_top']) && !empty($shortcode->atts['vestry_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__title'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
	}

	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'vestry_cpt_layout1_dynamic_css', 10, 2);
