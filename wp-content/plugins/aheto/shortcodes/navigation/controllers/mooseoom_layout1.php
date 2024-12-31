<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'mooseoom_navigation_layout1');

/**
 *  Banner Slider
 */

function mooseoom_navigation_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Navigation 16', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);

	aheto_demos_add_dependency(['type_logo', 'text_logo', 'logo', 'mob_logo', 'networks', 'use_logo_typo', 'logo_typo', 'mobile_menu_width'], ['mooseoom_layout1'], $shortcode);

	$shortcode->add_dependecy('mooseoom_style', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_icons_color', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_links_hover', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_copyright', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_bg_image', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_overlay', 'template', 'mooseoom_layout1');

	$shortcode->add_dependecy('mooseoom_use_menu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_menu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_menu_typo', 'mooseoom_use_menu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_submenu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_submenu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_submenu_typo', 'mooseoom_use_submenu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_mobmenutitle_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_mobmenutitle_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_mobmenutitle_typo', 'mooseoom_use_mobmenutitle_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_btnclose_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_btnclose_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_btnclose_typo', 'mooseoom_use_btnclose_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_megamenu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_megamenu_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_megamenu_typo', 'mooseoom_use_megamenu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_copyright_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_copyright_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_copyright_typo', 'mooseoom_use_copyright_typo', 'true');


	$shortcode->add_params([
		'mooseoom_style'     => [
			'type'    => 'select',
			'heading' => esc_html__('Type of menu', 'aheto'),
			'options' => [
				'type_white' => esc_html__('Light', 'aheto'),
				'type_dark' => esc_html__('Dark', 'aheto'),
			],
			'default' => 'type_white',
		],
		'mooseoom_links_hover'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Dropdown icons color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .main-header--desktop .dropdown-btn:before' => 'background-color: {{VALUE}}!important',
				'{{WRAPPER}} .main-header--desktop .dropdown-btn:after' => 'background-color: {{VALUE}}!important'
			],
		],
		'mooseoom_icons_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links hover color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .main-menu li a:hover' => 'color: {{VALUE}}'
			],
		],
		'mooseoom_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu?', 'aheto'),
			'grid'    => 3,
		],
		'mooseoom_menu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
		'mooseoom_use_submenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_submenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Submenu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu .sub-menu li a',
		],
		'mooseoom_use_megamenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Megamenu Titles?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_megamenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Megamenu Titles Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__title',
		],
		'mooseoom_use_mobmenutitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for mobile menu title?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_mobmenutitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Mobile Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close::after',
		],
		'mooseoom_use_btnclose_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for close button?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_btnclose_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Close Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close i',
		],
		'mooseoom_copyright'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Copyright', 'aheto' ),
			'default' => esc_html__( 'Put your text...', 'aheto' ),
		],

		'mooseoom_use_copyright_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for copyright?', 'aheto' ),
			'grid'    => 3,
		],
		'mooseoom_copyright_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Copyright Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__widget-box-copy',
		],
		'mooseoom_bg_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Background image', 'aheto' ),
		],
		'mooseoom_overlay'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Overlay Color', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .main-header__main-line::before' => 'background: {{VALUE}}'
			],
		],
	]);
}
function mooseoom_navigation_layout1_dynamic_css($css, $shortcode)
{

	if ($shortcode->atts['mooseoom_use_menu_typo'] && !empty($shortcode->atts['mooseoom_menu_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-menu li a'], $shortcode->parse_typography($shortcode->atts['mooseoom_menu_typo']));
	}

	if ( $shortcode->atts['mooseoom_use_submenu_typo'] && !empty($shortcode->atts['mooseoom_submenu_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-menu .sub-menu li a'], $shortcode->parse_typography($shortcode->atts['mooseoom_submenu_typo']));
	}

	if ( $shortcode->atts['mooseoom_use_mobmenutitle_typo'] && !empty($shortcode->atts['mooseoom_mobmenutitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['mooseoom_mobmenutitle_typo']));
	}

	if ( $shortcode->atts['mooseoom_use_mobmenutitle_typo'] && !empty($shortcode->atts['mooseoom_mobmenutitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close::after'], $shortcode->parse_typography($shortcode->atts['mooseoom_mobmenutitle_typo']));
	}

	if ( $shortcode->atts['mooseoom_use_btnclose_typo'] && !empty($shortcode->atts['mooseoom_btnclose_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close i'], $shortcode->parse_typography($shortcode->atts['mooseoom_btnclose_typo']));
	}

	if ( isset($shortcode->atts['mooseoom_use_copyright_typo']) && $shortcode->atts['mooseoom_use_copyright_typo'] && !empty($shortcode->atts['mooseoom_copyright_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__widget-box-copy'], $shortcode->parse_typography($shortcode->atts['mooseoom_copyright_typo']));
	}

	if ( isset($shortcode->atts['mooseoom_overlay'] ) && ! empty( $shortcode->atts['mooseoom_overlay'] ) ) {
		$css['global']['%1$s .main-header__main-line::before']['background'] = Sanitize::color( $this->atts['mooseoom_overlay'] );
	}

	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'mooseoom_navigation_layout1_dynamic_css', 10, 2);
