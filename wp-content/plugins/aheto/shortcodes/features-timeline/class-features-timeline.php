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
class Features_Timeline extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'features-timeline';
		$this->title          = esc_html__('Features Timeline', 'aheto');
		$this->icon           = 'fa fa-graduation-cap';
		$this->description    = esc_html__('Add features timeline', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/features-timeline/previews/';

		$this->add_layout('layout1', [
			'title' => esc_html__('Timeline', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);


		// Dependency.

		$this->add_dependecy('timelines', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_heading', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_description', 'template', ['view', 'layout1']);


		$this->add_dependecy('t_heading', 'template', ['view', 'layout1']);
		$this->add_dependecy('t_heading', 'use_heading', 'true');

		$this->add_dependecy('t_description', 'template', ['view', 'layout1']);
		$this->add_dependecy('t_description', 'use_description', 'true');


		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'timelines'     => [
				'type'    => 'group',
				'heading' => esc_html__('Timeline', 'aheto'),
				'params'  => [
					'heading'     => [
						'type'    => 'text',
						'heading' => esc_html__('Heading', 'aheto'),
					],
					'description' => [
						'type'    => 'textarea',
						'heading' => esc_html__('Description', 'aheto'),
					],
					'image'       => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Display Image', 'aheto'),
					],
					'time'        => [
						'type'    => 'text',
						'heading' => esc_html__('Time', 'aheto'),
					],
				],
			],
			'use_heading'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for heading?', 'aheto'),
				'grid'    => 3,
			],
			'use_description' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for description?', 'aheto'),
				'grid'    => 3,
			],
			't_heading'     => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-content-block__title',
			],
			't_description' => [
				'type'     => 'typography',
				'group'    => 'Description Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-content-block__content p',
			],
			'advanced'      => true,

		]);


		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view', 'layout1']]
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
			\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $this->parse_typography($this->atts['t_heading']));
		}

		if ( !empty($this->atts['use_description']) && !empty($this->atts['t_description']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-content-block__content p'], $this->parse_typography($this->atts['t_description']));
		}

		return apply_filters( "aheto_features_timeline_dynamic_css", $css, $this );
	}
}
