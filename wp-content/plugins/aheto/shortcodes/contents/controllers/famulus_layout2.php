<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout2');


/**
 * Contents
 */

function famulus_contents_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Content 7', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency('title_typo', ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_creative_items', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_use_typo_hightlight', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_hightlight', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_hightlight', 'famulus_use_typo_hightlight', 'true');
	$shortcode->add_dependecy('famulus_use_link_hightlight', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_typo_hightlight', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_typo_hightlight', 'famulus_use_link_hightlight', 'true');
	$shortcode->add_dependecy('famulus_use_link_a', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_typo_a', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_link_typo_a', 'famulus_use_link_a', 'true');
	$shortcode->add_params([


		'famulus_creative_items'       => [
			'type'    => 'group',
			'heading' => esc_html__('Slides', 'famulus'),
			'params'  => [
				'famulus_item_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'famulus'),
				],

				'famulus_item_title' => [
					'type'        => 'text',
					'heading'     => esc_html__('Title', 'famulus'),
					'description' => esc_html__(' For highlight title use [[ hightlight ]] , for new line use <br>.', 'famulus'),

				],

				'famulus_item_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'famulus'),
				],
				'famulus_item_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'famulus'),
					'options' => [
						''              => esc_html__('Horizontal', 'famulus'),
						'space_between' => esc_html__('Horizontal Space Between', 'famulus'),
						'is-vertical'   => esc_html__('Vertical', 'famulus'),
					],
				],
			]
		],
		'famulus_use_typo_hightlight'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_hightlight' => [
			'type'     => 'typography',
			'group'    => 'Famulus Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title span',
		],
		'famulus_use_link_hightlight'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo_hightlight'      => [
			'type'     => 'typography',
			'group'    => 'Famulus Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__links a',
		],
		'famulus_use_link_a'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link arrow?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo_a' => [
			'type'     => 'typography',
			'group'    => 'Famulus Link Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.swiper-button-prev, {{WRAPPER}} div.swiper-button-next',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'famulus_main_',
		'icons'  => true,
	], 'famulus_creative_items');
	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'famulus'),
		'prefix'    => 'famulus_add_',
		'icons'     => true,
	], 'famulus_creative_items');
	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'famulus_swiper_',
		'include'        => ['speed', 'loop', 'autoplay', 'arrows', 'lazy'],
		'dependency'     => ['template', ['famulus_layout2']]
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'famulus_content_img',
		'dependency' => ['template', 'famulus_layout2']
	]);
}


function famulus_contents_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_hightlight']) && $shortcode->atts['famulus_use_typo_hightlight'] && isset($shortcode->atts['famulus_text_typo_hightlight']) && !empty($shortcode->atts['famulus_text_typo_hightlight']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__title span'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_hightlight']));
	}
	if ( isset($shortcode->atts['famulus_use_link_hightlight']) && $shortcode->atts['famulus_use_link_hightlight'] && isset($shortcode->atts['famulus_link_typo_hightlight']) && !empty($shortcode->atts['famulus_link_typo_hightlight']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__links a'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo_hightlight']));
	}
	if ( isset($shortcode->atts['famulus_use_link_a']) && $shortcode->atts['famulus_use_link_a'] && isset($shortcode->atts['famulus_link_typo_a']) && !empty($shortcode->atts['famulus_link_typo_a']) ) {
		\aheto_add_props($css['global']['%1$s div.swiper-button-prev, %1$s div.swiper-button-next'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo_a']));
	}
	return $css;
}

add_filter('aheto_contents_dynamic_css', 'famulus_contents_layout2_dynamic_css', 10, 2);

