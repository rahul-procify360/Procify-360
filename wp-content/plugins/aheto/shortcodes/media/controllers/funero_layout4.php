<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'funero_media_layout4');

/**
 * Media member
 */

function funero_media_layout4($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('funero_layout4', [
		'title' => esc_html__('Media 9', 'funero'),
		'image' => $preview_dir . 'funero_layout4.jpg',
	]);

	$shortcode->add_dependecy('funero_gallery', 'template', ['funero_layout4']);
	$shortcode->add_dependecy('funero_name_use_typo', 'template', ['funero_layout4']);
	$shortcode->add_dependecy('funero_name_typo', 'template', 'funero_layout4');
	$shortcode->add_dependecy('funero_name_typo', 'funero_name_use_typo', 'true');
	$shortcode->add_dependecy('funero_date_use_typo', 'template', ['funero_layout4']);
	$shortcode->add_dependecy('funero_date_typo', 'template', 'funero_layout4');
	$shortcode->add_dependecy('funero_date_typo', 'funero_date_use_typo', 'true');
	$shortcode->add_dependecy('funero_arrows_use_typo', 'template', 'funero_layout4');
	$shortcode->add_dependecy('funero_arrows_typo', 'template', 'funero_layout4');
	$shortcode->add_dependecy('funero_arrows_typo', 'funero_arrows_use_typo', 'true');

	$shortcode->add_params([
		'funero_gallery'         => [
			'type'    => 'group',
			'heading' => esc_html__('Gallery', 'funero'),
			'params'  => [
				'funero_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'funero'),
				],
				'funero_link'  => [
					'type'    => 'link',
					'heading' => esc_html__('Link', 'funero'),
				],
				'funero_name'  => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'funero'),
				],
				'funero_date'  => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'funero'),
				],
			],
		],
		'funero_name_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'funero'),
			'grid'    => 3,
		],
		'funero_name_typo'       => [
			'type'     => 'typography',
			'group'    => 'Funero Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-funero-gallery__name',
		],
		'funero_date_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Date?', 'funero'),
			'grid'    => 3,
		],
		'funero_date_typo'       => [
			'type'     => 'typography',
			'group'    => 'Funero Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-funero-gallery__date',
		],
		'funero_arrows_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Arrows?', 'funero'),
			'grid'    => 3,
		],
		'funero_arrows_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-slides-next, {{WRAPPER}} .swiper-slides-prev',
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Funero Swiper',
		'prefix'         => 'funero_swiper_gallery_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'direction', 'arrows', 'arrows_style', 'slides', 'initial_slide'],
		'dependency'     => ['template', ['funero_layout4']]
	]);
}

function funero_media_layout4_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_name_use_typo']) && $shortcode->atts['funero_name_use_typo'] && isset($shortcode->atts['funero_name_typo'])  && !empty($shortcode->atts['funero_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-funero-gallery__name'], $shortcode->parse_typography($shortcode->atts['funero_name_typo']));
	}
	if ( isset($shortcode->atts['funero_date_use_typo']) && $shortcode->atts['funero_date_use_typo'] && isset($shortcode->atts['funero_date_typo']) && !empty($shortcode->atts['funero_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-funero-gallery__date'], $shortcode->parse_typography($shortcode->atts['funero_date_typo']));
	}
	if ( isset($shortcode->atts['funero_arrows_use_typo']) && $shortcode->atts['funero_arrows_use_typo'] && isset($shortcode->atts['funero_arrows_typo']) && !empty($shortcode->atts['funero_arrows_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-slides-next, %1$s  .swiper-slides-prev'], $shortcode->parse_typography($shortcode->atts['funero_arrows_typo']));
	}
	return $css;
}

add_filter('aheto_media_dynamic_css', 'funero_media_layout4_dynamic_css', 10, 2);