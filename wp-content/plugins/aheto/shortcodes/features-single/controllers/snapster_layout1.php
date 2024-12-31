<?php

add_action( 'aheto_before_aheto_features-single_register', 'snapster_features_single_layout1_shortcode' );

/**
 * Features Single Shortcode
 */
function snapster_features_single_layout1_shortcode( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'snapster_layout1', [
        'title' => esc_html__( 'Snapster Modern', 'snapster' ),
        'image' => $preview_dir . 'snapster_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'snapster_heading', 'template', ['snapster_layout1'] );
    $shortcode->add_dependecy( 'snapster_overlay_color', 'template', ['snapster_layout1'] );
	$shortcode->add_dependecy( 'snapster_link_url', 'template', ['snapster_layout1'] );

	aheto_demos_add_dependency( ['use_heading', 't_heading', 's_image'], ['snapster_layout1'], $shortcode );

    $shortcode->add_params([
        'snapster_heading' => [
            'type' => 'text',
            'heading' => esc_html__('Heading', 'snapster'),
            'grid' => 9,
            'admin_label' => true,
            'default' => esc_html__('Default heading', 'snapster'),
        ],
        'snapster_link_url'          => [
	        'type'    => 'link',
	        'heading' => esc_html__('Link URL', 'soapy'),
	        'grid'    => 3,
        ],
        'snapster_overlay_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Overlay color', 'snapster' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-features-block__wrap-overlay' => 'background-color: {{VALUE}}' ],
            'default'   => 'rgba(209, 134, 43, 0.8)',
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Snapster Images size', 'snapster' ),
        'prefix'     => 'snapster_',
        'dependency' => ['template', ['snapster_layout1']]
    ]);
}

function snapster_features_single_layout1_shortcode_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['snapster_overlay_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['snapster_overlay_color'] );
        $css['global']['%1$s .aheto-features-block__wrap-overlay']['background-color'] = $color;
    }

    return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'snapster_features_single_layout1_shortcode_dynamic_css', 10, 2 );
