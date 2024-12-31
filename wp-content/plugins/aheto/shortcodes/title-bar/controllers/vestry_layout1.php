<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'vestry_title_bar_layout1');

/**
 * Title Bar
 */

function vestry_title_bar_layout1($shortcode)
{
	$dir = '//assets.aheto.co/title-bar/previews/';
	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Title Bar 9', 'vestry'),
		'image' => $dir . 'vestry_layout1.jpg',
	]);
	$shortcode->add_dependecy('vestry_link_hover_color', 'template', 'vestry_layout1');

	$shortcode->add_dependecy('vestry_use_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'vestry_use_title_typo', 'true');

	$shortcode->add_dependecy('vestry_use_arrow_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_arrow_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_arrow_typo', 'vestry_use_arrow_typo', 'true');

	$shortcode->add_params([
		'vestry_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aht-breadcrumbs__item',
		],
		'vestry_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for arrow?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Vestry Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aht-breadcrumbs__item:before',
		],
        'vestry_link_hover_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Link hover color', 'vestry' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aht-breadcrumbs__item a:hover' => 'color: {{VALUE}}',
            ],
        ],
	]);
}


function vestry_title_bar_layout1_dynamic_css($css, $shortcode) {

    if ( isset( $shortcode->atts['vestry_use_title_typo'] ) && !empty( $shortcode->atts['vestry_use_title_typo'] ) && isset( $shortcode->atts['vestry_title_typo'] ) && !empty( $shortcode->atts['vestry_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aht-breadcrumbs__item'], $shortcode->parse_typography( $shortcode->atts['vestry_title_typo'] ) );
    }
    if ( isset( $shortcode->atts['vestry_use_arrow_typo'] ) && !empty( $shortcode->atts['vestry_use_arrow_typo'] ) && isset( $shortcode->atts['vestry_arrow_typo'] ) && !empty( $shortcode->atts['vestry_arrow_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aht-breadcrumbs__item:before'], $shortcode->parse_typography( $shortcode->atts['vestry_arrow_typo'] ) );
    }

    if ( isset( $shortcode->atts['vestry_link_hover_color'] ) && !empty( $shortcode->atts['vestry_link_hover_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['vestry_link_hover_color'] );
        $css['global']['%1$s .aheto-features__links a.aheto-link:hover']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_title_bar_dynamic_css', 'vestry_title_bar_layout1_dynamic_css', 10, 2);