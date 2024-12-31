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
use Aheto\Sanitize;

defined('ABSPATH') || exit;

/**
 * Features class.
 */
class Features_Slider extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'features-slider';
		$this->title          = esc_html__('Features Slider', 'aheto');
		$this->icon           = 'fa fa-th-large';
		$this->description    = esc_html__('Add features slider', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/features-slider/previews/';

		$this->add_layout('layout1', [
			'title' => esc_html__('Simple Slider', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_dependecy('slider', 'template', ['layout1', 'view']);
		$this->add_dependecy('use_heading', 'template', ['layout1', 'view']);
		$this->add_dependecy('use_description', 'template', ['layout1', 'view']);

		$this->add_dependecy('t_heading', 'template', ['layout1', 'view']);
		$this->add_dependecy('t_heading', 'use_heading', 'true');

		$this->add_dependecy('t_description', 'template', ['layout1', 'view']);
		$this->add_dependecy('t_description', 'use_description', 'true');

		$this->register();
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return ['swiper'];
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return ['swiper'];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {

		\Aheto\Params::add_carousel_params($this, [
			'custom_options' => true,
			'include'        => ['autoplay', 'arrows', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch', 'arrows_color', 'arrows_size'],
			'dependency' => ['template', ['layout1', 'view']]
		]);

		$this->add_params([
			'slider'        => [
				'type'    => 'group',
				'heading' => esc_html__('Features Slider', 'aheto'),
				'params'  => [
					'number'      => [
						'type'    => 'text',
						'heading' => esc_html__('Number', 'aheto'),
					],
					'heading'     => [
						'type'    => 'text',
						'heading' => esc_html__('Heading', 'aheto'),
					],
					'icon'        => [
						'type'    => 'select',
						'heading' => esc_html__('Icon', 'aheto'),
						'options' => Helper::choices_icons(),
					],
					'description' => [
						'type'    => 'textarea',
						'heading' => esc_html__('Description', 'aheto'),
					],
				],
			],
			'use_heading'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for heading?', 'aheto'),
				'grid'    => 6,
			],
			'use_description' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for description?', 'aheto'),
				'grid'    => 6,
			],
			't_heading'     => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-features-slider__title',
			],
			't_description' => [
				'type'     => 'typography',
				'group'    => 'Description Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-features-slider__info-text',
			],
			'advanced'      => true,

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
			\aheto_add_props($css['global']['%1$s .aheto-features-slider__title'], $this->parse_typography($this->atts['t_heading']));
		}

		if ( !empty($this->atts['use_description']) && !empty($this->atts['t_description']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-features-slider__info-text'], $this->parse_typography($this->atts['t_description']));
		}

		if ( !empty($this->atts['arrows_color']) ) {
			$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($this->atts['arrows_color']);
		}

		if ( !empty($this->atts['arrows_size']) ) {
			$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size($this->atts['arrows_size'] );
		}
		return apply_filters( "aheto_features_slider_dynamic_css", $css, $this );
	}

}
