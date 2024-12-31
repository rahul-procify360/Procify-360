<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout3');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'Features Single 21', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout3.jpg',
	] );
	aheto_demos_add_dependency(['s_image','s_heading', 'use_heading', 's_description','use_description', 't_heading', 't_description'], ['hryzantema_layout3'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_use_img_height', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_img_height', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_img_height', 'hryzantema_use_img_height', 'true' );
	$shortcode->add_dependecy( 'hryzantema_active', 'template', ['hryzantema_layout3'] );
	$shortcode->add_dependecy( 'hryzantema_link_hover_color', 'template', ['hryzantema_layout3'] );

	$shortcode->add_params([
		'hryzantema_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Mark as active?', 'hryzantema' ),
			'grid'    => 12,
		],
		'hryzantema_use_img_height' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Set image height?', 'hryzantema' ),
			'grid'    => 3,
		],
		'hryzantema_img_height'    => [
			'type'      => 'slider',
			'heading'   => esc_html__('Image height', 'hryzantema'),
			'grid'      => 4,
			'size_units' => [ 'px', '%', 'vh' ],
			'range'     => [
				'px' => [
					'min'  => 200,
					'max'  => 2000,
					'step' => 5,
				],
				'%' => [
					'min'  => 0,
					'max'  => 100,
				],
				'vh' => [
					'min'  => 0,
					'max'  => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-features-block__image img ' => 'height: {{SIZE}}{{UNIT}};',
			],
		],
        'hryzantema_link_hover_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Link hover color', 'hryzantema' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-features__links a.aheto-link:hover' => 'color: {{VALUE}}',
            ],
        ],
	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons' => true,
		'dependency' => ['template', [ 'hryzantema_layout3'] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout3'] ]
	]);
}


function hryzantema_features_single_layout3_dynamic_css($css, $shortcode) {

	if (!empty($shortcode->atts['hryzantema_img_height'])) {
		$size = Sanitize::size($shortcode->atts['hryzantema_img_height']);
		$css['global']['%1$s .aheto-features-block__image img ']['height'] = $size;
	}

    if ( isset( $shortcode->atts['hryzantema_link_hover_color'] ) && !empty( $shortcode->atts['hryzantema_link_hover_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['hryzantema_link_hover_color'] );
        $css['global']['%1$s .aheto-features__links a.aheto-link:hover']['color'] = $color;
    }

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'hryzantema_features_single_layout3_dynamic_css', 10, 2);