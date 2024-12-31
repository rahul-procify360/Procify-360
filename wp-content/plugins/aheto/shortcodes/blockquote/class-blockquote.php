<?php
/**
 * The Blockquote Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Helper;
use Aheto\Sanitize;

defined('ABSPATH') || exit;

/**
 * Button class.
 */
class Blockquote extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'blockquote';
		$this->title          = esc_html__('Blockquote', 'aheto');
		$this->icon           = 'fa fa-quote-right';
		$this->description    = esc_html__('Add blockquote', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/blockquote/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Default', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);


		$this->add_dependecy('align', 'template', ['layout1', 'view']);
		$this->add_dependecy('quote', 'template', ['layout1', 'view']);
		$this->add_dependecy('author', 'template', ['layout1', 'view']);
		$this->add_dependecy('use_quote', 'template', ['layout1', 'view']);
		$this->add_dependecy('qoute_tag', 'template', ['layout1', 'view']);
		$this->add_dependecy('use_author', 'template', ['layout1', 'view']);
		$this->add_dependecy('max_width', 'template', ['layout1', 'view']);
		$this->add_dependecy('quote_spacing', 'template', ['layout1', 'view']);
		$this->add_dependecy('icon_position', 'template', ['layout1', 'view']);
		$this->add_dependecy('icon_size', 'template', ['layout1', 'view']);
		$this->add_dependecy('icon_color', 'template', ['layout1', 'view']);
		$this->add_dependecy('t_author', 'template', ['layout1', 'view']);
		$this->add_dependecy('t_quote', 'template', ['layout1', 'view']);
		$this->add_dependecy('icon_size', 'icon_position', ['aheto-quote--icon-center', 'aheto-quote--icon-left', 'aheto-quote--icon-right']);
		$this->add_dependecy('icon_color', 'icon_position', ['aheto-quote--icon-center', 'aheto-quote--icon-left', 'aheto-quote--icon-right']);
		$this->add_dependecy('t_author', 'use_author', 'true');
		$this->add_dependecy('t_quote', 'use_quote', 'true');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'quote'      => [
				'type'    => 'textarea',
				'heading' => esc_html__('Quote', 'aheto'),
			],
			'qoute_tag'  => [
				'type'    => 'select',
				'heading' => esc_html__('Qoute tag', 'aheto'),
				'options' => [
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'p'  => 'p',
				],
				'grid'    => 6,
			],
			'use_quote'  => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for qoute?', 'aheto'),
				'grid'    => 6,
			],
			'author'     => [
				'type'    => 'text',
				'heading' => esc_html__('Author', 'aheto'),
				'grid'    => 6,
			],
			'use_author' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for author?', 'aheto'),
				'grid'    => 6,
			],

			'align'         => [
				'type'    => 'select',
				'group'   => esc_html__('Content', 'aheto'),
				'heading' => esc_html__('Content align', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
			],
			'max_width'     => [
				'type'      => 'slider',
				'heading'   => esc_html__('Max width', 'aheto'),
				'group'     => esc_html__('Content', 'aheto'),
				'grid'      => 6,
				'range'     => [
					'px' => [
						'min'  => 100,
						'max'  => 1200,
						'step' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .aheto-quote' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
				],
			],
			'quote_spacing' => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__('Quote padding', 'aheto'),
				'group'     => esc_html__('Content', 'aheto'),
				'selectors' => [
					'{{WRAPPER}} .aheto-quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
			'icon_position' => [
				'type'    => 'select',
				'heading' => esc_html__('Icon position', 'aheto'),
				'group'   => esc_html__('Icon', 'aheto'),
				'options' => [
					'aheto-quote--icon-center'                        => 'Center',
					'aheto-quote--icon-left'  => 'Left',
					'aheto-quote--icon-right' => 'Right',
					'aheto-quote--icon-hide'  => 'None',
				],
			],
			'icon_size'     => [
				'type'    => 'select',
				'heading' => esc_html__('Icon size', 'aheto'),
				'group'   => esc_html__('Icon', 'aheto'),
				'options' => [
					''                         => 'Small',
					'aheto-quote--icon-medium' => 'Medium',
					'aheto-quote--icon-large'  => 'Large',
				],
				'grid'    => 6,
			],
			'icon_color'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Icon color', 'aheto'),
				'group'     => esc_html__('Icon', 'aheto'),
				'grid'      => 6,
				'selectors' => ['{{WRAPPER}} .aheto-quote:before' => 'color: {{VALUE}}'],
			],

			// typography
			't_quote'       => [
				'type'     => 'typography',
				'group'    => 'Quote Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-quote',
			],
			't_author'      => [
				'type'     => 'typography',
				'group'    => 'Author Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} cite',
			],
			'advanced'      => true,
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
		if ( !empty($this->atts['quote_spacing']) ) {
			$selector                   = '%1$s .aheto-quote';
			$spacing = Sanitize::responsive_spacing($this->atts['quote_spacing'], 'padding');

			if ( !empty($spacing['desktop']) ) {
				\aheto_add_props($css['global'][$selector], $spacing['desktop']);
			}

			if ( !empty($spacing['laptop']) ) {
				\aheto_add_props($css['@media (max-width: 1199px)'][$selector], $spacing['laptop']);
			}

			if ( !empty($spacing['tablet']) ) {
				\aheto_add_props($css['@media (max-width: 991px)'][$selector], $spacing['tablet']);
			}

			if ( !empty($spacing['mobile']) ) {
				\aheto_add_props($css['@media (max-width: 767px)'][$selector], $spacing['mobile']);
			}
		}


		if ( !empty($this->atts['use_quote']) && !empty($this->atts['t_quote']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-quote'], $this->parse_typography($this->atts['t_quote']));
		}

		if ( !empty($this->atts['use_author']) && !empty($this->atts['t_author']) ) {
			\aheto_add_props($css['global']['%1$s cite'], $this->parse_typography($this->atts['t_author']));
		}

		if ( !empty($this->atts['max_width']) ) {
			$css['global']['%1$s .aheto-quote']['max-width']    = Sanitize::size($this->atts['max_width']);
			$css['global']['%1$s .aheto-quote']['margin-left']  = 'auto';
			$css['global']['%1$s .aheto-quote']['margin-right'] = 'auto';
		}

		if ( !empty($this->atts['icon_color']) ) {
			$css['global']['%1$s .aheto-quote:before']['color'] = Sanitize::color($this->atts['icon_color']);
		}

		return apply_filters( "aheto_blockquote_dynamic_css", $css, $this );
	}
}
