<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_political_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function karma_political_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];

	$aheto_addon_skins = array(
		'karma_political_skin-1' => 'Karma Political Skin 1',
		'karma_political_skin-2' => 'Karma Political Skin 2',
		'karma_political_skin-3' => 'Karma Political Skin 3'
	);

	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );

	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy( 'karma_political_use_date_typo', 'template', [ 'karma_political_layout1' ] );
	$shortcode->add_dependecy( 'karma_political_date_typo', 'template', [ 'karma_political_layout1' ] );
    $shortcode->add_dependecy( 'karma_political_date_typo', 'karma_political_use_date_typo', 'true' );

	$shortcode->add_dependecy( 'karma_political_use_terms_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_terms_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_terms_typo', 'karma_political_use_terms_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_date_day_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_date_day_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_date_day_typo', 'karma_political_use_date_day_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_date_mon_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_date_mon_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_date_mon_typo', 'karma_political_use_date_mon_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_title_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_title_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_title_typo', 'karma_political_use_title_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_desc_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_desc_typo', 'template', [ 'karma_political_layout2' ] );
    $shortcode->add_dependecy( 'karma_political_desc_typo', 'karma_political_use_desc_typo', 'true' );
    
    $shortcode->add_dependecy( 'karma_political_use_title_product_typo', 'skin', [ 'karma_political_skin-3' ] );
    $shortcode->add_dependecy( 'karma_political_title_product_typo', 'skin', [ 'karma_political_skin-3' ] );
    $shortcode->add_dependecy( 'karma_political_title_product_typo', 'karma_political_use_title_product_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_regular_price', 'skin', [ 'karma_political_skin-3' ] );
    $shortcode->add_dependecy( 'karma_political_regular_price', 'skin', [ 'karma_political_skin-3' ] );
    $shortcode->add_dependecy( 'karma_political_regular_price', 'karma_political_use_regular_price', 'true' );

	$shortcode->add_params( [

		'karma_political_use_date_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for date?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_date_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Date Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
        ],

		'karma_political_use_terms_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for terms?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_terms_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Terms Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__terms > a',
        ],

        'karma_political_use_date_day_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for date day?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_date_day_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Date Day Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__event-day-content',
        ],

        'karma_political_use_date_mon_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for date month?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_date_mon_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Date Month Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__event-month-content',
        ],

        'karma_political_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for title?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_title_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__title > a',
        ],

        'karma_political_use_desc_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_desc_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt > p',
        ],
        
        'karma_political_use_title_product_typo'       => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Title Product?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_title_product_typo'           => [
            'type'     => 'typography',
            'group'    => 'Karma Title Product Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__title',
        ],

        'karma_political_use_regular_price' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Price?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_regular_price'     => [
            'type'     => 'typography',
            'group'    => 'Karma Price Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__price .price',
        ]

	] );

}

function karma_political_custom_post_types_skins_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['karma_political_use_date_typo'] ) && ! empty( $shortcode->atts['karma_political_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography( $shortcode->atts['karma_political_date_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['karma_political_use_terms_typo'] ) && ! empty( $shortcode->atts['karma_political_terms_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__terms > a'], $shortcode->parse_typography( $shortcode->atts['karma_political_terms_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['karma_political_use_date_day_typo'] ) && ! empty( $shortcode->atts['karma_political_date_day_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__event-day-content'], $shortcode->parse_typography( $shortcode->atts['karma_political_date_day_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['karma_political_use_date_mon_typo'] ) && ! empty( $shortcode->atts['karma_political_date_mon_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__event-month-content'], $shortcode->parse_typography( $shortcode->atts['karma_political_date_mon_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['karma_political_use_title_typo'] ) && ! empty( $shortcode->atts['karma_political_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__title > a'], $shortcode->parse_typography( $shortcode->atts['karma_political_title_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['karma_political_use_desc_typo'] ) && ! empty( $shortcode->atts['karma_political_desc_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__excerpt > p'], $shortcode->parse_typography( $shortcode->atts['karma_political_desc_typo'] ) );
    }

    if ( !empty($shortcode->atts['karma_political_use_title_product_typo']) && !empty($shortcode->atts['karma_political_title_product_typo']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__title'], $shortcode->parse_typography($shortcode->atts['karma_political_title_product_typo']));
    }

    if ( !empty($shortcode->atts['karma_political_use_regular_price']) && !empty($shortcode->atts['karma_political_regular_price']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__price .price'], $shortcode->parse_typography($shortcode->atts['karma_political_regular_price']));
    }

	return $css;

}

add_filter( 'aheto_cpt_dynamic_css', 'karma_political_custom_post_types_skins_dynamic_css', 10, 2 );