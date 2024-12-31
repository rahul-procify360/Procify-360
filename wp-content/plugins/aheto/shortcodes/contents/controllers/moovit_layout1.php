<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'moovit_contents_layout1' );


/**
 * Contents
 */

function moovit_contents_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Content 19', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );
	$shortcode->add_dependecy( 'moovit_video_image', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_video_image', 'moovit_add_video_button', 'true' );
	$shortcode->add_dependecy( 'moovit_title', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_tag', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_text', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_background', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_text_color', 'template', 'moovit_layout1' );

    $shortcode->add_dependecy( 'moovit_use_text_typo', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_text_typo', 'template', 'moovit_layout1' );
    $shortcode->add_dependecy( 'moovit_text_typo', 'moovit_use_text_typo', 'true' );


	\Aheto\Params::add_video_button_params( $shortcode, [
		'add_label'  => esc_html__( 'Add video?', 'moovit' ),
		'prefix'     => 'moovit_',
		'group'      => esc_html__( 'Video Content', 'moovit' ),
		'dependency' => [ 'template', 'moovit_layout1' ],
	] );


	$shortcode->add_params( [
		'moovit_video_image'      => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Preview image for video', 'moovit' ),
			'group'   => esc_html__( 'Video Content', 'moovit' ),
		],
		'moovit_title'            => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Title', 'moovit' ),
			'description' => esc_html__( 'Add some text for Title', 'moovit' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for Title', 'moovit' ),
		],
		'moovit_title_tag'        => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for title', 'moovit' ),
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
			'grid'    => 5,
		],
		'moovit_text'             => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Text', 'moovit' ),
			'description' => esc_html__( 'Add some text', 'moovit' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text', 'moovit' ),
		],
		'moovit_background'       => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background for content', 'moovit' ),
			'grid'      => 6,
			'default'   => '#131c21',
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__wrapper' => 'background-color: {{VALUE}}',
			],
		],
		'moovit_text_color'       => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Color for content', 'moovit' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__inner_wrapper > *' => 'color: {{VALUE}}',
			],
		],
        'moovit_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for text?', 'outsourceo' ),
            'grid'    => 6,
        ],
        'moovit_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Moovit Text Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__text, {{WRAPPER}} .aheto-contents__text *',
        ],
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'moovit_link_',
		'icons'      => true,
		'dependency' => [ 'template', 'moovit_layout1' ],
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout1'] ]
	]);


}

function moovit_contents_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color                                                              = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s .aheto-contents__wrapper']['background-color'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_text_color'] ) ) {
		$color                                                             = Sanitize::color( $shortcode->atts['moovit_text_color'] );
		$css['global']['%1$s .aheto-contents__inner_wrapper > *']['color'] = $color;
	}

    if ( ! empty( $shortcode->atts['moovit_use_text_typo'] ) && ! empty( $shortcode->atts['moovit_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__text'], $shortcode->parse_typography( $shortcode->atts['moovit_text_typo'] ) );
    }

	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'moovit_contents_layout1_dynamic_css', 10, 2 );

