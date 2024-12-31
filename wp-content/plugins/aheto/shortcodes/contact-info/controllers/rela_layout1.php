<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'rela_contact_info_layout1');


/**
 * Contact-info Shortcode
 */
function rela_contact_info_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/contact-info/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Contact Info 8', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_use_title_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_title_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_title_typo', 'rela_use_title_typo', 'true');

    $shortcode->add_dependecy('rela_use_links_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_links_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_links_typo', 'rela_use_links_typo', 'true');

    aheto_demos_add_dependency(['title', 'address', 'email', 'phone', 'type_logo', 'text_logo', 'logo', 'use_typo_logo', 'logo_typo', 'use_typo_text', 'text_typo', 'hovercolor'], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_links_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for link?', 'rela'),
            'grid' => 3,
        ],
        'rela_links_typo' => [
            'type' => 'typography',
            'group' => 'Rela Link Typography',
            'settings' => [
                'text_align' => false,
                'tag' => false,
            ],
            'selector' => '{{WRAPPER}} .widget_aheto__info a',
        ],
        'rela_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for title?', 'rela'),
            'grid' => 3,
        ],
        'rela_title_typo' => [
            'type' => 'typography',
            'group' => 'Rela Title Typography',
            'settings' => [
                'text_align' => false,
                'tag' => false,
            ],
            'selector' => '{{WRAPPER}} .widget_aheto__title',
        ],
    ]);
}

function rela_contact_info_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_title_typo']) && !empty($shortcode->atts['rela_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .widget_aheto__title'], $shortcode->parse_typography($shortcode->atts['rela_title_typo']));
    }

    if (!empty($shortcode->atts['rela_use_links_typo']) && !empty($shortcode->atts['rela_links_typo'])) {
        \aheto_add_props($css['global']['%1$s .widget_aheto__info a'], $shortcode->parse_typography($shortcode->atts['rela_links_typo']));
    }
    return $css;
}

add_filter('aheto_contact_info_dynamic_css', 'rela_contact_info_layout1_dynamic_css', 10, 2);

