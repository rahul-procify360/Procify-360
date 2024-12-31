<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_navigation_register', 'aira_navigation_layout2' );



/**
 * Navigation Shortcode
 */
function aira_navigation_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira header first', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    aheto_demos_add_dependency(['max_width','mob_logo','add_scroll_logo','add_mob_scroll_logo','transparent','label_logo','type_logo','search', 'logo', 'text_logo', 'scroll_logo', 'scroll_mob_logo'], ['aira_layout2'], $shortcode);

    $shortcode->add_dependecy( 'aira_mob_menu_title', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_desk_menu_title', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_desk_menu', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_search_size', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_search_weight', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_dropdown_ico_size', 'template', 'aira_layout2' );

    $shortcode->add_dependecy( 'aira_use_desk_menu_link_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_desk_menu_link_typo', 'aira_use_desk_menu_link_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_mob_menu_title_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_mob_menu_title_typo', 'aira_use_mob_menu_title_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_desk_menu_title_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_desk_menu_title_typo', 'aira_use_desk_menu_title_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_label_logo_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_label_logo_typo', 'aira_use_label_logo_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_submenu_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_submenu_typo', 'aira_use_submenu_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_megamenu_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_megamenu_typo', 'aira_use_megamenu_typo', 'true' );

    $shortcode->add_params( [
        'aira_dropdown_ico_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Dropdown icon size', 'aira'),
            'description' => esc_html__( 'Enter Dropdown icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .dropdown-btn' => 'font-size: {{VALUE}}'],
        ],
        'aira_use_megamenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Megamenu title?', 'aira'),
            'grid' => 3,
        ],
        'aira_megamenu_typo' => [
            'type' => 'typography',
            'group' => 'Megamenu title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .mega-menu .mega-menu__title',
        ],
        'aira_use_submenu_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Submenus?', 'aira'),
            'grid' => 3,
        ],
        'aira_submenu_typo' => [
            'type' => 'typography',
            'group' => 'Submenus Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu ul li a',
        ],
        'aira_search_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Search icon size', 'aira'),
            'description' => esc_html__( 'Enter search icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .search-btn i' => 'font-size: {{VALUE}}'],
        ],
        'aira_search_weight' => [
            'type'    => 'text',
            'heading' => esc_html__('Search icon weight', 'aira'),
            'description' => esc_html__( 'Enter search icon font weight (normal, bold).', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .search-btn i:before' => 'font-weight: {{VALUE}}'],
        ],
        'aira_use_label_logo_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Logo title?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_label_logo_typo' => [
            'type'     => 'typography',
            'group'    => 'Logo title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__logo-label',
        ],
        'aira_use_desk_menu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Desktop menu title?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_desk_menu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Desktop menu title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .desk-menu__menu_title',
        ],
        'aira_use_mob_menu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Mobile menu title?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_mob_menu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Mobile menu title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .main-header__mob_menu_title',
        ],
        'aira_desk_menu'         => [
            'type'    => 'select',
            'heading' => esc_html__( 'Desktop menu', 'aira' ),
            'options' => Helper::choices_nav_menu(),
        ],
        'aira_use_desk_menu_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Desktop menu links?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_desk_menu_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Desktop menu links Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .desk-menu__container .menu-item a',
        ],
        'aira_mob_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Type Mobile menu title', 'aira' ),
            'default' => esc_html__( 'Menu', 'aira' ),
        ],
        'aira_desk_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Type Desktop menu title', 'aira' ),
            'default' => esc_html__( 'Menu', 'aira' ),
        ],

    ] );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'aira_main_',
        'group'   => 'Desktop buttons',
        'icons'      => true,
        'dependency' => ['template', ['aira_layout2']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'aira_main_mob_',
        'group'   => 'Mobile Buttons',
        'icons'      => true,
        'dependency' => ['template', ['aira_layout2']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'aira_scroll_main_',
        'group'   => 'Scroll Buttons (Only for fixed header)',
        'icons'      => true,
        'dependency' => ['template', ['aira_layout2']]
    ]);
}

function aira_navigation_layout2_dynamic_css( $css, $shortcode ) {
    if ( !empty($shortcode->atts['aira_dropdown_ico_size']) ) {
        $css['global']['%1$s .dropdown-btn']['font-size'] = Sanitize::size( $shortcode->atts['aira_dropdown_ico_size'] );
    }
    if (!empty($shortcode->atts['aira_use_megamenu_typo']) && !empty($shortcode->atts['aira_megamenu_typo'])) {
        \aheto_add_props($css['global']['%1$s .mega-menu .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['aira_megamenu_typo']));
    }
    if ( !empty($shortcode->atts['aira_search_weight']) ) {
        $css['global']['%1$s .search-btn i:before']['font-weight'] = Sanitize::size( $shortcode->atts['aira_search_weight'] );
    }
    if ( !empty($shortcode->atts['aira_search_size']) ) {
        $css['global']['%1$s .search-btn i']['font-size'] = Sanitize::size( $shortcode->atts['aira_search_size'] );
    }
    if ( ! empty( $shortcode->atts['aira_use_desk_menu_link_typo'] ) && ! empty( $shortcode->atts['aira_desk_menu_link_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .desk-menu__container .menu-item a'], $shortcode->parse_typography( $shortcode->atts['aira_desk_menu_link_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_mob_menu_title_typo'] ) && ! empty( $shortcode->atts['aira_mob_menu_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-header__mob_menu_title'], $shortcode->parse_typography( $shortcode->atts['aira_mob_menu_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_desk_menu_title_typo'] ) && ! empty( $shortcode->atts['aira_desk_menu_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .desk-menu__menu_title'], $shortcode->parse_typography( $shortcode->atts['aira_desk_menu_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_label_logo_typo'] ) && ! empty( $shortcode->atts['aira_label_logo_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-header__logo-label'], $shortcode->parse_typography( $shortcode->atts['aira_label_logo_typo'] ) );
    }
    return $css;
}
add_filter( 'aheto_navigation_dynamic_css', 'aira_navigation_layout2_dynamic_css', 10, 2 );

