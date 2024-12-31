<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'rela_custom_post_types_skins');


/**
 * Rela custom post type style for blog items
 */
function rela_custom_post_types_skins($shortcode)
{

    $aheto_skins = $shortcode->params["skin"]["options"];
    $rela_skins = array(
        "rela_skin-1" => "Rela skin 1",
    );

    $all_skins = array_merge($aheto_skins, $rela_skins);

    $shortcode->params["skin"]["options"] = $all_skins;

    $shortcode->add_dependecy("rela_paddings", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_img_off", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_date_off", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_date_label", "skin", "rela_skin-1");

    $shortcode->add_dependecy("rela_use_date_typo", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_date_typo", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_date_typo", "rela_use_date_typo", "true");

    $shortcode->add_dependecy("rela_use_author_typo", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_author_typo", "skin", "rela_skin-1");
    $shortcode->add_dependecy("rela_author_typo", "rela_use_author_typo", "true");

    $shortcode->add_params([
        "rela_img_off" => [
            "type" => "switch",
            "heading" => esc_html__("Disable post image?", 'rela'),
            "grid" => 12,
        ],
        "rela_date_off" => [
            "type" => "switch",
            "heading" => esc_html__("Disable post date?", 'rela'),
            "grid" => 12,
        ],
        "rela_date_label" => [
            "type" => "text",
            "heading" => esc_html__("Date label", 'rela'),
            "default" => esc_html__("in World", 'rela'),
        ],
        'rela_use_date_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for date?', 'rela'),
            'grid' => 3,
        ],
        'rela_date_typo' => [
            'type' => 'typography',
            'group' => 'Rela Date Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
        ],
        'rela_use_author_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for author?', 'rela'),
            'grid' => 3,
        ],
        'rela_author_typo' => [
            'type' => 'typography',
            'group' => 'Rela Author Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
        ],
	    'rela_paddings'    => [
		    'type'      => 'responsive_spacing',
		    'heading'   => esc_html__( 'Rela Block Padding', 'rela' ),
		    'grid'      => 6,
		    'selectors' => [
			    '{{WRAPPER}} .aheto-cpt-article__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		    ],
	    ],
    ]);

}

function rela_cpt_skins_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_date_typo']) && !empty($shortcode->atts['rela_date_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['rela_date_typo']));
    }

    if (!empty($shortcode->atts['rela_use_author_typo']) && !empty($shortcode->atts['rela_author_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__author'], $shortcode->parse_typography($shortcode->atts['rela_author_typo']));
    }

    return $css;
}

add_filter('aheto_cpt_dynamic_css', 'rela_cpt_skins_dynamic_css', 10, 2);