<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-tabs_register', 'djo_features_tabs_layout1');

/**
 * Features Tabs
 */

function djo_features_tabs_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Features Tabs 2', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);

	$shortcode->add_dependecy('djo_tabs', 'template', 'djo_layout1');

	aheto_demos_add_dependency(['t_title', 'use_title'], ['djo_layout1'], $shortcode);
	$shortcode->add_dependecy( 'djo_use_link', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'djo_use_link', 'true' );
	$shortcode->add_dependecy( 'djo_use_subtitle', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_subtitle_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_subtitle_typo', 'djo_use_subtitle', 'true' );
	$shortcode->add_dependecy( 'djo_use_date', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_date_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_date_typo', 'djo_use_date', 'true' );
	$shortcode->add_dependecy( 'djo_use_desc', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_desc_typo', 'djo_use_desc', 'true' );
	$shortcode->add_dependecy( 'djo_use_arrow', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_arrow_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_arrow_typo', 'djo_use_arrow', 'true' );


	$shortcode->add_params([
		'djo_use_link' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'djo' ),
			'grid'    => 6,
		],

		'djo_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
		],
		'djo_use_desc' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'djo' ),
			'grid'    => 6,
		],

		'djo_desc_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__box-description',
		],
		'djo_use_date' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date?', 'djo' ),
			'grid'    => 6,
		],

		'djo_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__box-info',
		],
		'djo_use_subtitle' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'djo' ),
			'grid'    => 6,
		],

		'djo_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__box-subtitle',
		],
		'djo_use_arrow' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for arrow?', 'djo' ),
			'grid'    => 6,
		],

		'djo_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-button-prev:before,	{{WRAPPER}}	.swiper-button-next:before',
		],
		'djo_tabs'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Tabs', 'djo'),
			'params'  => [
				'djo_main_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Main Heading', 'djo'),
				],
				/*
					Item 1
				*/
				'djo_image1'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-1 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle1' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-1 Subtitle', 'djo'),
				],
				'djo_subtitle_tag1' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-1 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title1'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-1 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag1' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-1 Content Title tag', 'djo'),
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
					'default' => 'h3',
					'grid'    => 2,
				],
				'djo_info1' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-1 Additional info(under title)', 'djo'),
				],
				'djo_description1' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-1 Description', 'djo'),
				],
				'djo_link_title1'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-1 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url1'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-1 Link URL', 'djo'),
					'grid'    => 12,
				],
				/*
					Item 2
				*/
				'djo_image2'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-2 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle2' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-2 Subtitle', 'djo'),
				],
				'djo_subtitle_tag2' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-2 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title2'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-2 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag2' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-2 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info2' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-2 Additional info(under title)', 'djo'),
				],
				'djo_description2' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-2 Description', 'djo'),
				],
				'djo_link_title2'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-2 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url2'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-2 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 3
				*/
				'djo_image3'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-3 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle3' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-3 Subtitle', 'djo'),
				],
				'djo_subtitle_tag3' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-3 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title3'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-3 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag3' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-3 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info3' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-3 Additional info(under title)', 'djo'),
				],
				'djo_description3' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-3 Description', 'djo'),
				],
				'djo_link_title3'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-3 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url3'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-3 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 4
				*/
				'djo_image4'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-4 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle4' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-4 Subtitle', 'djo'),
				],
				'djo_subtitle_tag4' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-4 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title4'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-4 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag4' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-4 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info4' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-4 Additional info(under title)', 'djo'),
				],
				'djo_description4' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-4 Description', 'djo'),
				],
				'djo_link_title4'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-4 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url4'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-4 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 5
				*/
				'djo_image5'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-5 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle5' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-5 Subtitle', 'djo'),
				],
				'djo_subtitle_tag5' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-5 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title5'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-5 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag5' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-5 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info5' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-5 Additional info(under title)', 'djo'),
				],
				'djo_description5' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-5 Description', 'djo'),
				],
				'djo_link_title5'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-5 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url5'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-5 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 6
				*/
				'djo_image6'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-6 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle6' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-6 Subtitle', 'djo'),
				],
				'djo_subtitle_tag6' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-6 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title6'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-6 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag6' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-6 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info6' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-6 Additional info(under title)', 'djo'),
				],
				'djo_description6' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-6 Description', 'djo'),
				],
				'djo_link_title6'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-6 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url6'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-6 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 7
				*/
				'djo_image7'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-7 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle7' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-7 Subtitle', 'djo'),
				],
				'djo_subtitle_tag7' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-7 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title7'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-7 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag7' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-7 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info7' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-7 Additional info(under title)', 'djo'),
				],
				'djo_description7' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-7 Description', 'djo'),
				],
				'djo_link_title7'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-7 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url7'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-7 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 8
				*/
				'djo_image8'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-8 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle8' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-8 Subtitle', 'djo'),
				],
				'djo_subtitle_tag8' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-8 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title8'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-8 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag8' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-8 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info8' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-8 Additional info(under title)', 'djo'),
				],
				'djo_description8' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-8 Description', 'djo'),
				],
				'djo_link_title8'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-8 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url8'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-8 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 9
				*/
				'djo_image9'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-9 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle9' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-9 Subtitle', 'djo'),
				],
				'djo_subtitle_tag9' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-9 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title9'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-9 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag9' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-9 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info9' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-9 Additional info(under title)', 'djo'),
				],
				'djo_description9' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-9 Description', 'djo'),
				],
				'djo_link_title9'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-9 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url9'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-9 Link URL', 'djo'),
					'grid'    => 12,
				],

				/*
					Item 10
				*/
				'djo_image10'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Event-10 Image', 'djo'),
					'description' => esc_html__('The Event will not show unless an image is added', 'djo'),
				],
				'djo_subtitle10' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-10 Subtitle', 'djo'),
				],
				'djo_subtitle_tag10' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-10 Subtitle tag', 'djo'),
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
					'grid'    => 2,
				],
				'djo_title10'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-10 Content Title', 'djo'),
					'grid'    => 12,
				],
				'djo_title_tag10' => [
					'type'    => 'select',
					'heading' => esc_html__('Event-10 Content Title tag', 'djo'),
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
					'default' => 'h2',
					'grid'    => 2,
				],
				'djo_info10' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-10 Additional info(under title)', 'djo'),
				],
				'djo_description10' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Event-10 Description', 'djo'),
				],
				'djo_link_title10'     => [
					'type'    => 'text',
					'heading' => esc_html__('Event-10 Link Title', 'djo'),
					'grid'    => 12,
				],
				'djo_link_url10'     => [
					'type'    => 'link',
					'heading' => esc_html__('Event-10 Link URL', 'djo'),
					'grid'    => 12,
				],
			],
		],
	]);
}

