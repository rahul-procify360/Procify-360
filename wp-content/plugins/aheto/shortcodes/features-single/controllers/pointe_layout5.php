<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'pointe_features_single_layout5' );

/**
 * Features Single
 */

function pointe_features_single_layout5( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'pointe_layout5', [
		'title' => esc_html__( 'Pointe Image vertical', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout5.jpg',
	] );
    
    $shortcode->add_dependecy('pointe_use_main_title_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_main_title_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_main_title_typo', 'pointe_use_main_title_typo', 'true');

    $shortcode->add_dependecy('pointe_use_dec_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_dec_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_dec_typo', 'pointe_use_dec_typo', 'true');

    $shortcode->add_dependecy('pointe_features_single', 'template', 'pointe_layout5');

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
        'pointe_use_dec_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Description?', 'pointe'),
            'default' => '',
        ],
        'pointe_dec_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__dec',
        ],
		'pointe_features_single'        => [
            'type'    => 'group',
            'heading' => esc_html__('Features Single Pointe', 'pointe'),
            'params'  => [
                'pointe_add_image'               => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Add Image', 'pointe'),
                ],
                'pointe_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__('Pointe title', 'pointe'),
                ],
                'pointe_dec'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__('Description', 'pointe'),
                ],
                'pointe_link' => [
                    'type'        => 'link',
                    'heading'     => esc_html__('Link', 'pointe'),
                    'description' => esc_html__('Add url to img.', 'pointe'),
                    'default'     => [
                        'url' => '#',
                    ],
                ],
            ],
        ]
	] );
}
function pointe_features_single_layout5_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['pointe_use_main_title_typo']) && !empty($shortcode->atts['pointe_main_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-content-block__main-title'], $shortcode->parse_typography($shortcode->atts['pointe_main_title_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_dec_typo']) && !empty($shortcode->atts['pointe_dec_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-content-block__main-title'], $shortcode->parse_typography($shortcode->atts['pointe_dec_typo']));
    }
    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'pointe_features_single_layout5_dynamic_css', 10, 2);