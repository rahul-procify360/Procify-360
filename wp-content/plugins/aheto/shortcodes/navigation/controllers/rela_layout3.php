<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'rela_navigation_layout3');


/**
 * Navigation Shortcode
 */
function rela_navigation_layout3($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout('rela_layout3', [
        'title' => esc_html__('Navigation 25', 'rela'),
        'image' => $shortcode_dir . 'rela_layout3.jpg',
    ]);

    $shortcode->add_dependecy('rela_use_link_typo', 'template', 'rela_layout3');
    $shortcode->add_dependecy('rela_link_typo', 'template', 'rela_layout3');
    $shortcode->add_dependecy('rela_link_typo', 'rela_use_link_typo', 'true');

    aheto_demos_add_dependency(['title', 'title_space','list_space', 'text_typo', 'hovercolor' ], ['rela_layout3'], $shortcode);

    $shortcode->add_params([
        'rela_use_link_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for menu links?', 'rela'),
            'grid' => 3,
        ],
        'rela_link_typo' => [
            'type' => 'typography',
            'group' => 'Rela Menu Links Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .menu-item a',
        ],
    ]);
}

function rela_navigation_layout3_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_link_typo']) && !empty($shortcode->atts['rela_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .menu-item a'], $shortcode->parse_typography($shortcode->atts['rela_link_typo']));
    }

    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'rela_navigation_layout3_dynamic_css', 10, 2);