<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-tabs_register', 'pointe_features_tabs_layout1' );

/**
 * Features Slider
 */
function pointe_features_tabs_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe contents classic', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );

	$shortcode->add_dependecy('pointe_tabs', 'template',  'pointe_layout1');

	$shortcode->add_dependecy('pointe_use_typo_filter', 'template',  'pointe_layout1');
	$shortcode->add_dependecy('pointe_typo_filter', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_typo_filter', 'pointe_use_typo_filter', 'true');

    $shortcode->add_dependecy('pointe_use_typo_dec', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_use_typo_dec', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_typo_dec', 'pointe_use_typo_dec', 'true');

    $shortcode->add_dependecy('pointe_use_typo_soc', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_typo_soc', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_typo_soc', 'pointe_use_typo_soc', 'true');


    $shortcode->add_params( [
        'pointe_tabs'        => [
            'type'    => 'group',
            'heading' => esc_html__('Features Tabs Pointe', 'pointe'),
            'params'  => [
                'main_heading'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Main Tab', 'pointe'),
                ],
                'title_adress'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title adress', 'pointe'),
                    'grid'    => 8,
                ],
                'pointe_address'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Adress', 'pointe'),
                    'grid'    => 8,
                ],
                'title_email'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title email', 'pointe'),
                    'grid'    => 8,
                ],
                'pointe_email'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Email', 'pointe'),
                    'grid'    => 8,
                ],
                'pointe_email_2'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Second Email', 'pointe'),
                    'grid'    => 8,
                ],
                'title_tel'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title telephone', 'pointe'),
                    'grid'    => 8,
                ],
                'pointe_tel'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Telephone', 'pointe'),
                    'grid'    => 8,
                ],
                'pointe_tel_2'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Second Telephone', 'pointe'),
                    'grid'    => 8,
                ],
                'font_icon'      => [
                    'type'    => 'select',
                    'heading' => esc_html__('Pointe Icon library', 'pointe'),
                    'options' => [
                        'ionicons' => esc_html__('Ionicons', 'pointe'),
                        'elegant'   => esc_html__('Elegant', 'pointe'),
                    ],
                    'default' => 'elegant',
                ],

                'title_tag' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Content Title tag', 'pointe'),
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
                    'default' => 'h1',
                    'grid'    => 2,
                ],

            ],
        ],
        'pointe_use_typo_filter'    => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for filter?', 'pointe'),
            'grid'    => 6,
        ],
        'pointe_typo_filter'   => [
            'type'     => 'typography',
            'group'    => 'Pointe Filter Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
        ],
        'pointe_use_typo_dec'    => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Description?', 'pointe'),
            'grid'    => 7,
        ],
        'pointe_typo_dec'   => [
            'type'     => 'typography',
            'group'    => 'Pointe Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-tabs__box-dec a, {{WRAPPER}} .aheto-features-tabs__box-dec p',
        ],
        'pointe_use_typo_soc'    => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Socials?', 'pointe'),
            'grid'    => 8,
        ],
        'pointe_typo_soc'   => [
            'type'     => 'typography',
            'group'    => 'Pointe Socials Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-tabs--social--link',
        ]
    ] );

    \Aheto\Params::add_networks_params($shortcode, [
        'prefix'     => 'pointe_tabs_',
    ], 'pointe_tabs');
}
function pointe_features_tabs_layout1_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_typo_dec']) && !empty($shortcode->atts['pointe_typo_dec'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-dec a, %1$s .aheto-features-tabs__box-dec p'], $shortcode->parse_typography($shortcode->atts['pointe_typo_dec']));
    }

    if (!empty($shortcode->atts['pointe_use_typo_filter']) && !empty($shortcode->atts['pointe_typo_filter'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-tabs__list-link'], $shortcode->parse_typography($shortcode->atts['pointe_typo_filter']));
    }

    if (!empty($shortcode->atts['pointe_use_typo_soc']) && !empty($shortcode->atts['pointe_typo_soc'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-tabs--social--link'], $shortcode->parse_typography($shortcode->atts['pointe_typo_soc']));
    }

    return $css;
}

add_filter( 'aheto_features_tabs_dynamic_css', 'pointe_features_tabs_layout1_dynamic_css', 10, 2 );
