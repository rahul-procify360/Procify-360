<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'bizy_navigation_layout3');


/**
 * Navigation Shortcode
 */
function bizy_navigation_layout3($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/navigation/previews/';


    $shortcode->add_layout('bizy_layout3', [
        'title' => esc_html__('Bizy Classic', 'bizy'),
        'image' => $shortcode_dir . 'bizy_layout3.jpg',
    ]);


    $shortcode->add_dependecy('bizy_mob_menu_title', 'template', 'bizy_layout3');
    $shortcode->add_dependecy('bizy_dropdown_ico_size', 'template', 'bizy_layout3');

    $shortcode->add_dependecy('bizy_use_mob_menu_title_typo', 'template', 'bizy_layout3');
    $shortcode->add_dependecy('bizy_mob_menu_title_typo', 'template', 'bizy_layout3');
    $shortcode->add_dependecy('bizy_mob_menu_title_typo', 'bizy_use_mob_menu_title_typo', 'true');

    $shortcode->add_dependecy( 'bizy_use_submenu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_submenu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_submenu_typo', 'bizy_use_submenu_typo', 'true' );

    $shortcode->add_dependecy( 'bizy_use_menu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_menu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_menu_typo', 'bizy_use_menu_typo', 'true' );

    $shortcode->add_dependecy( 'bizy_use_megamenu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_megamenu_typo', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_megamenu_typo', 'bizy_use_megamenu_typo', 'true' );

    $shortcode->add_dependecy('bizy_search_size', 'template', 'bizy_layout3');

	aheto_demos_add_dependency(['max_width', 'mob_logo','add_scroll_logo', 'scroll_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'transparent', 'type_logo', 'logo', 'text_logo', 'mobile_menu_width' ], ['bizy_layout3'], $shortcode);

	$shortcode->add_params([
        'bizy_search_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Search icon size', 'bizy'),
            'description' => esc_html__( 'Enter search icon font size with units.', 'bizy' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .search-btn' => 'font-size: {{VALUE}}'],
        ],
        'bizy_use_megamenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Mega menu title?', 'bizy'),
            'grid' => 3,
        ],
        'bizy_megamenu_typo' => [
            'type' => 'typography',
            'group' => 'Bizy Mega Menu Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .mega-menu .mega-menu__title',
        ],
        'bizy_use_menu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for menu?', 'bizy'),
            'grid' => 3,
        ],
        'bizy_menu_typo' => [
            'type' => 'typography',
            'group' => 'Bizy Menu Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu>li>a',
        ],
        'bizy_use_submenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for submenu?', 'bizy'),
            'grid' => 3,
        ],
        'bizy_submenu_typo' => [
            'type' => 'typography',
            'group' => 'Bizy Submenu Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu ul li a',
        ],
        'bizy_dropdown_ico_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Dropdown icon size', 'bizy'),
            'description' => esc_html__( 'Enter Dropdown icon font size with units.', 'bizy' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .dropdown-btn' => 'font-size: {{VALUE}}'],
        ],
        'bizy_mob_menu_title' => [
            'type' => 'text',
            'heading' => esc_html__('Type Mobile menu title', 'bizy'),
            'default' => esc_html__('Menu', 'bizy'),
        ],
        'bizy_use_mob_menu_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for mobile menu title?', 'bizy'),
            'grid' => 3,
        ],
        'bizy_mob_menu_title_typo' => [
            'type' => 'typography',
            'group' => 'Bizy Mobile Menu Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__mob_menu_title',
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'bizy_main_',
        'group' => 'Desktop buttons',
        'icons' => true,
        'dependency' => ['template', ['bizy_layout3']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'bizy_main_mob_',
        'group' => 'Mobile Buttons',
        'icons' => true,
        'dependency' => ['template', ['bizy_layout3']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'bizy_scroll_main_',
        'group' => 'Scroll Buttons',
        'icons' => true,
        'dependency' => ['template', ['bizy_layout3']]
    ]);
}

function bizy_navigation_layout3_dynamic_css($css, $shortcode)
{
    if ( !empty($shortcode->atts['bizy_search_size']) ) {
        $css['global']['%1$s .search-btn']['font-size'] = Sanitize::size( $shortcode->atts['bizy_search_size'] );
    }
    if (!empty($shortcode->atts['bizy_use_mob_menu_title_typo']) && !empty($shortcode->atts['bizy_mob_menu_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__mob_menu_title'], $shortcode->parse_typography($shortcode->atts['bizy_mob_menu_title_typo']));
    }
    if ( !empty($shortcode->atts['bizy_dropdown_ico_size']) ) {
        $css['global']['%1$s .dropdown-btn']['font-size'] = Sanitize::size( $shortcode->atts['bizy_dropdown_ico_size'] );
    }
    if (!empty($shortcode->atts['bizy_use_submenu_typo']) && !empty($shortcode->atts['bizy_submenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-menu ul li a'], $shortcode->parse_typography($shortcode->atts['bizy_submenu_typo']));
    }
    if (!empty($shortcode->atts['bizy_use_menu_typo']) && !empty($shortcode->atts['bizy_menu_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-menu>li>a'], $shortcode->parse_typography($shortcode->atts['bizy_menu_typo']));
    }
    if (!empty($shortcode->atts['bizy_use_megamenu_typo']) && !empty($shortcode->atts['bizy_megamenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .mega-menu .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['bizy_megamenu_typo']));
    }
    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'bizy_navigation_layout3_dynamic_css', 10, 2);
