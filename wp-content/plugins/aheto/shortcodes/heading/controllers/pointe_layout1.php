<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_heading_register', 'pointe_heading_layout1' );


/**
 * Heading
 */
function pointe_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe Awords', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );

	$shortcode->add_dependecy('pointe_heading', 'template', 'pointe_layout1');

    $shortcode->add_dependecy('pointe_use_heading_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_heading_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_heading_typo', 'pointe_use_heading_typo', 'true');

	$shortcode->add_params( [
		'pointe_heading'         => [
            'type'    => 'text',
            'heading' => esc_html__('Heading', 'pointe'),
            'default' => esc_html__('Defoult title', 'pointe'),
        ],
        'pointe_use_heading_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Heading?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_heading_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Heading Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__title',
        ]
	] );

}

function pointe_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['pointe_use_heading_typo']) && !empty($shortcode->atts['pointe_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['pointe_heading_typo']));
	}

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'pointe_heading_layout1_dynamic_css', 10, 2 );

