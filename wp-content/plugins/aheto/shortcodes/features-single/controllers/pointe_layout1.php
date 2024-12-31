<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'pointe_features_single_layout1' );

/**
 * Features Single
 */

function pointe_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe Modern', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );

	aheto_demos_add_dependency(['s_heading', 'use_heading', 't_heading', 's_image', 's_description'], ['pointe_layout1'], $shortcode);

    $shortcode->add_dependecy('pointe_use_main_title_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_main_title_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_main_title_typo', 'pointe_use_main_title_typo', 'true');

    $shortcode->add_dependecy('pointe_use_desc_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_desc_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_desc_typo', 'pointe_use_desc_typo', 'true');

    $shortcode->add_dependecy('pointe_logo_title', 'template', 'pointe_layout1');

	$shortcode->add_params( [

		'pointe_logo_title'          => [
            'type'    => 'text',
            'heading' => esc_html__('Logo title', 'pointe'),
		],
		'pointe_use_main_title_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Main title?', 'pointe'),
            'default' => '',
        ],
        'pointe_main_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Main Title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-content-block__main-title, {{WRAPPER}} .aheto-features-block__title',
        ],
		'pointe_use_desc_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'pointe'),
            'default' => '',
        ],
        'pointe_desc_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
        ],

	] );
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'pointe_',
		'dependency' => ['template', ['pointe_layout1']]
	]);
}

function pointe_features_single_layout1_dynamic_css($css, $shortcode)
{

if (!empty($shortcode->atts['pointe_use_main_title_typo']) && !empty($shortcode->atts['pointe_main_title_typo'])) {
	\aheto_add_props($css['global']['%1$s .aheto-content-block__main-title'], $shortcode->parse_typography($shortcode->atts['pointe_main_title_typo']));
}
if (!empty($shortcode->atts['pointe_use_desc_typo']) && !empty($shortcode->atts['pointe_desc_typo'])) {
	\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text'], $shortcode->parse_typography($shortcode->atts['pointe_desc_typo']));
}
return $css;
}

add_filter('aheto_features_single_dynamic_css', 'pointe_features_single_layout1_dynamic_css', 10, 2);