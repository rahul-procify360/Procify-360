<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'pointe_navigation_layout2');

/**
 *  Banner Slider
 */

function pointe_navigation_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('pointe_layout2', [
		'title' => esc_html__('Pointe header 2', 'pointe'),
		'image' => $preview_dir . 'pointe_layout2.jpg',
	]);

	aheto_demos_add_dependency(['max_width', 'scroll_logo', 'add_scroll_logo', 'scroll_mob_logo', 'mob_logo','add_mob_scroll_logo', 'transparent', 'logo', 'label_logo', 'type_logo', 'text_logo'], ['pointe_layout2'], $shortcode);

	$shortcode->add_dependecy('pointe_mob_menu_title', 'template', 'pointe_layout2');
	$shortcode->add_dependecy('pointe_use_mob_menu_title_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_mob_menu_title_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_mob_menu_title_typo', 'pointe_use_mob_menu_title_typo', 'true');

    $shortcode->add_dependecy('pointe_use_label_logo_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_label_logo_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_label_logo_typo', 'pointe_use_label_logo_typo', 'true');

    $shortcode->add_dependecy('pointe_use_link_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_link_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_link_typo', 'pointe_use_link_typo', 'true');

    $shortcode->add_dependecy('pointe_use_sub_link_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_sub_link_typo', 'template', 'pointe_layout2');
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
                'text_align' => false
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
		'pointe_mob_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__('Type Mobile menu title', 'pointe'),
            'default' => esc_html__('Menu', 'pointe'),
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
                'text_align' => false
            ],
            'selector' => '{{WRAPPER}} .main-header__mob_menu_title',
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
		]
    ]);
   
}
function pointe_navigation_layout2_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['pointe_use_link_typo']) && !empty($shortcode->atts['pointe_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .menu-item a'], $shortcode->parse_typography($shortcode->atts['pointe_link_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_sub_link_typo']) && !empty($shortcode->atts['pointe_sub_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__menu-box .main-menu ul li a'], $shortcode->parse_typography($shortcode->atts['pointe_sub_link_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_mob_menu_title_typo']) && !empty($shortcode->atts['pointe_mob_menu_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__mob_menu_title'], $shortcode->parse_typography($shortcode->atts['pointe_mob_menu_title_typo']));
    }
    
    if (!empty($shortcode->atts['pointe_use_label_logo_typo']) && !empty($shortcode->atts['pointe_label_logo_typo'])) {
        \aheto_add_props($css['global']['%1$s .main-header__logo-label'], $shortcode->parse_typography($shortcode->atts['pointe_label_logo_typo']));
    }
    return $css;
	
}

add_filter('aheto_navigation_dynamic_css', 'pointe_navigation_layout2_dynamic_css', 10, 2);
