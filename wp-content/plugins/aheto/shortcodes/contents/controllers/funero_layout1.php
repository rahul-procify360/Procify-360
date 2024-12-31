<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'funero_contents_layout1');

/**
 * Contents shortcode
 */

function funero_contents_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Content 12', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);
	$shortcode->add_dependecy('funero_creative_items', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_subtitle_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_add_subtitle_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_subtitle_typo', 'funero_add_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('funero_add_title_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_add_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_title_typo', 'funero_add_title_use_typo', 'true');
	$shortcode->add_dependecy('funero_add_desc_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_add_desc_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_add_desc_typo', 'funero_add_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_arrows_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_arrows_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_arrows_typo', 'funero_arrows_use_typo', 'true');
	$shortcode->add_dependecy('funero_btn_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_btn_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_btn_typo', 'funero_btn_use_typo', 'true');

	$shortcode->add_params([
		'funero_creative_items'     => [
			'type'    => 'group',
			'heading' => esc_html__('Slides', 'funero'),
			'params'  => [
				'funero_item_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'funero'),
				],
				'funero_image_overlay' => [
					'type'    => 'switch',
					'heading' => esc_html__('Add Dark Overlay?', 'funero'),
					'grid'    => 3,
				],
				'funero_item_subtitle' => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'funero'),

				],
				'funero_item_title'    => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'funero'),

				],

				'funero_item_desc'       => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'funero'),
				],
				'funero_item_image_left' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image Left', 'funero'),
				],
			]
		],
		'funero_add_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title',
		],
		'funero_add_desc_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_desc_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__desc, {{WRAPPER}}  .aheto-contents__desc *',
		],

		'funero_add_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_add_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__subtitle',
		],
		'funero_arrows_use_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Arrows?', 'funero'),
			'grid'    => 3,
		],
		'funero_arrows_typo'           => [
			'type'     => 'typography',
			'group'    => 'Funero Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
		],
		'funero_btn_use_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Button?', 'funero'),
			'grid'    => 3,
		],
		'funero_btn_typo'              => [
			'type'     => 'typography',
			'group'    => 'Funero Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__links  a',
		],

	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'funero_main_',
		'icons'  => true,
	], 'funero_creative_items');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Funero Swiper',
		'prefix'         => 'funero_swiper_',
		'include'        => ['speed', 'loop', 'autoplay', 'arrows', 'lazy'],
		'dependency'     => ['template', ['funero_layout1']]
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'          => 'Funero Image',
		'prefix'     => 'funero_content_img',
		'dependency' => ['template', ['funero_layout1']]
	]);

}

function funero_contents_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_add_subtitle_use_typo']) && $shortcode->atts['funero_add_subtitle_use_typo'] && isset($shortcode->atts['funero_add_subtitle_typo']) && !empty($shortcode->atts['funero_add_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_add_subtitle_typo']));
	}
	if ( isset($shortcode->atts['funero_add_title_use_typo']) && $shortcode->atts['funero_add_title_use_typo'] && isset($shortcode->atts['funero_add_title_typo']) && !empty($shortcode->atts['funero_add_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography($shortcode->atts['funero_add_title_typo']));
	}
	if ( isset($shortcode->atts['funero_add_desc_use_typo']) && $shortcode->atts['funero_add_desc_use_typo'] && isset($shortcode->atts['funero_add_desc_typo']) && !empty($shortcode->atts['funero_add_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__desc, %1$s .aheto-contents__desc *'], $shortcode->parse_typography($shortcode->atts['funero_add_desc_typo']));
	}
	if ( isset($shortcode->atts['funero_arrows_use_typo']) && $shortcode->atts['funero_arrows_use_typo'] && isset($shortcode->atts['funero_arrows_typo']) && !empty($shortcode->atts['funero_arrows_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-button-next, %1$s  .swiper-button-prev'], $shortcode->parse_typography($shortcode->atts['funero_arrows_typo']));
	}
	if ( isset($shortcode->atts['funero_btn_use_typo']) && $shortcode->atts['funero_btn_use_typo'] && isset($shortcode->atts['funero_btn_typo']) && !empty($shortcode->atts['funero_btn_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__links  a'], $shortcode->parse_typography($shortcode->atts['funero_btn_typo']));
	}
	return $css;
}

add_filter('aheto_contents_dynamic_css', 'funero_contents_layout1_dynamic_css', 10, 2);
