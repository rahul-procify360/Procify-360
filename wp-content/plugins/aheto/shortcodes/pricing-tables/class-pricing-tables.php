<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Helper;
use Aheto\Shortcode;

defined('ABSPATH') || exit;

/**
 * Pricing_Tables class.
 */
class Pricing_Tables extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'pricing-tables';
		$this->title          = esc_html__('Pricing Tables', 'aheto');
		$this->icon           = 'fa fa-money';
		$this->description    = esc_html__('Add pricing tables', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/pricing-tables/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);
		$this->add_layout('layout3', [
			'title' => esc_html__('Side Feature', 'aheto'),
			'image' => $dir . 'layout3.jpg',
		]);
		$this->add_layout('layout4', [
			'title' => esc_html__('Side Head', 'aheto'),
			'image' => $dir . 'layout4.jpg',
		]);

		// Dependency.
		$this->add_dependecy('heading', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('features_align', 'template', ['layout2']);
		$this->add_dependecy('link', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_style', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('tag', 'template', ['view', 'layout1']);
		$this->add_dependecy('description', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('features', 'template', ['layout2', 'layout4']);
		$this->add_dependecy('features_with_name', 'template', ['layout3']);
		$this->add_dependecy('price', 'template', ['view', 'layout1', 'layout2', 'layout3']);
		$this->add_dependecy('link_url', 'template', ['view', 'layout1', 'layout2', 'layout3']);
		$this->add_dependecy('link_title', 'template', ['view', 'layout1', 'layout2', 'layout3']);

		$this->add_dependecy('link_color', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_color', 'link_style', 'true');
		$this->add_dependecy('link_color_hover', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_color_hover', 'link_style', 'true');
		$this->add_dependecy('link_bg', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_bg', 'link_style', 'true');
		$this->add_dependecy('link_bg_hover', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_bg_hover', 'link_style', 'true');
		$this->add_dependecy('link_border', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_border', 'link_style', 'true');
		$this->add_dependecy('link_border_hover', 'template', ['view', 'layout1','layout2','layout3','layout4']);
		$this->add_dependecy('link_border_hover', 'link_style', 'true');
		$this->add_dependecy('aheto_use_price_typo', 'template', ['layout2', 'layout3']);
		$this->add_dependecy('aheto_price_typo', 'template', ['layout2', 'layout3']);
		$this->add_dependecy('aheto_price_typo', 'aheto_use_price_typo', 'true');
		$this->add_dependecy('aheto_item_br', 'template', ['layout2']);

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'heading'           => [
				'type'        => 'text',
				'heading'     => esc_html__('Heading', 'aheto'),
				'admin_label' => true,
			],
			'price'             => [
				'type'    => 'text',
				'heading' => esc_html__('Price', 'aheto'),
			],
			'description'       => [
				'type'    => 'textarea',
				'heading' => esc_html__('Description', 'aheto'),
			],
			'tag'               => [
				'type'    => 'text',
				'heading' => esc_html__('Tag Line', 'aheto'),
			],
			'features'          => [
				'type'    => 'group',
				'heading' => esc_html__('Features', 'aheto'),
				'params'  => [
					'feature' => [
						'type'    => 'text',
						'heading' => esc_html__('Feature', 'aheto'),
					],
				],
			],
			'features_align'    => [
				'type'     => 'select',
				'heading'  => esc_html__( 'Features align for mobile', 'aheto' ),
				'options'  => [
					'left' => esc_html__( 'Left', 'aheto' ),
					'center'       => esc_html__( 'Center', 'aheto' ),
					'right' => esc_html__( 'Right', 'aheto' ),
				],
				'grid'     => 12,
			],
			'features_with_name'          => [
				'type'    => 'group',
				'heading' => esc_html__('Features', 'aheto'),
				'params'  => [
					'feature_name' => [
						'type'    => 'text',
						'heading' => esc_html__('Feature name', 'aheto'),
					],
					'feature' => [
						'type'    => 'text',
						'heading' => esc_html__('Feature', 'aheto'),
						'description' => esc_html__('Enter only [ok] for output check-mark.', 'aheto'),
					],
				],
			],
			'link'              => [
				'global' => 'button',
				'prefix' => 'link',
			],
			'link_style'        => [
				'type'    => 'switch',
				'heading' => esc_html__('Change default settings for link', 'aheto'),
				'group'   => esc_html__('Link', 'aheto'),
			],
			'link_color'        => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link color', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-btn' => 'color: {{VALUE}}'],
			],
			'link_color_hover'  => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link color on hover', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-pricing:hover .aheto-btn' => 'color: {{VALUE}}'],
			],
			'link_bg'           => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link background color', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-btn' => 'background-color: {{VALUE}}'],
			],
			'link_bg_hover'     => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link background color on hover', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-pricing:hover .aheto-btn' => 'background-color: {{VALUE}}'],
			],
			'link_border'       => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link border', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-btn' => 'border-color: {{VALUE}}'],
			],
			'link_border_hover' => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Link border on hover', 'aheto'),
				'grid'      => 6,
				'group'     => esc_html__('Link', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aheto-pricing:hover .aheto-btn' => 'border-color: {{VALUE}}'],
			],
			'aheto_use_price_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for price?', 'aheto' ),
				'grid'    => 3,
			],

			'aheto_price_typo' => [
				'type'     => 'typography',
				'group'    => 'Price Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-pricing__cost',
			],
			'aheto_item_br' => [
				'type' => 'slider',
				'heading' => esc_html__('Item border radius', 'aheto'),
				'grid' => 6,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .aheto-pricing--alternative' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			],
		]);

		$icon_params = array(
			'add_icon' => true,
			'exclude'  => ['align'],
			'group'    => esc_html__('Icon', 'aheto'),
			'dependency' => ['template', ['view', 'layout1']]
		);

		$icon_params = apply_filters( "aheto_pricing_tables_icon_params",  $icon_params );

		\Aheto\Params::add_icon_params($this, $icon_params);

		$this->add_params([
			'advanced' => true,
		]);
	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( !empty($this->atts['link_style']) ) {
			if ( !empty($this->atts['link_color']) ) {
				$css['global']['%1$s .aheto-btn']['color'] = \Aheto\Sanitize::color($this->atts['link_color']);
			}

			if ( !empty($this->atts['link_color_hover']) ) {
				$css['global']['%1$s .aheto-pricing:hover .aheto-btn']['color'] = \Aheto\Sanitize::color($this->atts['link_color_hover']);
			}

			if ( !empty($this->atts['link_bg']) ) {
				$css['global']['%1$s .aheto-btn']['background-color'] = \Aheto\Sanitize::color($this->atts['link_bg']);
			}

			if ( !empty($this->atts['link_bg_hover']) ) {
				$css['global']['%1$s .aheto-pricing:hover .aheto-btn']['background-color'] = \Aheto\Sanitize::color($this->atts['link_bg_hover']);
			}

			if ( !empty($this->atts['link_border']) ) {
				$css['global']['%1$s .aheto-btn']['border-color'] = \Aheto\Sanitize::color($this->atts['link_border']);
			}

			if ( !empty($this->atts['link_border_hover']) ) {
				$css['global']['%1$s .aheto-pricing:hover .aheto-btn']['border-color'] = \Aheto\Sanitize::color($this->atts['link_border_hover']);
			}
		}


		return apply_filters( "aheto_pricing_tables_dynamic_css", $css, $this );
	}
}
