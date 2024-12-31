<?php
/**
 * The Call Action Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Params;
use Aheto\Shortcode;

defined( 'ABSPATH' ) || exit;

/**
 * Call_To_Action class.
 */
class Call_To_Action extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'call-to-action';
		$this->title          = esc_html__('Call To Action', 'aheto');
		$this->icon           = 'fa fa-paper-plane';
		$this->description    = esc_html__('Add call to action', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/call-to-action/previews/';

		$this->add_layout('layout1', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_layout('layout2', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		$this->add_dependecy( 'heading', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'text_tag', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'use_typo', 'template', [ 'view',  'layout1', 'layout2' ] );
		$this->add_dependecy( 'add_icon', 'template', [ 'layout2' ] );
		$this->add_dependecy('text_typo', 'template', [ 'view',  'layout1', 'layout2' ] );
		$this->add_dependecy('text_typo', 'use_typo', 'true');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'heading'     => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Heading', 'aheto' ),
				'grid'    => 6,
			],
			'text_tag' => [
				'type'    => 'select',
				'heading' => esc_html__('Title tag', 'aheto'),
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
			'use_typo'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 4,
			],
			'text_typo'   => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} .aheto-cta__title',
			]
		]);

		Params::add_icon_params($this, [
			'add_icon' => true,
			'exclude'  => ['align'],
			'dependency' => ['template', ['layout2']]
		]);

		Params::add_button_params($this, [
			'prefix' => 'main_',
			'icons'      => true,
			'dependency' => ['template', ['view', 'layout1','layout2']]
		]);
		Params::add_button_params($this, [
			'add_label' => esc_html__('Add additional button?', 'aheto'),
			'prefix'    => 'additional_',
			'icons'      => true,
			'dependency' => ['template', ['view', 'layout1','layout2']]
		]);

		$this->add_params([
			'advanced' => true,
		]);
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['use_typo'] ) && ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cta__title'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		return apply_filters( "aheto_call_to_action_dynamic_css", $css, $this );
	}
}
