<?php
/**
 * The Features Shortcode.
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
 * Features class.
 */
class Features_Tabs extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'features-tabs';
		$this->title          = esc_html__('Features Tabs', 'aheto');
		$this->icon           = 'fa fa-table';
		$this->description    = esc_html__('Add features tabs', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/features-tabs/previews/';

		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);


		$this->add_dependecy('tabs', 'template', ['view','layout1']);
		$this->add_dependecy('use_heading', 'template', ['view','layout1']);
		$this->add_dependecy('use_title', 'template', ['view','layout1']);
		$this->add_dependecy('use_description', 'template', ['view','layout1']);
		$this->add_dependecy('t_heading', 'template', ['view','layout1']);

		$this->add_dependecy('t_title', 'template', ['view','layout1']);
		$this->add_dependecy('t_title', 'use_title', 'true');

		$this->add_dependecy('t_heading', 'template', ['view','layout1']);
		$this->add_dependecy('t_heading', 'use_heading', 'true');

		$this->add_dependecy('t_description', 'template', ['view','layout1']);
		$this->add_dependecy('t_description', 'use_description', 'true');

		$this->register();
	}


	/**
	 * Set shortcode params
	 */
	public function set_params() {



		$this->add_params([
			'tabs'        => [
				'type'    => 'group',
				'heading' => esc_html__('Features Tabs', 'aheto'),
				'params'  => [
					'icon'        => [
						'type'    => 'select',
						'heading' => esc_html__('Icon', 'aheto'),
						'options' => Helper::choices_icons(),
						'description' => esc_html__('For this icons you need to choose Themify icons library in General Settings.', 'aheto'),
					],
					'main_heading'     => [
						'type'    => 'text',
						'heading' => esc_html__('Main Heading', 'aheto'),
					],
					'reverse'    => [
						'type'    => 'switch',
						'heading' => esc_html__( 'Reverse content?', 'aheto' ),
					],
					'title'     => [
						'type'    => 'text',
						'heading' => esc_html__('Content Title', 'aheto'),
						'grid'    => 8,
					],
					'title_tag' => [
						'type'    => 'select',
						'heading' => esc_html__('Content Title tag', 'aheto'),
						'options' => [
							'h1'  => 'h1',
							'h2'  => 'h2',
							'h3'  => 'h3',
							'h4'  => 'h4',
							'h5'  => 'h5',
							'h6'  => 'h6',
							'p'   => 'p',
							'div' => 'div',
						],
						'default' => 'h1',
						'grid'    => 2,
					],
					'description' => [
						'type'    => 'textarea',
						'heading' => esc_html__('Description', 'aheto'),
					],
					'image'         => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Image', 'aheto'),
					],
				],
			],
			'use_heading'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for main heading?', 'aheto'),
				'grid'    => 4,
			],
			'use_title'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for content title?', 'aheto'),
				'grid'    => 4,
			],
			'use_description' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for description?', 'aheto'),
				'grid'    => 4,
			],
			't_heading'     => [
				'type'     => 'typography',
				'group'    => 'Main Heading Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-features-tabs__list-link',
			],
			't_title'     => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-features-tabs__box-title',
			],
			't_description' => [
				'type'     => 'typography',
				'group'    => 'Description Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-features-tabs__box-description',
			],
			'advanced'      => true,

		]);


		\Aheto\Params::add_button_params($this, [
			'prefix' => 'main_',
		], 'tabs');

		\Aheto\Params::add_button_params($this, [
			'add_label' => esc_html__('Add additional button?', 'aheto'),
			'prefix'    => 'add_',
		], 'tabs');


		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view','layout1']]
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
		if ( !empty($this->atts['use_heading']) && !empty($this->atts['t_heading']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-features-tabs__list-title'], $this->parse_typography($this->atts['t_heading']));
		}

		if ( !empty($this->atts['use_title']) && !empty($this->atts['t_title']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-title'], $this->parse_typography($this->atts['t_title']));
		}

		if ( !empty($this->atts['use_description']) && !empty($this->atts['t_description']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-description'], $this->parse_typography($this->atts['t_description']));
		}

		return apply_filters( "aheto_features_tabs_dynamic_css", $css, $this );
	}

}
