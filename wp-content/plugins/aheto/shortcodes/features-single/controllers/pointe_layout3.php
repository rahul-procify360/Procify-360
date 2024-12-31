<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'pointe_features_single_layout3' );

/**
 * Features Single
 */

function pointe_features_single_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'pointe_layout3', [
		'title' => esc_html__( 'Pointe Image', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout3.jpg',
	] );

	aheto_demos_add_dependency('s_heading', ['pointe_layout3'], $shortcode);
    
    $shortcode->add_dependecy('pointe_use_main_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_main_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_main_title_typo', 'pointe_use_main_title_typo', 'true');
    
	$shortcode->add_dependecy('pointe_link_url', 'template', ['pointe_layout3']);

	$shortcode->add_params( [

		'pointe_use_main_title_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Main title?', 'pointe'),
            'default' => '',
        ],
        'pointe_main_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Main Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-content-block__main-title, {{WRAPPER}} .aheto-features-block__title',
		],
		'pointe_link_url' => [
            'type'        => 'link',
            'heading'     => esc_html__('Link', 'pointe'),
            'description' => esc_html__('Add url to img.', 'pointe'),
            'default'     => [
                'url' => '#',
            ],
		]
		
	] );
}
function pointe_features_single_layout3_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['pointe_use_main_title_typo']) && !empty($shortcode->atts['pointe_main_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-content-block__main-title'], $shortcode->parse_typography($shortcode->atts['pointe_main_title_typo']));
    }
    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'pointe_features_single_layout3_dynamic_css', 10, 2);