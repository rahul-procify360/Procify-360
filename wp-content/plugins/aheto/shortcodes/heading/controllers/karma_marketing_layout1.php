<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_heading_register', 'karma_marketing_heading_layout1' );

/**
 * Heading
 */

function karma_marketing_heading_layout1 ( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout1', [
		'title' => esc_html__ ( 'Heading 11', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	] );

	aheto_demos_add_dependency ( [ 'text_tag', 'alignment', 'align_tablet', 'align_mobile' ], [ 'karma_marketing_layout1' ], $shortcode );

    $shortcode -> add_dependecy ( 'karma_marketing_line_color', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_description', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_smaller_line', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_title', 'template', 'karma_marketing_layout1' );

	$shortcode -> add_dependecy ( 'karma_marketing_use_description_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_description_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_description_typo', 'karma_marketing_use_description_typo', 'true' );

	$shortcode -> add_dependecy ( 'karma_marketing_use_title_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_title_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_title_typo', 'karma_marketing_use_title_typo', 'true' );


	$shortcode -> add_params ( [

		'karma_marketing_title'     => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Title', 'karma' ),
			'description' => esc_html__( 'Add some text for Title', 'karma' ),
			'admin_label' => true,
			'default' => esc_html__ ( 'Add some text for Title', 'karma' ),

		],
        'karma_marketing_smaller_line' => [
            'type' => 'switch',
            'heading' => esc_html__ ( 'Make line after title smaller?', 'karma' ),
            'grid' => 3,
        ],

		'karma_marketing_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__ ( 'Use custom font for Title?', 'karma' ),
            'grid' => 3,
        ],
        'karma_marketing_title_typo' => [
            'type' => 'typography',
            'group' => 'Title Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__title',
        ],

		'karma_marketing_description' => [
			'type' => 'textarea',
			'heading' => esc_html__ ( 'Description', 'karma' ),
			'description' => esc_html__ ( 'Add some text for Description', 'karma' ),
			'admin_label' => true,
			'default' => esc_html__ ( 'Add some text for Description', 'karma' ),
		],

		'karma_marketing_use_description_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Description?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_description_typo' => [
			'type' => 'typography',
			'group' => 'Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__description',
		],

		'karma_marketing_line_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Color on background', 'karma'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-heading__title::after' => 'background-color: {{VALUE}}'],
		],

	] );

}

function karma_marketing_heading_layout1_dynamic_css ( $css, $shortcode ) {

	if ( !empty( $shortcode -> atts['karma_marketing_use_description_typo'] ) && !empty( $shortcode -> atts['karma_marketing_description_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-heading__description'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_description_typo'] ) );
	}

	if ( !empty( $shortcode -> atts['karma_marketing_use_title_typo'] ) && !empty( $shortcode -> atts['karma_marketing_title_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-heading__title'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_title_typo'] ) );
	}

	if (!empty($shortcode->atts['karma_marketing_line_color'])) {
		$color = Sanitize::color($shortcode->atts['karma_marketing_line_color']);
		$css['global']['%1$s .aheto-heading__title::after']['background-color'] = $color;
	}

	return $css;

}

add_filter ( 'aheto_heading_dynamic_css', 'karma_marketing_heading_layout1_dynamic_css', 10, 2 );
