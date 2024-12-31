<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'pointe_navigation_layout3');

/**
 *  Banner Slider
 */

function pointe_navigation_layout3($shortcode)
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('pointe_layout3', [
		'title' => esc_html__('Pointe header 3', 'pointe'),
		'image' => $preview_dir . 'pointe_layout3.jpg',
	]);

	aheto_demos_add_dependency(['max_width', 'scroll_logo', 'add_scroll_logo','mob_logo', 'scroll_mob_logo', 'add_mob_scroll_logo', 'transparent', 'logo', 'label_logo', 'type_logo', 'text_logo', 'search'], ['pointe_layout3'], $shortcode);

	$shortcode->add_dependecy('pointe_use_desk_menu_link_typo', 'template', 'pointe_layout3');
	$shortcode->add_dependecy('pointe_desk_menu_link_typo', 'pointe_use_desk_menu_link_typo', 'true');
	
	$shortcode->add_dependecy('pointe_mob_menu_title', 'template', 'pointe_layout3');
	$shortcode->add_dependecy('pointe_desk_menu_title', 'template', 'pointe_layout3');
	$shortcode->add_dependecy('pointe_desk_menu', 'template', 'pointe_layout3');

	$shortcode->add_dependecy('pointe_use_mob_menu_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_mob_menu_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_mob_menu_title_typo', 'pointe_use_mob_menu_title_typo', 'true');

	$shortcode->add_dependecy('pointe_use_desk_menu_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_desk_menu_title_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_desk_menu_title_typo', 'pointe_use_desk_menu_title_typo', 'true');

	$shortcode->add_dependecy('pointe_use_label_logo_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_label_logo_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_label_logo_typo', 'pointe_use_label_logo_typo', 'true');

    $shortcode->add_dependecy('pointe_use_icon_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_icon_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_icon_typo', 'pointe_use_icon_typo', 'true');

    $shortcode->add_dependecy('pointe_use_link_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_link_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_link_typo', 'pointe_use_link_typo', 'true');

    $shortcode->add_dependecy('pointe_use_sub_link_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_sub_link_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_sub_link_typo', 'pointe_use_sub_link_typo', 'true');


	$shortcode->add_params([
        'pointe_use_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Menu links?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Menu links Typography',
            'settings' => [
                'text_align' => true,
                'text_align' => true
            ],
            'selector' => '{{WRAPPER}} .main-menu > li',
        ],
        'pointe_use_sub_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Sab-menu?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_sub_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Sub-Menu Typography',
            'settings' => [
                'text_align' => true,
                'text_align' => false
            ],
            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu ul li a',
        ],
		'pointe_use_desk_menu_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Desktop menu links?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_desk_menu_link_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Desk menu links Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .desk-menu__container .menu-item a',
		],
		'pointe_mob_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__('Type Mobile menu title', 'pointe'),
            'default' => esc_html__('Menu', 'pointe'),
        ],
		'pointe_desk_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__('Type Desktop menu title', 'pointe'),
            'default' => esc_html__('Menu', 'pointe'),
		],
		'pointe_desk_menu'         => [
            'type'    => 'select',
            'heading' => esc_html__('Desktop menu', 'pointe'),
            'options' => \Aheto\Helper::choices_nav_menu(),
		],
		'pointe_use_mob_menu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Mobile menu title?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_mob_menu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Mob menu title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .main-header__mob_menu_title',
		],
		'pointe_use_desk_menu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Desktop menu title?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_desk_menu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Desk menu title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .desk-menu__menu_title',
		],
		'pointe_use_label_logo_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Logo title?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_label_logo_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Logo title Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .main-header__logo-label',
		],
		'pointe_use_icon_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for networks?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_icon_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Networks Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .desk-menu-networks a',
        ]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_main_',
        'group'   => 'Desktop buttons',
        'icons'      => true,
        'dependency' => ['template', ['pointe_layout3']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_main_mob_',
        'group'   => 'Mobile Buttons',
        'icons'      => true,
        'dependency' => ['template', ['pointe_layout3']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_scroll_main_',
        'group'   => 'Scroll Buttons',
        'icons'      => true,
        'dependency' => ['template', ['pointe_layout3']]
    ]);
}
function pointe_navigation_layout3_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['pointe_use_desk_menu_link_typo']) && !empty($shortcode->atts['pointe_desk_menu_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .desk-menu__container .menu-item a'], $shortcode->parse_typography($shortcode->atts['pointe_desk_menu_link_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_link_typo']) && !empty($shortcode->atts['pointe_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .menu-item a'], $shortcode->parse_typography($shortcode->atts['pointe_link_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_sub_link_typo']) && !empty($shortcode->atts['pointe_sub_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__menu-box .main-menu ul li a'], $shortcode->parse_typography($shortcode->atts['pointe_sub_link_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_mob_menu_title_typo']) && !empty($shortcode->atts['pointe_mob_menu_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__mob_menu_title'], $shortcode->parse_typography($shortcode->atts['pointe_mob_menu_title_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_desk_menu_title_typo']) && !empty($shortcode->atts['pointe_desk_menu_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .desk-menu__menu_title'], $shortcode->parse_typography($shortcode->atts['pointe_desk_menu_title_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_label_logo_typo']) && !empty($shortcode->atts['pointe_label_logo_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__logo-label'], $shortcode->parse_typography($shortcode->atts['pointe_label_logo_typo']));
    }
    return $css;
	
}

add_filter('aheto_navigation_dynamic_css', 'pointe_navigation_layout3_dynamic_css', 10, 2);
