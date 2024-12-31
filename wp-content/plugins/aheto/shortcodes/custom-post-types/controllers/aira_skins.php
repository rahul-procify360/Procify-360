<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_custom-post-types_register', 'aira_custom_post_types_skins' );

/**
 * Custom post type skins
 */
function aira_custom_post_types_skins($shortcode) {

    $aheto_skins      = $shortcode->params["skin"]["options"];
    $aira_skins = array(
        "aira_skin-1" => "Aira skin 1",
        "aira_skin-2" => "Aira skin 2",
        "aira_skin-3" => "Aira skin 3",
        "aira_skin-4" => "Aira skin 4",
        "aira_skin-5" => "Aira skin 5",
    );

    $all_skins = array_merge($aheto_skins, $aira_skins);

    $shortcode->params['skin']['options'] = $all_skins;

    $shortcode->add_dependecy('aira_dot', 'skin', 'aira_skin-1');
    $shortcode->add_dependecy('aira_dot_color', 'skin', 'aira_skin-1');
    $shortcode->add_dependecy("aira_img_off", "skin", "aira_skin-1");
    $shortcode->add_dependecy("aira_date_off", "skin", ["aira_skin-1", "aira_skin-2"]);
    $shortcode->add_dependecy("aira_author_off", "skin", ["aira_skin-1", "aira_skin-2"]);
    $shortcode->add_dependecy("aira_date_label", "skin", "aira_skin-1");
    $shortcode->add_dependecy("aira_use_date_typo", "skin", "aira_skin-1" );
    $shortcode->add_dependecy("aira_use_author_typo", "skin", ["aira_skin-1", "aira_skin-2", "aira_skin-5"] );
    $shortcode->add_dependecy("aira_content_after", "skin", "aira_skin-1" );
    $shortcode->add_dependecy("aira_title_space", "skin", "aira_skin-1" );

    $shortcode->add_dependecy("aira_use_excerpt_typo", "skin", ["aira_skin-1", "aira_skin-2", "aira_skin-3", "aira_skin-5"] );
    $shortcode->add_dependecy("aira_excerpt_typo", "aira_use_excerpt_typo", "true" );

    $shortcode->add_dependecy("aira_use_terms_typo", "skin", ["aira_skin-3", "aira_skin-5"] );
    $shortcode->add_dependecy("aira_terms_typo", "aira_use_terms_typo", "true" );

    $shortcode->add_dependecy("aira_use_tags_typo", "skin", "aira_skin-5" );
    $shortcode->add_dependecy("aira_tags_typo", "aira_use_tags_typo", "true" );

    $shortcode->add_dependecy("aira_use_quote_typo", "skin", "aira_skin-5" );
    $shortcode->add_dependecy("aira_quote_typo", "aira_use_quote_typo", "true" );

    $shortcode->add_dependecy("aira_use_cite_typo", "skin", "aira_skin-5" );
    $shortcode->add_dependecy("aira_cite_typo", "aira_use_cite_typo", "true" );

    $shortcode->add_dependecy( "aira_date_typo", "aira_use_date_typo", "true" );
    $shortcode->add_dependecy( "aira_author_typo", "aira_use_author_typo", "true" );
    $shortcode->add_dependecy( 'aira_dot_color', 'aira_dot', 'true' );
    

    $shortcode->add_params([
        'aira_use_cite_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Cite?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_cite_typo' => [
            'type'     => 'typography',
            'group'    => 'Cite Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__quote cite',
        ],
        'aira_use_quote_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Quote?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_quote_typo' => [
            'type'     => 'typography',
            'group'    => 'Quote Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__quote',
        ],
        'aira_use_tags_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Tags?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_tags_typo' => [
            'type'     => 'typography',
            'group'    => 'Tags Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__tags a',
        ],
        'aira_use_terms_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Terms?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_terms_typo' => [
            'type'     => 'typography',
            'group'    => 'Terms Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date, .aheto-cpt-article__terms',
        ],
        'aira_title_space'    => [
            'type'      => 'responsive_spacing',
            'heading'   => esc_html__( 'Margin spaces for title', 'aira' ),
            'grid'      => 12,
            'selectors' => [
                '{{WRAPPER}} .aheto-cpt-article__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ],
        'aira_content_after' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Add styled corner?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_dot' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dot in the end titles?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_dot_color' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Color for dot', 'aira' ),
            'options' => [
                'primary' => esc_html__( 'Primary', 'aira' ),
                'dark'    => esc_html__( 'Dark', 'aira' ),
                'white'   => esc_html__( 'White', 'aira' ),
            ],
            'default' => 'primary',
        ],
        "aira_author_off" => [
            "type"    => "switch",
            "heading" => esc_html__("Disable post author?", 'aira'),
            "grid"    => 12,
        ],
        "aira_img_off" => [
            "type"    => "switch",
            "heading" => esc_html__("Disable post image?", 'aira'),
            "grid"    => 12,
        ],
        "aira_date_off" => [
            "type"    => "switch",
            "heading" => esc_html__("Disable post date?", 'aira'),
            "grid"    => 12,
        ],
        "aira_date_label"        => [
            "type"    => "text",
            "heading" => esc_html__( "Date label", 'aira' ),
            "default" => esc_html__( "in World", 'aira' ),
        ],
        'aira_use_date_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Date?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_date_typo' => [
            'type'     => 'typography',
            'group'    => 'Date Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
        ],
        'aira_use_author_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Author?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_author_typo' => [
            'type'     => 'typography',
            'group'    => 'Author Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
        ],
        'aira_use_excerpt_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Excerpt?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_excerpt_typo' => [
            'type'     => 'typography',
            'group'    => 'Excerpt Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
        ],
    ]);
    
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'group' => 'Content',
        'add_label'  => esc_html__( 'Add icon for Button?', 'aira' ),
        'prefix'     => 'aira_',
        'exclude'  => ['align'],
        'dependency' => ['skin', ['aira_skin-3']]
    ]);
}

