<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'rela_blockquote_layout1');

/**
 * Blockquote Shortcode
 */
function rela_blockquote_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/blockquote/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Blockquote 5', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_date', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_author_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_author_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_author_typo', 'rela_use_author_typo', 'true');

    $shortcode->add_dependecy('rela_use_date_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_date_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_date_typo', 'rela_use_date_typo', 'true');

    $shortcode->add_dependecy('rela_use_quote_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_quote_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_quote_typo', 'rela_use_quote_typo', 'true');

    aheto_demos_add_dependency(['quote', 'qoute_tag', 'author', 'align', 'max_width', 'quote_spacing', 'icon_position', 'icon_size', 'icon_color' ], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_quote_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for quote?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_quote_typo' => [
            'type' => 'typography',
            'group' => 'Rela Quote Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-quote--rela-simple:before',
        ],
        'rela_use_date_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for date?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_date_typo' => [
            'type' => 'typography',
            'group' => 'Rela Date Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-quote__date',
        ],
        'rela_date' => [
            'type' => 'text',
            'group' => 'Content',
            'heading' => esc_html__('Date', 'rela'),
        ],
        'rela_use_author_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for author?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_author_typo' => [
            'type' => 'typography',
            'group' => 'Rela Author Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-quote__author',
        ],
    ]);

}

function rela_blockquote_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['rela_use_quote_typo']) && !empty($shortcode->atts['rela_quote_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-quote--rela-simple:before'], $shortcode->parse_typography($shortcode->atts['rela_quote_typo']));
    }
    if (!empty($shortcode->atts['rela_use_author_typo']) && !empty($shortcode->atts['rela_author_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-quote__author'], $shortcode->parse_typography($shortcode->atts['rela_author_typo']));
    }
    if (!empty($shortcode->atts['rela_use_date_typo']) && !empty($shortcode->atts['rela_date_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-quote__date'], $shortcode->parse_typography($shortcode->atts['rela_date_typo']));
    }
    return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'rela_blockquote_layout1_dynamic_css', 10, 2);
