<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-tabs_register', 'acacio_aheto_features_tabs_layout1' );

/**
 * Features Slider
 */

function acacio_aheto_features_tabs_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Features Tabs 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['use_description', 't_description'], [ 'acacio_layout1'], $shortcode );

    $shortcode->add_dependecy( 'acacio_tabs', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_use_tab_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_tab_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_tab_typo', 'acacio_use_tab_typo', 'true' );


    $shortcode->add_params( [
        'acacio_tabs' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Tabs Items', 'acacio' ),
            'params'  => [
                'acacio_tabs_title'       => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Tab title', 'acacio' ),
                ],
                'acacio_tabs_content'        => [
                    'type'    => 'editor',
                    'heading' => esc_html__( 'Tab content', 'acacio' ),
                    'default' => esc_html__( 'Put your text...', 'acacio' ),
                ],
            ],
        ],
	    'acacio_use_tab_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for tab link?', 'acacio' ),
		    'grid'    => 3,
	    ],
	    'acacio_tab_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Tab Link Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
	    ],
    ] );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'acacio_main_',
    ], 'acacio_tabs');

    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'acacio'),
        'prefix'    => 'acacio_add_',
    ], 'acacio_tabs');
}
function acacio_aheto_features_tabs_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['acacio_use_tab_typo'] ) && ! empty( $shortcode->atts['acacio_tab_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-tabs__list-link'], $shortcode->parse_typography( $shortcode->atts['acacio_tab_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_features_tabs_dynamic_css', 'acacio_aheto_features_tabs_layout1_dynamic_css', 10, 2 );