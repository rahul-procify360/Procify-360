<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'azyn_contents_layout2' );


/**
 * Contents
 */

function azyn_contents_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';


	$shortcode->add_layout( 'azyn_layout2', [
		'title' => esc_html__( 'Split Slider', 'azyn' ),
		'image' => $preview_dir . 'azyn_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'azyn_split_items', 'template', 'azyn_layout2' );

	$shortcode->add_dependecy( 'azyn_split_number', 'azyn_split_slide_style', ['simple', 'simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_number_color', 'azyn_split_slide_style', ['simple', 'simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc', 'azyn_split_slide_style', ['simple', 'simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc_color', 'azyn_split_slide_style', ['simple', 'simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc_align', 'azyn_split_slide_style', ['simple', 'simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_image', 'azyn_split_slide_style', ['simple', 'simple_2col', 'simple_2col_modern'] );

	$shortcode->add_dependecy( 'azyn_split_number_color_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc_color_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc_align_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_title_color_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_title_align_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_subtitle_color_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_subtitle_align_2', 'azyn_split_slide_style', ['simple_2col'] );

	$shortcode->add_dependecy( 'azyn_split_number_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_subtitle_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_title_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_desc_2', 'azyn_split_slide_style', ['simple_2col'] );
	$shortcode->add_dependecy( 'azyn_split_image_2', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );
	$shortcode->add_dependecy( 'azyn_bg_color_2', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );
	$shortcode->add_dependecy( 'azyn_bg_color_2_mob', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );
	$shortcode->add_dependecy( 'azyn_bg_image_2', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );
	$shortcode->add_dependecy( 'azyn_bg_image_2_mob', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );

	$shortcode->add_dependecy( 'azyn_bg_image_size_2', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );
	$shortcode->add_dependecy( 'azyn_bg_image_position_2', 'azyn_split_slide_style', ['simple_2col', 'simple_2col_modern'] );

	$shortcode->add_dependecy( 'azyn_split_f_image_1', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_1', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_2', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_2', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_3', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_3', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_4', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_4', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_5', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_5', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_6', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_6', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_7', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_7', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_image_8', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_split_f_title_8', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_icons_border_color', 'azyn_split_slide_style', ['features'] );
	$shortcode->add_dependecy( 'azyn_features_titles_color', 'azyn_split_slide_style', ['features'] );

	$shortcode->add_dependecy( 'azyn_split_pagination_color', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_use_num_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_num_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_num_typo', 'azyn_use_num_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_split_subtitle_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_subtitle_split_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_subtitle_split_typo', 'azyn_use_split_subtitle_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_split_title_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_title_split_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_title_split_typo', 'azyn_use_split_title_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_split_desc_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_desc_split_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_desc_split_typo', 'azyn_use_split_desc_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_subtitle_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_modern_subtitle_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_modern_subtitle_typo', 'azyn_use_modern_subtitle_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_modern_title_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_modern_title_typo', 'template', 'azyn_layout2');
	$shortcode->add_dependecy( 'azyn_modern_title_typo', 'azyn_use_modern_title_typo', 'true' );


	$shortcode->add_params( [
		'azyn_split_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'azyn' ),
			'params'  => [
				'azyn_split_slide_style' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Slide style', 'azyn' ),
					'options' => [
						'simple'            => esc_html__( 'With image', 'azyn' ),
						'simple_2col' => esc_html__( 'With image in 2 column', 'azyn' ),
						'simple_2col_modern' => esc_html__( 'With image in 2 column (modern)', 'azyn' ),
						'features' => esc_html__( 'With features', 'azyn' ),
					],
					'default' => 'simple',
				],
				'azyn_split_number'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Number', 'azyn' ),
				],
				'azyn_split_number_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Number color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__number' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_subtitle'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Subtitle', 'azyn' ),
				],
				'azyn_split_subtitle_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Subtitle color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__subtitle' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_subtitle_align' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Subtitle align', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__subtitle' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'azyn' ),
				],
				'azyn_split_title_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Title color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__title' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_title_align' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Title align', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__title' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'azyn' ),
				],
				'azyn_split_desc_color'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Description color', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__desc' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_desc_align' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Description align', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type .aheto-contents__desc' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'azyn' ),
				],
				'azyn_split_f_image_1'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (first feature)', 'azyn' ),
				],
				'azyn_split_f_title_1'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (first feature)', 'azyn' ),
				],
				'azyn_split_f_image_2'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (second feature)', 'azyn' ),
				],
				'azyn_split_f_title_2'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (second feature)', 'azyn' ),
				],
				'azyn_split_f_image_3'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (third feature)', 'azyn' ),
				],
				'azyn_split_f_title_3'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (third feature)', 'azyn' ),
				],
				'azyn_split_f_image_4'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (fourth feature)', 'azyn' ),
				],
				'azyn_split_f_title_4'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (fourth feature)', 'azyn' ),
				],
				'azyn_split_f_image_5'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (fifth feature)', 'azyn' ),
				],
				'azyn_split_f_title_5'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (fifth feature)', 'azyn' ),
				],
				'azyn_split_f_image_6'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (sixth feature)', 'azyn' ),
				],
				'azyn_split_f_title_6'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (sixth feature)', 'azyn' ),
				],
				'azyn_split_f_image_7'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (seventh feature)', 'azyn' ),
				],
				'azyn_split_f_title_7'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (seventh feature)', 'azyn' ),
				],
				'azyn_split_f_image_8'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Icon (eighth feature)', 'azyn' ),
				],
				'azyn_split_f_title_8'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (eighth feature)', 'azyn' ),
				],
				'azyn_icons_border_color'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Icons border color', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__features .aheto-contents__icon' => 'border-color: {{VALUE}}',
					],
				],
				'azyn_features_titles_color'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Feature titles color', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__features .aheto-contents__item-title' => 'color: {{VALUE}}',
					],
				],
				'azyn_bg_color'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Background color', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type' => 'background-color: {{VALUE}}',
					],
				],
				'azyn_bg_color_mob'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Background color on mobile', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'@media only screen and (max-width:992px){ {{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type' => 'background-color: {{VALUE}} }',
					],
				],
				'azyn_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background image', 'azyn' ),
				],
				'azyn_bg_image_mob'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background image on mobile', 'azyn' ),
				],
				'azyn_bg_image_size' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Background image size', 'azyn' ),
					'options' => [
						'cover'            => esc_html__( 'Cover', 'azyn' ),
						'contain' => esc_html__( 'Contain', 'azyn' ),
						'auto' => esc_html__( 'Auto', 'azyn' ),
					],
					'default' => 'cover',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type' => 'background-size: {{VALUE}}',
					],
				],
				'azyn_bg_image_position' => [
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
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:first-of-type' => 'background-position: {{VALUE}}',
					],
				],
				'azyn_split_number_2'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Number (second column)', 'azyn' ),
				],
				'azyn_split_number_color_2'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Number color (2 column)', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__number' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_subtitle_2'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Subtitle (second column)', 'azyn' ),
				],
				'azyn_split_subtitle_color_2'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Subtitle color (2 column)', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__subtitle' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_subtitle_align_2' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Subtitle align (2 column)', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__subtitle' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_title_2'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title (second column)', 'azyn' ),
				],
				'azyn_split_title_color_2'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Title color (2 column)', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__title' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_title_align_2' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Title align (2 column)', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__title' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_desc_2'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description (second column)', 'azyn' ),
				],
				'azyn_split_desc_color_2'       => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Description color (2 column)', 'azyn' ),
					'grid'      => 6,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__desc' => 'color: {{VALUE}}!important',
					],
				],
				'azyn_split_desc_align_2' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Description align (2 column)', 'azyn' ),
					'options' => [
						'left'            => esc_html__( 'Left', 'azyn' ),
						'right' => esc_html__( 'Right', 'azyn' ),
						'center' => esc_html__( 'Center', 'azyn' ),
					],
					'default' => 'left',
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2) .aheto-contents__desc' => 'text-align: {{VALUE}}!important',
					],
				],
				'azyn_split_image_2'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image (second column)', 'azyn' ),
				],
				'azyn_bg_color_2'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Background color (second column)', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2)' => 'background-color: {{VALUE}}',
					],
				],
				'azyn_bg_color_2_mob'   => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Background color on mobile (second column)', 'azyn' ),
					'grid'      => 6,
					'selectors' => [
						'@media only screen and (max-width:992px){ {{WRAPPER}} {{CURRENT_ITEM}} .aheto-contents__slide-wrap:nth-of-type(2)' => 'background-color: {{VALUE}} }',
					],
				],
				'azyn_bg_image_2'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background image (second column)', 'azyn' ),
				],
				'azyn_bg_image_2_mob'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background image on mobile (second column)', 'azyn' ),
				],
				'azyn_bg_image_size_2' => [
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
				'azyn_bg_image_position_2' => [
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

		'azyn_split_pagination_color'       => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Pagination color', 'azyn' ),
			'grid'      => 6,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .swiper-pagination-bullet, {{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}!important',
			],
		],

		'azyn_use_num_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for number?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_num_typo' => [
			'type'     => 'typography',
			'group'    => 'Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__number',
		],

		'azyn_use_split_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_subtitle_split_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide:not(.simple_2col_modern) .aheto-contents__subtitle',
		],

		'azyn_use_split_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_title_split_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide:not(.simple_2col_modern) .aheto-contents__title',
		],

		'azyn_use_split_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_desc_split_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__desc',
		],

		'azyn_use_modern_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle (modern slide)?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography (modern slide)',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide.simple_2col_modern .aheto-contents__subtitle',
		],

		'azyn_use_modern_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title  (modern slide)?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_modern_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography  (modern slide)',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide.simple_2col_modern .aheto-contents__title',
		],
	] );


	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'azyn_main_',
		'icons'  => true,
	], 'azyn_split_items' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add button for second column?', 'azyn' ),
		'prefix'    => 'azyn_add_',
		'icons'     => true,
		'dependency' => [ 'azyn_split_slide_style', [ 'simple_2col' ] ],
	], 'azyn_split_items' );


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'azyn_swiper_',
		'include'        => [ 'pagination', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'azyn_layout2' ] ]
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'azyn_',
		'dependency' => ['template', [ 'azyn_layout2'] ]
	]);
}


