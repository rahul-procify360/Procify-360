<?php
/**
 * The Menu Link Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Helper;
use Aheto\Shortcode;
use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Navigation class.
 */
class Navigation extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'navigation';
		$this->title       = esc_html__( 'Navigation', 'aheto' );
		$this->icon        = 'fa fa-bars';
		$this->description = esc_html__( 'Add WordPress menu.', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/navigation/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Footer Columns menu', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Footer Classic Inline Menu', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);
		$this->add_layout( 'layout3', [
			'title' => esc_html__( 'Header Modern menu', 'aheto' ),
			'image' => $dir . 'layout3.jpg',
		]);
		$this->add_layout( 'layout4', [
			'title' => esc_html__( 'Header Creative menu', 'aheto' ),
			'image' => $dir . 'layout4.jpg',
		]);
		$this->add_layout( 'layout5', [
			'title' => esc_html__( 'Header Classic menu', 'aheto' ),
			'image' => $dir . 'layout5.jpg',
		]);
		$this->add_layout( 'layout8', [
			'title' => esc_html__( 'Header Classic 2 menu', 'aheto' ),
			'image' => $dir . 'layout8.jpg',
		]);
		$this->add_layout( 'layout6', [
			'title' => esc_html__( 'Header Grid menu', 'aheto' ),
			'image' => $dir . 'layout6.jpg',
		]);
		$this->add_layout( 'layout7', [
			'title' => esc_html__( 'Header Simple menu', 'aheto' ),
			'image' => $dir . 'layout7.jpg',
		]);


		$this->add_dependecy( 'title', 'template', [ 'layout1', 'view' ] );
		$this->add_dependecy( 'title_space', 'template', [ 'layout1', 'view' ] );
		$this->add_dependecy( 'list_space', 'template', [ 'layout1', 'view' ] );
		$this->add_dependecy( 'columns', 'template', [ 'layout1', 'view' ]);
		$this->add_dependecy( 'text_typo', 'template', [ 'layout1', 'view' ]);
		$this->add_dependecy( 'menu_align', 'template', [ 'layout2' ] );
		$this->add_dependecy( 'underline', 'template', [ 'layout1', 'view' ] );
		$this->add_dependecy( 'linkscolor', 'template', [ 'layout1', 'view', 'layout2' ] );
		$this->add_dependecy( 'hovercolor', 'template', [ 'layout1', 'view', 'layout2' ] );
		$this->add_dependecy( 'max_width', 'template', [ 'layout3', 'layout5', 'layout7', 'layout8' ] );
		$this->add_dependecy( 'lang_switcher', 'template', [ 'layout3', 'layout4'] );
		$this->add_dependecy( 'search', 'template', [ 'layout3', 'layout4', 'layout7'] );
		$this->add_dependecy( 'mini_cart', 'template', [ 'layout3', 'layout4'] );
		$this->add_dependecy( 'type_logo', 'template', [ 'layout3', 'layout4', 'layout5', 'layout6', 'layout7', 'layout8' ] );
		$this->add_dependecy( 'address', 'template', [ 'layout4'] );
		$this->add_dependecy( 'time_schedule', 'template', [ 'layout4'] );
		$this->add_dependecy( 'phone', 'template', [ 'layout4'] );
		$this->add_dependecy( 'mob_logo', 'template', [ 'layout3', 'layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'networks', 'template', [ 'layout6'] );
		$this->add_dependecy( 'label_logo', 'template', [ 'layout6'] );
		$this->add_dependecy( 'transparent', 'template', [ 'layout3', 'layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'add_scroll_logo', 'template', [ 'layout3','layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'add_mob_scroll_logo', 'template', [ 'layout3','layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'change_link_logo', 'template', [ 'layout5'] );
		$this->add_dependecy( 'link_logo', 'template', [ 'layout5'] );
		$this->add_dependecy( 'link_logo', 'change_link_logo', 'true' );
		$this->add_dependecy( 'aheto_count_images_col', 'template', 'layout3' );
		$this->add_dependecy( 'submenu_creative', 'template', 'layout3' );

		$this->add_dependecy( 'use_mob_menu_title_typo', 'template', [ 'layout3','layout4','layout5','layout6','layout7','layout8'] );
		$this->add_dependecy( 'mob_menu_title_typo', 'template', [ 'layout3','layout4','layout5','layout6','layout7','layout8'] );
		$this->add_dependecy( 'mob_menu_title_typo', 'use_mob_menu_title_typo', 'true' );
		$this->add_dependecy( 'use_mega_menu_title_typo', 'template', [ 'layout8'] );
		$this->add_dependecy( 'mega_menu_title_typo', 'template', [ 'layout8'] );
		$this->add_dependecy( 'mega_menu_title_typo', 'use_mega_menu_title_typo', 'true' );
		$this->add_dependecy( 'use_m_link_typo', 'template', [ 'layout3'] );
		$this->add_dependecy( 'm_link_typo', 'template',  [ 'layout3'] );
		$this->add_dependecy( 'm_link_typo', 'use_m_link_typo', 'true' );
		$this->add_dependecy( 'use_menu_link_typo', 'template', [ 'layout1', 'layout2', 'layout8'] );
		$this->add_dependecy( 'menu_link_typo', 'template', ['layout1', 'layout2', 'layout8'] );
		$this->add_dependecy( 'menu_link_typo', 'use_menu_link_typo', 'true' );
		$this->add_dependecy( 'use_logo_typo', 'template', [ 'layout8'] );
		$this->add_dependecy( 'logo_typo', 'template', [ 'layout8'] );
		$this->add_dependecy( 'logo_typo', 'use_logo_typo', 'true' );


		$this->add_dependecy( 'logo', 'template', [ 'layout3', 'layout4', 'layout5', 'layout6', 'layout7', 'layout8' ] );
		$this->add_dependecy( 'logo', 'type_logo', 'image' );
		$this->add_dependecy( 'text_logo', 'template', [ 'layout3', 'layout4', 'layout5', 'layout6', 'layout7', 'layout8' ] );
		$this->add_dependecy( 'text_logo', 'type_logo', 'text' );
		$this->add_dependecy( 'scroll_logo', 'template', [ 'layout3','layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'scroll_logo', 'add_scroll_logo', 'true' );
		$this->add_dependecy( 'scroll_mob_logo', 'template', [ 'layout3','layout5', 'layout6', 'layout7', 'layout8'] );
		$this->add_dependecy( 'scroll_mob_logo', 'add_mob_scroll_logo', 'true' );

		$this->add_dependecy( 'hover_color_links', 'template', [ 'view', 'layout4' ] );

		$this->add_dependecy( 'mobile_menu_width', 'template', ['layout3','layout4','layout5','layout6','layout7', 'layout8' ] );

		$this->add_dependecy( 'demo_use_navmenu_typo', 'template', ['layout3', 'layout5', 'layout8'] );
		$this->add_dependecy( 'demo_navmenu_typo', 'template', ['layout3', 'layout5', 'layout8'] );
		$this->add_dependecy( 'demo_navmenu_typo', 'demo_use_navmenu_typo', 'true' );

		$this->register();

	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'title'         => [
				'type'    => 'text',
				'heading' => esc_html__( 'Title', 'aheto' ),
			],
			'text_typo'   => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .widget-nav-menu__title',
			],
			'underline'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 6,
			],
			'title_space'    => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__( 'Margin spaces for title', 'aheto' ),
				'grid'      => 12,
				'selectors' => [
					'{{WRAPPER}} .widget-nav-menu__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'list_space'    => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__( 'Margin spaces for list items', 'aheto' ),
				'grid'      => 12,
				'selectors' => [
					'{{WRAPPER}} .widget-nav-menu__menu li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'menus'         => [
				'type'    => 'select',
				'heading' => esc_html__( 'Menu', 'aheto' ),
				'options' => Helper::choices_nav_menu(),
			],
			'columns'      => [
				'type'    => 'select',
				'heading' => esc_html__('Number of columns', 'aheto'),
				'options' => [
					'one' => esc_html__('One', 'aheto'),
					'two'   => esc_html__('Two', 'aheto'),
				],
			],
			'menu_align'      => [
				'type'    => 'select',
				'heading' => esc_html__('Menu align', 'aheto'),
				'options' => [
					'left'   => esc_html__('Left', 'aheto'),
					'right' => esc_html__('Right', 'aheto'),
					'center' => esc_html__('Center', 'aheto'),
					'justify' => esc_html__('Justify', 'aheto'),
				],
			],
			'linkscolor'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Links color', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} ul.widget-nav-menu__menu li a' => 'color: {{VALUE}}' ],
			],
			'hovercolor'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Links color on hover', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} ul.widget-nav-menu__menu li a:hover' => 'color: {{VALUE}}' ],
			],
			'transparent'     => [
				'type'    => 'select',
				'heading' => esc_html__('Type of menu', 'aheto'),
				'options' => [
					''   => esc_html__('Default', 'aheto'),
					'transparent_dark' => esc_html__('Transparent with dark text', 'aheto'),
					'transparent_white' => esc_html__('Transparent with light text', 'aheto'),
				],
			],
			'type_logo'      => [
				'type'    => 'select',
				'heading' => esc_html__('Type of logo', 'aheto'),
				'options' => [
					'image'   => esc_html__('Image', 'aheto'),
					'text' => esc_html__('Text', 'aheto'),
				],
			],
			'change_link_logo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Change link for logo?', 'aheto' ),
				'default' => ''
			],
			'link_logo'         => [
				'type'    => 'text',
				'heading' => esc_html__( 'Link for logo', 'aheto' ),
			],
			'logo'          => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Logo', 'aheto' ),
			],
			'add_scroll_logo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Add another logo for scroll?', 'aheto' ),
				'default' => ''
			],
			'scroll_logo'          => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Logo on Scroll', 'aheto' ),
				'description' => esc_html__( 'Only for fixed header.', 'aheto' ),
			],
			'mob_logo'          => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Mobile Logo', 'aheto' ),
			],
			'add_mob_scroll_logo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Add another mobile logo for scroll?', 'aheto' ),
				'default' => ''
			],
			'scroll_mob_logo'          => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Mobile scroll Logo', 'aheto' ),
				'description' => esc_html__( 'Only for fixed header.', 'aheto' ),
			],
			'text_logo'          => [
				'type'    => 'text',
				'heading' => esc_html__( 'Logo', 'aheto' ),
			],
			'label_logo'          => [
				'type'    => 'text',
				'heading' => esc_html__( 'Label for Logo', 'aheto' ),
			],
			'lang_switcher' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Language Switcher', 'aheto' ),
			],
			'search'        => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Searchbox', 'aheto' ),
			],
			'mini_cart'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Shopping Cart', 'aheto' ),
			],
			'address'     => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Address', 'aheto' ),
			],
			'time_schedule'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Time schedule', 'aheto' ),
			],
			'phone'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Phone', 'aheto' ),
			],
			'max_width'          => [
				'type'      => 'slider',
				'heading'   => esc_html__('Max width for menu', 'aheto'),
				'grid'      => 12,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 3000,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .main-header__main-line' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			],
			'networks' => true,
			'use_mob_menu_title_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Mobile menu title?', 'aheto' ),
				'grid'    => 3,
			],
			'mob_menu_title_typo' => [
				'type'     => 'typography',
				'group'    => 'Mobile menu title Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__menu-box .mobile-menu-title',
			],
			'use_mega_menu_title_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Mega menu title?', 'aheto' ),
				'grid'    => 3,
			],
			'mega_menu_title_typo' => [
				'type'     => 'typography',
				'group'    => 'Mega menu title Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>.menu-item--mega-menu .mega-menu__title, {{WRAPPER}} .main-header__menu-box>ul>.menu-item--mega-menu .mega-menu__title',
			],
			'use_menu_link_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Menu links?', 'aheto' ),
				'grid'    => 3,
			],
			'menu_link_typo' => [
				'type'     => 'typography',
				'group'    => 'Menu links Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu li a, {{WRAPPER}} .main-header__menu-box>ul li a, {{WRAPPER}} .widget-nav-menu--classic-inline li a,{{WRAPPER}} .widget-nav-menu__menu li a',
			],
			'use_m_link_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Menu links?', 'aheto' ),
				'grid'    => 3,
			],
			'm_link_typo' => [
				'type'     => 'typography',
				'group'    => 'Menu links Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>li>a',
			],
			'use_logo_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Logo?', 'aheto' ),
				'grid'    => 3,
			],
			'logo_typo' => [
				'type'     => 'typography',
				'group'    => 'Logo Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__logo span',
			],
			'advanced'      => true,

			'hover_color_links'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Hover color for menu links', 'aheto'),
				'selectors' => ['{{WRAPPER}} .main-header__menu-box .main-menu>li:hover>a' => 'color: {{VALUE}};'],
			],
			'mobile_menu_width' => [
				'type'      => 'slider',
				'heading'   => esc_html__('Breakpoint for mobile menu', 'aheto'),
				'grid'      => 4,
				'range'     => [
					'px' => [
						'min'  => 320,
						'max'  => 1199,
						'step' => 5,
					],
				],
			],

			'demo_use_navmenu_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for submenu items with images?', 'deva' ),
				'grid'    => 3,
				'label_block'  => true,
			],

			'demo_navmenu_typo'     => [
				'type'     => 'typography',
				'group'    => 'Submenu with Images Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .main-header__main-line .main-header__pages-list li a',
			],

			'aheto_count_images_col'         => [
				'type'    => 'slider',
				'heading' => esc_html__( 'Columns in megamenu with images', 'aheto' ),
				'description' => esc_html__( 'Columns count in megamenu with images (only number)', 'aheto' ),
				'admin_label' => true,
				'grid' => 6,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .main-header__menu-box .main-menu .main-header__pages-list li, {{WRAPPER}} .main-header__menu-box>ul .main-header__pages-list li' => 'width: calc(100% / {{SIZE}})' ]
			],

			'submenu_creative' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable creative submenu style?', 'aheto' ),
				'grid'    => 3,
			],

		];


		\Aheto\Params::add_icon_params( $this, [
			'add_icon'  => true,
			'add_label' => esc_html__( 'Add address icon?', 'aheto' ),
			'prefix'    => 'address_',
			'dependency' => ['template', 'layout4']
		]);

		\Aheto\Params::add_icon_params( $this, [
			'add_icon'  => true,
			'add_label' => esc_html__( 'Add time schedule icon?', 'aheto' ),
			'prefix'    => 'time_schedule_',
			'dependency' => ['template', 'layout4']
		]);

		\Aheto\Params::add_icon_params( $this, [
			'add_icon'  => true,
			'add_label' => esc_html__( 'Add phone icon?', 'aheto' ),
			'prefix'    => 'phone_',
			'dependency' => ['template', 'layout4']
		]);

		$desc_button_layouts = ['layout5', 'layout7', 'layout8'];
		$desc_button_layouts = apply_filters( "aheto_nav_desc_button_layouts",  $desc_button_layouts );
		\Aheto\Params::add_button_params($this, [
			'prefix' => 'main_',
			'group'   => 'Desktop buttons',
			'icons'      => true,
			'dependency' => ['template', $desc_button_layouts]
		]);

		\Aheto\Params::add_button_params($this, [
			'add_label' => esc_html__('Add additional button?', 'aheto'),
			'prefix'    => 'add_',
			'group'   => 'Desktop buttons',
			'icons'      => true,
			'dependency' => ['template', 'layout5']
		]);

		$mob_button_layouts = ['layout5', 'layout7', 'layout8'];
		$mob_button_layouts = apply_filters( "aheto_nav_mob_button_layouts",  $mob_button_layouts );
		\Aheto\Params::add_button_params($this, [
			'prefix' => 'main_mob_',
			'group'   => 'Mobile Buttons',
			'icons'      => true,
			'dependency' => ['template', $mob_button_layouts]
		]);

		\Aheto\Params::add_button_params($this, [
			'add_label' => esc_html__('Add additional button?', 'aheto'),
			'prefix'    => 'add_mob_',
			'group'   => 'Mobile Buttons',
			'icons'      => true,
			'dependency' => ['template', 'layout5']
		]);


	}



	/**
	 * Print wpml language switcher.
	 */
	public function the_wpml_lang_switcher() {
		if ( ! $this->atts['lang_switcher'] || ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return;
		}

		$layout = 'template';

		$layouts_translated_name = ['layout3'];

		$language_name = in_array( $this->atts[$layout] , $layouts_translated_name ) ? true : false;


		$active = '';
		$submenu = '';
		foreach ( icl_get_languages( 'skip_missing=0' ) as $language_key => $args ) {
			if ( $args['active'] && $language_name ) {
				$active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native">%3$s <i class="icon ion-chevron-down"></i></span></a>',
					$args['country_flag_url'],
					$args['language_code'],
					$args['translated_name']
				);
				continue;

			}
			elseif( $args['active'] ){

				$active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native">%2$s <i class="icon ion-chevron-down"></i></span></a>',
					$args['country_flag_url'],
					$args['language_code'],
					$args['translated_name']
				);
				continue;
			}


			$submenu .= sprintf(
				'<li class="wpml-ls-slot-sidebar-1 wpml-ls-item wpml-ls-item-de">
				<a href="%1$s">
					<img class="wpml-ls-flag" src="%2$s" alt="%3$s" title="%4$s">
					<span class="wpml-ls-native">%4$s</span>
				</a>
			</li>',
				$args['url'],
				$args['country_flag_url'],
				$args['language_code'],
				$args['translated_name']
			);

		}

		$html  = '<div class="wpml-ls-sidebars-sidebar-1 wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown"><ul class="multi-lang">';
		$html .= '<li tabindex="0" class="wpml-ls-slot-sidebar-1 wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-dropdown">';
		$html .= $active;
		if ( ! empty( $submenu ) ) {
			$html .= '<ul class="wpml-ls-sub-menu js-lang-list">';
			$html .= $submenu;
			$html .= '</ul>';
		}
		$html .= '</li></ul></div>';

		echo $html;
	}


	/**
	 * Get icon template-wise
	 *
	 * @param  string $icon Icon required.
	 * @return string
	 */
	public function get_icon_for( $icon ) {
		$key  = $icon . '_';

		$icon = $this->get_icon_attributes( $key, true, true );

		if ( ! empty( $icon ) ) {
			$this->add_render_attribute( $key . 'icon', 'class', 'widget_aheto__icon' );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['icon'] );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['align'] );
			if ( ! empty( $icon['color'] ) ) {
				$this->add_render_attribute( $key . 'icon', 'style', 'color:' . $icon['color'] );
			}
			if ( ! empty( $icon['font_size'] ) ) {
				$this->add_render_attribute( $key . 'icon', 'style', 'font-size:' . $icon['font_size'] );
			}
		}

		return ! empty( $icon ) ? '<i ' . $this->get_render_attribute_string( $key . 'icon' ) . '></i>' : '';
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if (isset($this->atts['hover_color_links']) && !empty($this->atts['hover_color_links'])) {
			$css['global']['%1$s .main-header__menu-box .main-menu>li:hover>a']['color'] = \Aheto\Sanitize::color($this->atts['hover_color_links']);
		}

		if ( !empty($this->atts['title_space']) ) {

			$selector                   = '%1$s .widget-nav-menu__title';
			$this->atts['title_space'] = Sanitize::responsive_spacing($this->atts['title_space'], 'margin');


			if ( !empty($this->atts['title_space']['desktop']) ) {
				\aheto_add_props($css['global'][$selector], $this->atts['title_space']['desktop']);
			}

			if ( !empty($this->atts['title_space']['laptop']) ) {
				\aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['title_space']['laptop']);
			}

			if ( !empty($this->atts['title_space']['tablet']) ) {
				\aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['title_space']['tablet']);
			}

			if ( !empty($this->atts['title_space']['mobile']) ) {
				\aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['title_space']['mobile']);
			}
		}

		if ( !empty($this->atts['list_space']) ) {

			$selector                   = '%1$s .widget-nav-menu__menu li';
			$this->atts['list_space'] = Sanitize::responsive_spacing($this->atts['list_space'], 'margin');


			if ( !empty($this->atts['list_space']['desktop']) ) {
				\aheto_add_props($css['global'][$selector], $this->atts['list_space']['desktop']);
			}

			if ( !empty($this->atts['list_space']['laptop']) ) {
				\aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['list_space']['laptop']);
			}

			if ( !empty($this->atts['list_space']['tablet']) ) {
				\aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['list_space']['tablet']);
			}

			if ( !empty($this->atts['list_space']['mobile']) ) {
				\aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['list_space']['mobile']);
			}
		}



		if ( ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget-nav-menu__title'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		if ( ! empty( $this->atts['hovercolor'] ) ) {
			$css['global']['%1$s ul.widget-nav-menu__menu li a:hover']['color'] = Sanitize::color( $this->atts['hovercolor'] );
		}
		if ( ! empty( $this->atts['linkscolor'] ) ) {
			$css['global']['%1$s ul.widget-nav-menu__menu li a']['color'] = Sanitize::color( $this->atts['linkscolor'] );
		}

		if ( ! empty( $this->atts['max_width'] ) ) {
			$css['global']['%1$s .main-header__main-line']['max-width'] = Sanitize::size( $this->atts['max_width'] );
		}




		if ( ! empty( $this->atts['use_menu_link_typo'] ) && ! empty( $this->atts['menu_link_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu li a, %1$s .main-header__menu-box>ul li a'], $this->parse_typography( $this->atts['menu_link_typo'] ) );
		}
		if ( ! empty( $this->atts['use_mob_menu_title_typo'] ) && ! empty( $this->atts['mob_menu_title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .main-header__menu-box .mobile-menu-title'], $this->parse_typography( $this->atts['mob_menu_title_typo'] ) );
		}
		if ( ! empty( $this->atts['use_logo_typo'] ) && ! empty( $this->atts['logo_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .main-header__logo span'], $this->parse_typography( $this->atts['logo_typo'] ) );
		}
		if ( ! empty( $this->atts['use_mega_menu_title_typo'] ) && ! empty( $this->atts['mega_menu_title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu>.menu-item--mega-menu .mega-menu__title, %1$s .main-header__menu-box>ul>.menu-item--mega-menu .mega-menu__title'], $this->parse_typography( $this->atts['mega_menu_title_typo'] ) );
		}



		return apply_filters( "aheto_navigation_dynamic_css", $css, $this );
	}

}
