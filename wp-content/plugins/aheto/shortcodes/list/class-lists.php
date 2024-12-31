<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Sanitize;
use Aheto\Shortcode;

defined('ABSPATH') || exit;

/**
 * List class.
 */
class Lists extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'list';
		$this->title          = esc_html__('Lists', 'aheto');
		$this->icon           = 'fa fa-list-ol';
		$this->description    = esc_html__('Add lists', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/list/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Bullet List', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Number List', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		// Dependency.
		$this->add_dependecy('lists', 'template', ['view', 'layout1']);
		$this->add_dependecy('size_bullet', 'template', ['view', 'layout1']);
		$this->add_dependecy('heading', 'template', 'layout2');
		$this->add_dependecy('text_tag', 'template', 'layout2');
		$this->add_dependecy('description', 'template', 'layout2');
		$this->add_dependecy('index', 'template', 'layout2');
		$this->add_dependecy('color', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('use_list_typo', 'template', ['view','layout1']);
		$this->add_dependecy('list_typo', 'template', ['view','layout1']);
		$this->add_dependecy('list_typo', 'use_list_typo', 'true');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'lists'       => [
				'type'    => 'group',
				'heading' => esc_html__('Lists', 'aheto'),
				'params'  => [
					'list' => [
						'type'    => 'text',
						'heading' => esc_html__('List', 'aheto'),
					],
				],
			],
			'heading'     => [
				'type'    => 'text',
				'heading' => esc_html__('Title', 'aheto'),
				'default' => esc_html__('Discussion of the Idea', 'aheto'),
				'grid'    => 7,
			],
			'text_tag'    => [
				'type'    => 'select',
				'heading' => esc_html__('Element tag for title', 'aheto'),
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
				'default' => 'h5',
				'grid'    => 5,
			],
			'description' => [
				'type'    => 'textarea',
				'heading' => esc_html__('Description', 'aheto'),
				'default' => esc_html__('Arden offers you with fresh and vivid appearance. Your website will stand out with high flexibility in customization.', 'aheto'),
			],
			'index'       => [
				'type'    => 'text',
				'heading' => esc_html__('Index Counter', 'aheto'),
				'default' => '01.',
			],
			'size_bullet' => [
				'type' => 'slider',
				'heading' => esc_html__('Bullets size', 'aheto'),
				'group' => esc_html__('Content', 'aheto'),
				'grid' => 6,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} li::before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			],
			'color'       => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Color Bullet', 'aheto'),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-list--bullets li::before'         => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .aheto-list--number[data-index]::before' => 'color: {{VALUE}}',
				],
			],
			'use_list_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for list?', 'aheto'),
				'grid'    => 3,
			],
			'list_typo'     => [
				'type'     => 'typography',
				'group'    => 'List Typography',
				'settings' => [
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-list--bullets li',
			],
			'advanced'    => true,
		];
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( !empty($this->atts['color']) ) {
			$color                                                                     = Sanitize::color($this->atts['color']);
			$css['global']['%1$s .aheto-list--number[data-index]::before']['color']    = $color;
			$css['global']['%1$s .aheto-list--bullets li::before']['background-color'] = $color;
		}
		if ( !empty($this->atts['use_list_typo']) && !empty($this->atts['list_typo']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-list--bullets li'], $this->parse_typography($this->atts['list_typo']));
		}
		return apply_filters( "aheto_lists_dynamic_css", $css, $this );
	}
}
