<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'noize_custom_post_types_skins' );

/**
 * Custom post type Shortcode
 */

function noize_custom_post_types_skins( $shortcode ) {

    $aheto_skins  = $shortcode->params['skin']['options'];

    $noize_skins = array(
        'noize_skin-1' => 'Noize skin 1'
    );

    $all_skins = array_merge( $aheto_skins, $noize_skins );

    $shortcode->params['skin']['options'] = $all_skins;

    $shortcode->add_dependecy( 'noize_use_typo_article', 'skin', 'noize_skin-1' );
    $shortcode->add_dependecy( 'noize_text_typo_article', 'skin', 'noize_skin-1' );
    $shortcode->add_dependecy( 'noize_text_typo_article', 'noize_use_typo_article', 'true' );

    $shortcode->add_params([
        'noize_use_typo_article'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for article?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_article'   => [
            'type'     => 'typography',
            'group'    => 'Noize Article Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__subtitle',
        ]
    ] );

}

function noize_custom_post_types_skins_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_article'] ) && ! empty( $shortcode->atts['noize_text_typo_article'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__subtitle'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_article'] ) );
    }

    return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'noize_custom_post_types_skins_dynamic_css', 10, 2 );