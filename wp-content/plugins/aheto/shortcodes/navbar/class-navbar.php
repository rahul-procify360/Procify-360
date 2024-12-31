<?php
/**
 * The Navbar Shortcode.
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
 * Navbar class.
 */
class Navbar extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'navbar';
		$this->title       = esc_html__( 'Navbar', 'aheto' );
		$this->icon        = 'fa fa-info';
		$this->description = esc_html__( 'Add navbar menu.', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/navbar/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Modern', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Simple', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);


		$this->add_dependecy( 'max_width', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'remove_borders', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'columns', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'left_links', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'right_links', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'left_hide_mobile', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'right_hide_mobile', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'use_links_typo', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'links_typo', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'use_socials_typo', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'socials_typo', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'transparent', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'bg_color', 'template', ['view', 'layout1', 'layout2'] );
		$this->add_dependecy( 'color_on_hover', 'template', ['view', 'layout1', 'layout2'] );

		$this->add_dependecy( 'label', 'type_link', ['custom', 'phone', 'email', 'text'] );
		$this->add_dependecy( 'phone', 'type_link', 'phone' );
		$this->add_dependecy( 'email', 'type_link', 'email' );
		$this->add_dependecy( 'add_icon', 'type_link', ['phone','email'] );
		$this->add_dependecy( 'type_icon', 'add_icon', 'true' );
		$this->add_dependecy( 'custom_link', 'type_link', 'custom' );
		$this->add_dependecy( 'font_icon', 'type_link', 'socials' );

		$this->add_dependecy('links_typo', 'use_links_typo', 'true');
		$this->add_dependecy('socials_typo', 'use_socials_typo', 'true');

		$this->add_dependecy( 'right_links', 'columns', 'two');
		$this->add_dependecy( 'right_hide_mobile', 'columns', 'two');

		$this->register();

	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'transparent'     => [
				'type'    => 'select',
				'heading' => esc_html__('Type of menu', 'aheto'),
				'options' => [
					''   => esc_html__('Default', 'aheto'),
					'transparent_dark' => esc_html__('Transparent with dark text', 'aheto'),
					'transparent_white' => esc_html__('Transparent with light text', 'aheto'),
				],
			],
			'columns'      => [
				'type'    => 'select',
				'heading' => esc_html__('Number of columns', 'aheto'),
				'options' => [
					'one' => esc_html__('One', 'aheto'),
					'two'   => esc_html__('Two', 'aheto'),
				],
			],
			'left_links' => [
				'type'    => 'group',
				'heading' => esc_html__( 'First column links', 'aheto' ),
				'params'  => [
					'type_link'      => [
						'type'    => 'select',
						'heading' => esc_html__('Type of link', 'aheto'),
						'options' => [
							'phone' => esc_html__('Phone', 'aheto'),
							'email'   => esc_html__('Email', 'aheto'),
							'custom'   => esc_html__('Custom link', 'aheto'),
							'text'   => esc_html__('Just text', 'aheto'),
							'socials'   => esc_html__('Social links', 'aheto'),
						],
					],
					'font_icon'      => [
						'type'    => 'select',
						'heading' => esc_html__('Icon library', 'aheto'),
						'options' => [
							'ionicons' => esc_html__('Ionicons', 'aheto'),
							'elegant'   => esc_html__('Elegant', 'aheto'),
						],
						'default' => 'ionicons',
					],
					'add_icon'        => [
						'type'    => 'switch',
						'heading' => esc_html__( 'Add icon before label?', 'aheto' ),
						'grid'    => 6,
						'default' => '',
					],
					'type_icon'      => [
						'type'    => 'select',
						'heading' => esc_html__('Type of icon', 'aheto'),
						'options' => [
							'' => esc_html__('Solid', 'aheto'),
							'-outline'   => esc_html__('Outline', 'aheto'),
						],
					],
					'label'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Label', 'aheto' ),
					],
					'phone'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Phone', 'aheto' ),
					],
					'email'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Email', 'aheto' ),
					],
					'custom_link'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Link', 'aheto' ),
					],
				],
			],
			'right_links' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Second column links', 'aheto' ),
				'params'  => [
					'type_link'      => [
						'type'    => 'select',
						'heading' => esc_html__('Type of link', 'aheto'),
						'options' => [
							'phone' => esc_html__('Phone', 'aheto'),
							'email'   => esc_html__('Email', 'aheto'),
							'custom'   => esc_html__('Custom link', 'aheto'),
							'text'   => esc_html__('Just text', 'aheto'),
							'socials'   => esc_html__('Social links', 'aheto'),
						],
					],
					'font_icon'      => [
						'type'    => 'select',
						'heading' => esc_html__('Icon library', 'aheto'),
						'options' => [
							'ionicons' => esc_html__('Ionicons', 'aheto'),
							'elegant'   => esc_html__('Elegant', 'aheto'),
						],
						'default' => 'ionicons',
					],
					'add_icon'        => [
						'type'    => 'switch',
						'heading' => esc_html__( 'Add icon before label?', 'aheto' ),
						'grid'    => 6,
						'default' => '',
					],
					'type_icon'      => [
						'type'    => 'select',
						'heading' => esc_html__('Type of icon', 'aheto'),
						'options' => [
							'' => esc_html__('Solid', 'aheto'),
							'-outline'   => esc_html__('Outline', 'aheto'),
						],
					],
					'label'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Label', 'aheto' ),
					],
					'phone'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Phone', 'aheto' ),
					],
					'email'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Email', 'aheto' ),
					],
					'custom_link'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Link', 'aheto' ),
					],
				],
			],
			'max_width'          => [
				'type'      => 'slider',
				'heading'   => esc_html__('Max width for navbar', 'aheto'),
				'grid'      => 12,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 3000,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .aheto-navbar--wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
			],
			'bg_color'          => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Background color for navbar', 'aheto'),
				'selectors' => [
					'{{WRAPPER}} .aheto-navbar' => 'background-color: {{VALUE}}',
				],
			],
			'color_on_hover'          => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Links color on hover', 'aheto'),
				'selectors' => [
					'{{WRAPPER}} .aheto-navbar--item-link:hover' => 'color: {{VALUE}} !important',
				],
			],
			'remove_borders'        => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Remove borders?', 'aheto' ),
				'grid'    => 12,
				'default' => '',
			],
			'left_hide_mobile'        => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Hide on mobile first column?', 'aheto' ),
				'grid'    => 6,
			],
			'right_hide_mobile'        => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Hide on mobile second column?', 'aheto' ),
				'grid'    => 6,
			],
			'use_links_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for links?', 'aheto' ),
				'grid'    => 6,
			],
			'use_socials_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for socials?', 'aheto' ),
				'grid'    => 6,
			],
			'links_typo'   => [
				'type'     => 'typography',
				'group'    => 'Links Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} .aheto-navbar--item, {{WRAPPER}} .aheto-navbar--item-label, {{WRAPPER}} .aheto-navbar--item-link',
			],
			'socials_typo'   => [
				'type'     => 'typography',
				'group'    => 'Socials Typography',
				'settings' => [
					'tag'        => false,
					'font_family' => false,
					'font_style' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-navbar--item-link.icon',
			],
			'advanced'      => true,
		];


		\Aheto\Params::add_networks_params($this, [
			'prefix' => 'right_links_',
			'dependency' => ['type_link', ['socials']]
		], 'right_links');

		\Aheto\Params::add_networks_params($this, [
			'prefix' => 'left_links_',
			'dependency' => ['type_link', ['socials']]
		], 'left_links');

	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['links_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-navbar--item, %1$s .aheto-navbar--item-label, %1$s .aheto-navbar--item-link'], $this->parse_typography( $this->atts['links_typo'] ) );
		}

		if ( ! empty( $this->atts['socials_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-navbar--item-link.icon'], $this->parse_typography( $this->atts['socials_typo'] ) );
		}

		if ( !empty($this->atts['bg_color']) ) {
			$css['global']['%1$s']['background-color'] = Sanitize::color($this->atts['bg_color']);
		}
		if ( !empty($this->atts['color_on_hover']) ) {
			$css['global']['%1$s .aheto-navbar--item-link:hover']['color'] = Sanitize::color($this->atts['color_on_hover']);
		}
		if ( ! empty( $this->atts['max_width'] ) ) {

			$css['global']['%1$s .aheto-navbar--wrap']['width'] = Sanitize::size( $this->atts['max_width'] );
		}

		return apply_filters( "aheto_navbar_dynamic_css", $css, $this );

	}


}
