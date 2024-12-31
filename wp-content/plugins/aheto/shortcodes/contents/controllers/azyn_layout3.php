<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'azyn_contents_layout3' );


/**
 * Contents
 */

function azyn_contents_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';


	$shortcode->add_layout( 'azyn_layout3', [
		'title' => esc_html__( 'Split Slider (modern)', 'azyn' ),
		'image' => $preview_dir . 'azyn_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'azyn_modern_items', 'template', 'azyn_layout3' );

	$shortcode->add_dependecy( 'azyn_modern_desc', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_modern_desc_color', 'azyn_modern_slide_style', ['type_progress_counts'] );

	$shortcode->add_dependecy( 'azyn_number_1', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_procent_1', 'azyn_modern_slide_style', ['type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_symbol_1', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_title_1', 'azyn_modern_slide_style', ['type_progress_counts', 'type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_number_2', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_procent_2', 'azyn_modern_slide_style', ['type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_symbol_2', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_title_2', 'azyn_modern_slide_style', ['type_progress_counts', 'type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_procent_3', 'azyn_modern_slide_style', ['type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_title_3', 'azyn_modern_slide_style', [ 'type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_modern_number_color', 'azyn_modern_slide_style', ['type_progress_counts', 'type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_modern_count_title_color', 'azyn_modern_slide_style', ['type_progress_counts', 'type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_modern_symbol_color', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_modern_counts_border_color', 'azyn_modern_slide_style', ['type_progress_counts'] );
	$shortcode->add_dependecy( 'azyn_modern_counts_lines_color', 'azyn_modern_slide_style', ['type_progress_lines'] );
	$shortcode->add_dependecy( 'azyn_modern_counts_lines_active_color', 'azyn_modern_slide_style', ['type_progress_lines'] );

	$shortcode->add_dependecy( 'azyn_modern_f_image_1', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_title_1', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_desc_1', 'azyn_modern_slide_style', ['type_features'] );

	$shortcode->add_dependecy( 'azyn_modern_f_image_2', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_title_2', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_desc_2', 'azyn_modern_slide_style', ['type_features'] );

	$shortcode->add_dependecy( 'azyn_modern_f_image_3', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_title_3', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_desc_3', 'azyn_modern_slide_style', ['type_features'] );

	$shortcode->add_dependecy( 'azyn_modern_f_image_4', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_title_4', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_desc_4', 'azyn_modern_slide_style', ['type_features'] );

	$shortcode->add_dependecy( 'azyn_modern_f_title_color', 'azyn_modern_slide_style', ['type_features'] );
	$shortcode->add_dependecy( 'azyn_modern_f_desc_color', 'azyn_modern_slide_style', ['type_features'] );

	$shortcode->add_dependecy( 'azyn_modern_phone_icon', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_modern_phone', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_modern_email_icon', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_modern_email', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_modern_address_icon', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_modern_address', 'azyn_modern_slide_style', ['type_contacts'] );
	$shortcode->add_dependecy( 'azyn_contact_form', 'azyn_modern_slide_style', ['type_contacts'] );

	$shortcode->add_dependecy( 'azyn_use_modern_subtitle_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_subtitle_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_subtitle_typo', 'azyn_use_modern_subtitle_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_title_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_title_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_title_typo', 'azyn_use_modern_title_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_desc_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_desc_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_desc_typo', 'azyn_use_modern_desc_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_counts_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_typo', 'azyn_use_modern_counts_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_counts_h_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_h_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_h_typo', 'azyn_use_modern_counts_h_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_counts_l_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_l_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_l_typo', 'azyn_use_modern_counts_l_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_counts_l_h_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_l_h_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_counts_l_h_typo', 'azyn_use_modern_counts_l_h_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_symbol_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_symbol_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_symbol_typo', 'azyn_use_modern_symbol_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_contacts_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_contacts_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_contacts_typo', 'azyn_use_modern_contacts_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_pagination_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_pagination_typo', 'template', 'azyn_layout3' );
	$shortcode->add_dependecy( 'azyn_modern_pagination_typo', 'azyn_use_modern_pagination_typo', 'true' );

	$shortcode->add_params( [

		'azyn_modern_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'azyn' ),
			'params'  => [
				'azyn_modern_slide_style' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Slide style', 'azyn' ),
					'options' => [
						'type_progress_counts'            => esc_html__( 'With progress counts', 'azyn' ),
						'type_progress_lines' => esc_html__( 'With progress lines', 'azyn' ),
						'type_features' => esc_html__( 'With features', 'azyn' ),
						'type_contacts' => esc_html__( 'With contacts', 'azyn' ),
					],
					'default' => 'type_progress_counts',
				],
				'azyn_modern_subtitle'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Subtitle', 'azyn' ),
				],
				'azyn_modern_subtitle_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Subtitle color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .aheto-contents__subtitle' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'azyn' ),
					'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]].', 'aheto' ),
				],
				'azyn_modern_title_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Title color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .aheto-contents__title' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_title_highlight_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Title Highlight color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .aheto-contents__title span' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'azyn' ),
				],
				'azyn_modern_desc_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Description color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .aheto-contents__desc' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_images'         => [
					'type'    => 'attach_images',
					'heading' => esc_html__( 'Images', 'azyn' ),
				],
				'azyn_modern_images_pag'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Gallery bullets color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .swiper-pagination-bullet' => 'background: {{VALUE}}!important',
					],
				],
				'azyn_modern_images_pag_active'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Gallery active bullets color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}}!important',
					],
				],
				'azyn_number_1'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Number (first item)', 'aheto' ),
				],
				'azyn_procent_1'    => [
					'type'      => 'slider',
					'heading'   => esc_html__('Number (first item)', 'aheto'),
					'grid'      => 4,
					'size_units' => ['%'],
					'range'     => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
						],
					],
				],
				'azyn_symbol_1'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Symbol after Number (first item)', 'aheto' ),
				],
				'azyn_title_1'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading for Number (first item)', 'aheto' ),
					'label_block'       => true,
				],
				'azyn_number_2'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Number (second item)', 'aheto' ),
				],
				'azyn_procent_2'    => [
					'type'      => 'slider',
					'heading'   => esc_html__('Number (second item)', 'aheto'),
					'grid'      => 4,
					'size_units' => ['%'],
					'range'     => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
						],
					],
				],
				'azyn_symbol_2'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Symbol after Number (second item)', 'aheto' ),
				],
				'azyn_title_2'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading for Number (second item)', 'aheto' ),
					'label_block'       => true,
				],
				'azyn_procent_3'    => [
					'type'      => 'slider',
					'heading'   => esc_html__('Number (third item)', 'aheto'),
					'grid'      => 4,
					'size_units' => ['%'],
					'range'     => [
						'%' => [
							'min'  => 0,
							'max'  => 100,
						],
					],
				],
				'azyn_title_3'    => [
					'type'    => 'text',
					'heading' => esc_html__( 'Heading for Number (third item)', 'aheto' ),
					'label_block'       => true,
				],
				'azyn_modern_number_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Numbers color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__counters-number, {{WRAPPER}} {{CURRENT_ITEM}} .prog-bar-perc' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_symbol_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Symbols color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__counters-symbol' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_count_title_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Headings for Numbers color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__counters-title, {{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__progress-title' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_counts_border_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Counts Border color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__counters-wrap' => 'border-color: {{VALUE}}!important',
					],
				],
				'azyn_modern_counts_lines_active_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Progress line active color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__progress-wrap .prog-bar-val' => 'background: {{VALUE}}!important',
					],
				],
				'azyn_modern_counts_lines_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Progress line color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__progress-wrap .prog-bar' => 'background: {{VALUE}}!important',
					],
				],
				'azyn_modern_f_image_1'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (first feature)', 'azyn' ),
				],
				'azyn_modern_f_title_1'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (first feature)', 'azyn' ),
					'label_block'       => true,
				],
				'azyn_modern_f_desc_1'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description (first feature)', 'azyn' ),
				],
				'azyn_modern_f_image_2'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (second feature)', 'azyn' ),
				],
				'azyn_modern_f_title_2'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (second feature)', 'azyn' ),
					'label_block'       => true,
				],
				'azyn_modern_f_desc_2'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description (second feature)', 'azyn' ),
				],
				'azyn_modern_f_image_3'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (third feature)', 'azyn' ),
				],
				'azyn_modern_f_title_3'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (third feature)', 'azyn' ),
					'label_block'       => true,
				],
				'azyn_modern_f_desc_3'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description (third feature)', 'azyn' ),
				],
				'azyn_modern_f_image_4'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (fourth feature)', 'azyn' ),
				],
				'azyn_modern_f_title_4'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (fourth feature)', 'azyn' ),
					'label_block'       => true,
				],
				'azyn_modern_f_desc_4'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description (fourth feature)', 'azyn' ),
				],
				'azyn_modern_f_title_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Features Titles color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__features-title' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_f_desc_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Features Description color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__features-desc' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_modern_phone_icon'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Phone Icon', 'azyn' ),
				],
				'azyn_modern_phone'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Phone', 'azyn' ),
				],
				'azyn_modern_email_icon'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Email Icon', 'azyn' ),
				],
				'azyn_modern_email'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Email', 'azyn' ),
				],
				'azyn_modern_address_icon'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Address Icon', 'azyn' ),
				],
				'azyn_modern_address'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Address', 'azyn' ),
				],
				'azyn_contact_form'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Contact Form', 'aheto' ),
					'description' => esc_html__( 'Add your form id from shortcode Contact Form 7 Plugin.', 'aheto' ),
				],
				'azyn_modern_bg_color'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Background color', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2)' => 'background-color: {{VALUE}}',
					],
				],
				'azyn_modern_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background image', 'azyn' ),
				],
				'azyn_modern_bg_image_size' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Background image size', 'azyn' ),
					'options' => [
						'cover'            => esc_html__( 'Cover', 'azyn' ),
						'contain' => esc_html__( 'Contain', 'azyn' ),
						'auto' => esc_html__( 'Auto', 'azyn' ),
					],
					'default' => 'cover',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2)' => 'background-size: {{VALUE}}',
					],
				],
				'azyn_modern_bg_image_position' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Background image position', 'azyn' ),
					'options' => [
						'center center'            => esc_html__( 'Center Center', 'azyn' ),
						'center left' => esc_html__( 'Center Left', 'azyn' ),
						'center right' => esc_html__( 'Center Right', 'azyn' ),
						'top center' => esc_html__( 'Top Center', 'azyn' ),
						'top left' => esc_html__( 'Top Left', 'azyn' ),
						'top right' => esc_html__( 'Top Right', 'azyn' ),
						'bottom center' => esc_html__( 'Bottom Center', 'azyn' ),
						'bottom left' => esc_html__( 'Bottom Left', 'azyn' ),
						'bottom right' => esc_html__( 'Bottom Right', 'azyn' ),
					],
					'default' => 'center center',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2)' => 'background-position: {{VALUE}}',
					],
				],

			]
		],
		'azyn_use_modern_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide-wrap .aheto-contents__subtitle',
		],

		'azyn_use_modern_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide-wrap .aheto-contents__title',
		],

		'azyn_use_modern_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_desc_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide-wrap .aheto-contents__desc',
		],

		'azyn_use_modern_counts_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for counts?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_counts_typo' => [
			'type'     => 'typography',
			'group'    => 'Counts Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__counters-number',
		],

		'azyn_use_modern_symbol_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for counts symbols?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_symbol_typo' => [
			'type'     => 'typography',
			'group'    => 'Counts Symbols Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__counters-symbol',
		],

		'azyn_use_modern_counts_h_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for counts heading?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_counts_h_typo' => [
			'type'     => 'typography',
			'group'    => 'Counts Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__counters-title',
		],

		'azyn_use_modern_counts_l_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for lines counts?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_counts_l_typo' => [
			'type'     => 'typography',
			'group'    => 'Lines Counts Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .prog-bar-perc',
		],

		'azyn_use_modern_counts_l_h_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for lines counts heading?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_counts_l_h_typo' => [
			'type'     => 'typography',
			'group'    => 'Lines Counts Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__progress-title',
		],
		'azyn_use_modern_contacts_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for contacts?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_contacts_typo' => [
			'type'     => 'typography',
			'group'    => 'Contacts Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__contacts-text, {{WRAPPER}} .aheto-contents__contacts-link, {{WRAPPER}} form input:not([type="submit"]),{{WRAPPER}} form textarea',
		],
		'azyn_use_modern_pagination_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for slider pagination?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_pagination_typo' => [
			'type'     => 'typography',
			'group'    => 'Slider Pagination Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
		],
	] );

	\Aheto\Params::add_button_params($shortcode, array(
		'add_button' => false,
		'link'       => false,
		'prefix'     => 'azyn_form_',
		'layouts' => 'layout1',
		'dependency' => ['azyn_modern_slide_style', ['type_contacts']]
	), 'azyn_modern_items');

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'azyn_swiper_',
		'include'        => [ 'pagination', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'azyn_layout3' ] ]
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'azyn_',
		'dependency' => ['template', [ 'azyn_layout3'] ]
	]);
}
