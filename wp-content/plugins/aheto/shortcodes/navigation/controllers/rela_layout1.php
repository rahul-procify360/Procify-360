<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'rela_navigation_layout1');


/**
 * Navigation Shortcode
 */
function rela_navigation_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Navigation 23', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_mob_menu_title', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_search_size', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_dropdown_ico_size', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_mob_menu_title_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_mob_menu_title_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_mob_menu_title_typo', 'rela_use_mob_menu_title_typo', 'true');

    $shortcode->add_dependecy( 'rela_use_submenu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_submenu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_submenu_typo', 'rela_use_submenu_typo', 'true' );

    $shortcode->add_dependecy( 'rela_use_menu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_menu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_menu_typo', 'rela_use_menu_typo', 'true' );

    $shortcode->add_dependecy( 'rela_use_megamenu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_megamenu_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_megamenu_typo', 'rela_use_megamenu_typo', 'true' );

    aheto_demos_add_dependency(['search','max_width', 'mob_logo', 'add_scroll_logo', 'scroll_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'transparent', 'type_logo', 'logo', 'text_logo', 'mobile_menu_width' ], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_megamenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Mega menu title?', 'rela'),
            'grid' => 3,
        ],
        'rela_megamenu_typo' => [
            'type' => 'typography',
            'group' => 'Rela Mega Menu Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .mega-menu .mega-menu__title',
        ],
        'rela_use_menu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for menu?', 'rela'),
            'grid' => 3,
        ],
        'rela_menu_typo' => [
            'type' => 'typography',
            'group' => 'Rela Menu Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu>li>a',
        ],
        'rela_use_submenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for submenu?', 'rela'),
            'grid' => 3,
        ],
        'rela_submenu_typo' => [
            'type' => 'typography',
            'group' => 'Rela Submenu Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu ul li a',
        ],
        'rela_dropdown_ico_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Dropdown icon size', 'rela'),
            'description' => esc_html__( 'Enter Dropdown icon font size with units.', 'rela' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .dropdown-btn' => 'font-size: {{VALUE}}'],
        ],
        'rela_search_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Search icon size', 'rela'),
            'description' => esc_html__( 'Enter search icon font size with units.', 'rela' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .search-btn' => 'font-size: {{VALUE}}'],
        ],
        'rela_mob_menu_title' => [
            'type' => 'text',
            'heading' => esc_html__('Type Mobile menu title', 'rela'),
            'default' => esc_html__('Menu', 'rela'),
        ],
        'rela_use_mob_menu_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for mobile menu title?', 'rela'),
            'grid' => 3,
        ],
        'rela_mob_menu_title_typo' => [
            'type' => 'typography',
            'group' => 'Rela Mobile Menu Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__mob_menu_title',
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'rela_main_',
        'group' => 'Desktop buttons',
        'icons' => true,
        'dependency' => ['template', ['rela_layout1']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'rela_main_mob_',
        'group' => 'Mobile Buttons',
        'icons' => true,
        'dependency' => ['template', ['rela_layout1']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'rela_scroll_main_',
        'group' => 'Scroll Buttons',
        'icons' => true,
        'dependency' => ['template', ['rela_layout1']]
    ]);
}

function rela_navigation_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_mob_menu_title_typo']) && !empty($shortcode->atts['rela_mob_menu_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__mob_menu_title'], $shortcode->parse_typography($shortcode->atts['rela_mob_menu_title_typo']));
    }
    if ( !empty($shortcode->atts['rela_dropdown_ico_size']) ) {
        $css['global']['%1$s .dropdown-btn']['font-size'] = Sanitize::size( $shortcode->atts['rela_dropdown_ico_size'] );
    }
    if ( !empty($shortcode->atts['rela_search_size']) ) {
        $css['global']['%1$s .search-btn']['font-size'] = Sanitize::size( $shortcode->atts['rela_search_size'] );
    }
    if (!empty($shortcode->atts['rela_use_submenu_typo']) && !empty($shortcode->atts['rela_submenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-menu ul li a'], $shortcode->parse_typography($shortcode->atts['rela_submenu_typo']));
    }
    if (!empty($shortcode->atts['rela_use_menu_typo']) && !empty($shortcode->atts['rela_menu_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-menu>li>a'], $shortcode->parse_typography($shortcode->atts['rela_menu_typo']));
    }
    if (!empty($shortcode->atts['rela_use_megamenu_typo']) && !empty($shortcode->atts['rela_megamenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .mega-menu .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['rela_megamenu_typo']));
    }
    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'rela_navigation_layout1_dynamic_css', 10, 2);