function djo_features_tabs_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_link']) && $shortcode->atts['djo_use_link'] && isset($shortcode->atts['djo_link_typo']) && !empty($shortcode->atts['djo_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__list-link'], $shortcode->parse_typography($shortcode->atts['djo_link_typo']));
	}
	if ( isset($shortcode->atts['djo_use_desc']) && $shortcode->atts['djo_use_desc'] && isset($shortcode->atts['djo_desc_typo']) && !empty($shortcode->atts['djo_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-description'], $shortcode->parse_typography($shortcode->atts['djo_desc_typo']));
	}
	if ( isset($shortcode->atts['djo_use_date']) && $shortcode->atts['djo_use_date'] && isset($shortcode->atts['djo_date_typo']) && !empty($shortcode->atts['djo_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-info'], $shortcode->parse_typography($shortcode->atts['djo_date_typo']));
	}
	if ( isset($shortcode->atts['djo_use_subtitle']) && $shortcode->atts['djo_use_subtitle'] && isset($shortcode->atts['djo_subtitle_typo']) && !empty($shortcode->atts['djo_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-subtitle'], $shortcode->parse_typography($shortcode->atts['djo_subtitle_typo']));
	}
	if ( isset($shortcode->atts['djo_use_arrow']) && $shortcode->atts['djo_use_arrow'] && isset($shortcode->atts['djo_arrow_typo']) && !empty($shortcode->atts['djo_arrow_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-button-prev:before,	%1$s .swiper-button-next:before'], $shortcode->parse_typography($shortcode->atts['djo_arrow_typo']));
	}

	return $css;
}

add_filter('aheto_features_tabs_dynamic_css', 'djo_features_tabs_layout1_dynamic_css', 10, 2);
