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
class Features_Single extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'features-single';
		$this->title          = esc_html__('Features Single', 'aheto');
		$this->icon           = 'fa fa-window-maximize';
		$this->description    = esc_html__('Add features single', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/features-single/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Simple', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);
		$this->add_layout('layout3', [
			'title' => esc_html__('Simple with number', 'aheto'),
			'image' => $dir . 'layout3.jpg',
		]);
		$this->add_layout('layout4', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout4.jpg',
		]);
		$this->add_layout('layout5', [
			'title' => esc_html__('Simple With Icon and Text', 'aheto'),
			'image' => $dir . 'layout5.jpg',
		]);
		$this->add_layout('layout6', [
			'title' => esc_html__('List with Icon', 'aheto'),
			'image' => $dir . 'layout6.jpg',
		]);
		$this->add_layout('layout7', [
			'title' => esc_html__('Modern with image', 'aheto'),
			'image' => $dir . 'layout7.jpg',
		]);

		$all_layouts = ['view', 'layout1', 'layout2', 'layout3', 'layout4', 'layout5', 'layout6', 'layout7'];

		// Dependency.
		$this->add_dependecy('number', 'template', ['layout3']);
		$this->add_dependecy('use_number', 'template', ['layout3']);
		$this->add_dependecy('s_image', 'template', ['view', 'layout1', 'layout4', 'layout7']);
		$this->add_dependecy('s_heading', 'template', $all_layouts);
		$this->add_dependecy('use_heading', 'template', $all_layouts);
		$this->add_dependecy('s_description', 'template', $all_layouts);
		$this->add_dependecy('use_description', 'template', $all_layouts);
		$this->add_dependecy('button', 'template', $all_layouts);
		$this->add_dependecy('full_width', 'template', ['layout5']);
		$this->add_dependecy('link_url', 'template', ['view', 'layout1', 'layout4', 'layout5']);
		$this->add_dependecy('link_title', 'template', ['view', 'layout1', 'layout4', 'layout5']);
		$this->add_dependecy('background', 'template', 'layout5');
		$this->add_dependecy('align_item', 'template', ['view', 'layout1']);
		$this->add_dependecy('tablet_align_item', 'template', ['view', 'layout1']);
		$this->add_dependecy('mobile_align_item', 'template', ['view', 'layout1']);



		$this->add_dependecy('t_heading', 'template', $all_layouts);
		$this->add_dependecy('t_heading', 'use_heading', 'true');

		$this->add_dependecy('t_description', 'template', $all_layouts);
		$this->add_dependecy('t_description', 'use_description', 'true');

		$this->add_dependecy('t_number', 'template', ['layout3']);
		$this->add_dependecy('t_number', 'use_number', 'true');

		$this->add_dependecy('background-color', 'template', 'layout5');
		$this->add_dependecy('background-color', 'background', 'color');


		$this->register();
	}


	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'full_width'      => [
				'type'    => 'switch',
				'heading' => esc_html__('Full width?', 'aheto'),
				'grid'    => 9,
			],
			'number'          => [
				'type'    => 'text',
				'heading' => esc_html__('Number', 'aheto'),
				'grid'    => 9,
			],
			's_image'         => [
				'type'    => 'attach_image',
				'heading' => esc_html__('Image', 'aheto'),
			],
			's_heading'       => [
				'type'        => 'text',
				'heading'     => esc_html__('Heading', 'aheto'),
				'grid'        => 9,
				'admin_label' => true,
				'default'     => esc_html__('Heading with [[ hightlight ]] text', 'aheto'),
			],
			'use_heading'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for heading?', 'aheto'),
				'grid'    => 3,
			],
			's_description'   => [
				'type'    => 'textarea',
				'heading' => esc_html__('Description', 'aheto'),
				'grid'    => 9,
				'default' => esc_html__('Please add your description text.', 'aheto')
			],
			'use_description' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for description?', 'aheto'),
				'grid'    => 3,
			],
			'use_number' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for number?', 'aheto'),
				'grid'    => 3,
			],
			'align_item' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Desktop align for content', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
			'tablet_align_item' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Tablet align for content', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
			'mobile_align_item' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Mobile align for content', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
		]);

		\Aheto\Params::add_icon_params($this, [
			'add_icon' => true,
			'exclude'  => ['align'],
			'dependency' => ['template', ['view', 'layout1', 'layout2', 'layout4', 'layout5', 'layout6']]
		]);

		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view', 'layout1', 'layout4', 'layout7']]
		]);

		$this->add_params([
			'button'           => [
				'prefix' => 'link',
			],
			'background'       => [
				'type'    => 'select',
				'heading' => esc_html__('Background', 'aheto'),
				'grid'    => 6,
				'options' => [
					'color'       => esc_html__('Color', 'aheto'),
					'transparent' => esc_html__('Transparent', 'aheto'),
				],
				'default' => 'transparent',
			],
			'background-color' => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Background color', 'aheto'),
				'grid'      => 6,
				'selectors' => ['{{WRAPPER}} .aheto-content-block--chess.chess-bg' => 'background-color: {{VALUE}}'],
				'default'   => '#f6f9ff'
			],
			't_heading'        => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-content-block__title',
			],
			't_description'    => [
				'type'     => 'typography',
				'group'    => 'Description Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
			],
			't_number'    => [
				'type'     => 'typography',
				'group'    => 'Number Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-content-block__number',
			],
			'advanced'         => true,

		]);
	}


	/**
	 * Highlight Text
	 *
	 * @param  string  $text Text to highlight.
	 * @param  boolean $type TYpe.
	 *
	 * @return string
	 */
	public function highlight_text( $text, $type = false ) {
		$text = str_replace(']]', '</span>', $text);
		$text = str_replace('[[', $type ? '<span class="js-typed">' : '<span>', $text);

		return wp_kses_post($text);
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
			\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text'], $this->parse_typography($this->atts['t_description']));
		}

		if ( !empty($this->atts['use_number']) && !empty($this->atts['t_number']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-content-block__number'], $this->parse_typography($this->atts['t_number']));
		}


		if ( !empty($this->atts['background-color']) && $this->atts['background'] == 'color' ) {
			$css['global']['%1$s .aheto-content-block--chess.chess-bg']['background-color'] = Sanitize::color($this->atts['background-color']);
		}

		return apply_filters( "aheto_features_single_dynamic_css", $css, $this );
	}
}
