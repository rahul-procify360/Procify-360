<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'vestry_navigation_layout2');

/**
 * Navigation
 */
function vestry_navigation_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout('vestry_layout2', [
        'title' => esc_html__('Navigation 29', 'vestry'),
        'image' => $preview_dir . 'hryzantema_layout1.jpg',
    ]);

    $shortcode->add_dependecy('vestry_use_links_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_links_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_links_typo', 'vestry_use_links_typo', 'true');

    $shortcode->add_dependecy('vestry_use_megamenu_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_megamenu_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_megamenu_typo', 'vestry_use_megamenu_typo', 'true');

    $shortcode->add_dependecy('vestry_dropdown_ico_size', 'template', 'vestry_layout2');

    aheto_demos_add_dependency(['transparent', 'type_logo', 'text_logo', 'logo', 'add_scroll_logo', 'scroll_logo', 'mobile_menu_width'], ['vestry_layout2'], $shortcode);

    $shortcode->add_params([
        'vestry_use_links_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for navigation?', 'vestry'),
            'grid' => 12,
            'default' => '',
        ],
        'vestry_links_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Navigation Typography',
            'settings' => [
                'text_align' => false,
                'tag' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu a',
        ],
        'vestry_use_megamenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Mega menu title?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_megamenu_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Mega Menu Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .mega-menu .mega-menu__title',
        ],
        'vestry_dropdown_ico_size' => [
            'type' => 'text',
            'heading' => esc_html__('Dropdown icon size', 'vestry'),
            'description' => esc_html__('Enter Dropdown icon font size with units.', 'vestry'),
            'grid' => 6,
            'selector' => ['{{WRAPPER}} .menu-item-has-children:before' => 'font-size: {{VALUE}}'],
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'vestry_main_',
        'group' => 'Desktop buttons',
        'icons' => true,
        'add_button' => true,
        'dependency' => ['template', ['vestry_layout2']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'vestry'),
        'prefix' => 'vestry_add_',
        'group' => 'Desktop buttons',
        'icons' => true,
        'add_button' => true,
        'dependency' => ['template', ['vestry_layout2']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'vestry_main_mob_',
        'group' => 'Mobile Buttons',
        'icons' => true,
        'add_button' => true,
        'dependency' => ['template', ['vestry_layout2']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'vestry'),
        'prefix' => 'vestry_add_mob_',
        'group' => 'Mobile Buttons',
        'icons' => true,
        'add_button' => true,
        'dependency' => ['template', ['vestry_layout2']]
    ]);
}

function vestry_navigation_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['vestry_dropdown_ico_size'])) {
        $css['global']['%1$s .menu-item-has-children:before']['font-size'] = Sanitize::size($shortcode->atts['vestry_dropdown_ico_size']);
    }
    if (!empty($shortcode->atts['vestry_use_links_typo']) && !empty($shortcode->atts['vestry_links_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-menu a'], $shortcode->parse_typography($shortcode->atts['vestry_links_typo']));
    }
    if (!empty($shortcode->atts['vestry_use_megamenu_typo']) && !empty($shortcode->atts['vestry_megamenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .mega-menu .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['vestry_megamenu_typo']));
    }
    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'vestry_navigation_layout2_dynamic_css', 10, 2);