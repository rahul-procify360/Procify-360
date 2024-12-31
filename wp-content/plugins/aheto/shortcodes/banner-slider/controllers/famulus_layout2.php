<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'famulus_banner_slider_layout2');

/**
 *  Banner Slider
 */

function famulus_banner_slider_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Banner Slider 8', 'aheto'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_h_title_use_typo', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_h_title_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_h_title_typo', 'famulus_h_title_use_typo', 'true');

	$shortcode->add_dependecy('famulus_desc_use_typo', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_desc_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_desc_typo', 'famulus_desc_use_typo', 'true');

	$shortcode->add_dependecy('famulus_overlay_img', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_image_overlay', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_image_overlay', 'famulus_overlay_img', 'true');

	$shortcode->add_dependecy('famulus_banners', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_video_use_typo', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_video_typo', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_video_typo', 'famulus_video_use_typo', 'true');

	$shortcode->add_dependecy('famulus_video_title', 'famulus_video', 'true');
	$shortcode->add_dependecy('famulus_video_link', 'famulus_video', 'true');
	$shortcode->add_dependecy('famulus_video_style', 'famulus_video', 'true');

	$shortcode->add_dependecy('famulus_change_arrow_position', 'template', 'famulus_layout2');

	$shortcode->add_dependecy('famulus_arrow_square', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_arrow_square', 'famulus_change_arrow_position', 'true');


	$shortcode->add_params([
		'famulus_banners' => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'aheto'),
			'params'  => [
				'image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'title'         => [
					'type'        => 'textarea',
					'heading'     => esc_html__('Title', 'aheto'),
					'description' => esc_html__('To Hightlight text insert text between: <i> Your Text Here </i>, To Hightlight text with color insert text between: [[ Your Text Here ]], For text in new line use <br> ', 'aheto'),

				],
				'title_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'aheto'),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'h1',
					'grid'    => 5,
				],
				'desc_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Description', 'aheto'),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'p',
					'grid'    => 5,
				],
				'desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'aheto'),
				],
				'align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'aheto'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'tablet_align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Tablet Align', 'aheto'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'aheto'),
					'options' => [
						''            => esc_html__('Horizontal', 'aheto'),
						'is-vertical' => esc_html__('Vertical', 'aheto'),
					],
				],
				'famulus_video'         => [
					'type'    => 'switch',
					'heading' => esc_html__('Add Video Button?', 'aheto'),
					'grid'    => 12,
				],
				'famulus_video_title'   => [
					'type'    => 'text',
					'heading' => esc_html__('Video Title', 'aheto'),
				],
				'famulus_video_link'    => [
					'type'    => 'text',
					'heading' => esc_html__('Video Link', 'aheto'),
				],
				'famulus_video_style'   => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Style', 'aheto'),
					'options' => [
						''          => esc_html__('Default', 'aheto'),
						'is-active' => esc_html__('Active', 'aheto'),
					],
					'default' => '',
				],
				'overlay'       => [
					'type'    => 'switch',
					'heading' => esc_html__('Add dark overlay?', 'aheto'),
					'grid'    => 12,
				],
			]
		],

		'famulus_h_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'aheto'),
			'grid'    => 3,
		],
		'famulus_h_title_typo'               => [
			'type'     => 'typography',
			'group'    => 'Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__title i, .aheto-banner__title span',
		],
		'famulus_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'aheto'),
			'grid'    => 3,
		],
		'famulus_desc_typo'               => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__desc',
		],
		'famulus_overlay_img'              => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable overlay image for slider?', 'aheto'),
			'grid'    => 12,
		],
		'famulus_image_overlay'            => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Overlay Image', 'aheto')
		],
		'famulus_video_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Video Link?', 'aheto'),
			'grid'    => 3,
		],
		'famulus_video_typo'        => [
			'type'     => 'typography',
			'group'    => 'Video Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__video',
		],
		'famulus_change_arrow_position'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Change arrows position?', 'aheto'),
			'grid'    => 3,
		],
		'famulus_arrow_square'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Arrow square style?', 'aheto'),
			'grid'    => 3,
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'main_',
	], 'famulus_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'aheto'),
		'prefix'    => 'add_',
	], 'famulus_banners');

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'famulus_swiper_simple_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy'],
		'dependency'     => ['template', ['famulus_layout2']]
	]);
}

function famulus_banner_slider_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_h_title_use_typo']) && $shortcode->atts['famulus_h_title_use_typo'] && isset($shortcode->atts['famulus_h_title_typo']) && !empty($shortcode->atts['famulus_h_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__title i, .aheto-banner__title span'], $shortcode->parse_typography($shortcode->atts['famulus_h_title_typo']));
	}

	if ( isset($shortcode->atts['famulus_desc_use_typo']) && $shortcode->atts['famulus_desc_use_typo'] && isset($shortcode->atts['famulus_desc_typo']) && !empty($shortcode->atts['famulus_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__desc'], $shortcode->parse_typography($shortcode->atts['famulus_desc_typo']));
	}

	if ( isset($shortcode->atts['famulus_video_typo']) && !empty($shortcode->atts['famulus_video_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__video'], $shortcode->parse_typography($shortcode->atts['famulus_video_typo']));
	}

	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'famulus_banner_slider_layout2_dynamic_css', 10, 2);