function aira_cpt_skins_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['aira_use_cite_typo'] ) && ! empty( $shortcode->atts['aira_cite_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote cite'], $shortcode->parse_typography( $shortcode->atts['aira_cite_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_terms_typo'] ) && ! empty( $shortcode->atts['aira_terms_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date, %1$s .aheto-cpt-article__terms'], $shortcode->parse_typography( $shortcode->atts['aira_terms_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_tags_typo'] ) && ! empty( $shortcode->atts['aira_tags_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__tags a'], $shortcode->parse_typography( $shortcode->atts['aira_tags_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_quote_typo'] ) && ! empty( $shortcode->atts['aira_quote_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote'], $shortcode->parse_typography( $shortcode->atts['aira_quote_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_date_typo'] ) && ! empty( $shortcode->atts['aira_date_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography( $shortcode->atts['aira_date_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_author_typo'] ) && ! empty( $shortcode->atts['aira_author_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__author'], $shortcode->parse_typography( $shortcode->atts['aira_author_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_excerpt_typo'] ) && ! empty( $shortcode->atts['aira_excerpt_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__excerpt'], $shortcode->parse_typography( $shortcode->atts['aira_excerpt_typo'] ) );
    }
    if ( !empty($shortcode->atts['aira_title_space']) ) {
        $selector                   = '%1$s .aheto-cpt-article__title';
        $shortcode->atts['aira_title_space'] = Sanitize::responsive_spacing($shortcode->atts['aira_title_space'], 'margin');

        if ( !empty($shortcode->atts['aira_title_space']['desktop']) ) {
            \aheto_add_props($css['global'][$selector], $shortcode->atts['aira_title_space']['desktop']);
        }
        if ( !empty($shortcode->atts['aira_title_space']['laptop']) ) {
            \aheto_add_props($css['@media (max-width: 1199px)'][$selector], $shortcode->atts['aira_title_space']['laptop']);
        }
        if ( !empty($shortcode->atts['aira_title_space']['tablet']) ) {
            \aheto_add_props($css['@media (max-width: 991px)'][$selector], $shortcode->atts['aira_title_space']['tablet']);
        }
        if ( !empty($shortcode->atts['aira_title_space']['mobile']) ) {
            \aheto_add_props($css['@media (max-width: 767px)'][$selector], $shortcode->atts['aira_title_space']['mobile']);
        }
    }
    return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'aira_cpt_skins_dynamic_css', 10, 2 );




/**
 * Dot string replace
 */
function aira_dot_string( $string, $dot, $aira_dot_color ) {

    if ( $dot ) {

        $string = str_replace( '{{.}}', '<span class="aira-dot dot-' . esc_attr( $aira_dot_color ) . '"></span>', $string );

        $words = explode( " ", $string );

        if ( count( $words ) > 0 ) {
            $last_word = $words[ count( $words ) - 1 ];

            $last_space_position = strrpos( $string, ' ' );
            $start_string        = substr( $string, 0, $last_space_position );

            return wp_kses( $start_string, 'post' ) . ' <span class="aira-dot dot-' . esc_attr( $aira_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
        } else {
            return '<span class="aira-dot dot-' . esc_attr( $aira_dot_color ) . '">' . wp_kses( $string, 'post' ) . '</span>';
        }

    } else {
        return wp_kses( $string, 'post' );
    }
}