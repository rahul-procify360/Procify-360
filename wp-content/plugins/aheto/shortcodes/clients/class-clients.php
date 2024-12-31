<?php
/**
 * The Clients Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;

defined('ABSPATH') || exit;

/**
 * Clients class.
 */
class Clients extends Shortcode {


	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'clients';
		$this->title          = esc_html__('Clients', 'aheto');
		$this->icon           = 'fa fa-users';
		$this->description    = esc_html__('Add clients', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/clients/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_dependecy( 'hover_style', 'template', ['view', 'layout1']);
		$this->add_dependecy( 'clients', 'template', ['view', 'layout1']);
		$this->add_dependecy( 'item_per_row', 'template', ['view', 'layout1']);

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'hover_style'  => [
				'type'    => 'select',
				'heading' => esc_html__('Hover Style', 'aheto'),
				'default' => 'default',
				'options' => [
					'default'   => esc_html__('Default', 'aheto'),
					'grayscale' => esc_html__('Grayscale', 'aheto'),
					'darkness'  => esc_html__('Darkness', 'aheto'),
					'lightness'  => esc_html__('Lightness', 'aheto'),
				],
			],
			'clients'      => [
				'type'    => 'group',
				'heading' => esc_html__('Clients', 'aheto'),
				'params'  => [
					'image'    => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Logo', 'aheto'),
					],
					'link_url' => [
						'type'        => 'link',
						'heading'     => esc_html__('Link', 'aheto'),
						'description' => esc_html__('Add url to button.', 'aheto'),
						'default'     => [
							'url' => '#',
						],
					]
				],
			],
			'item_per_row' => [
				'type'    => 'select',
				'heading' => esc_html__('Count item per row', 'aheto'),
				'default' => '3',
				'options' => [
					'2' => esc_html__('2', 'aheto'),
					'3' => esc_html__('3', 'aheto'),
					'4' => esc_html__('4', 'aheto'),
					'5' => esc_html__('5', 'aheto'),
					'6' => esc_html__('6', 'aheto'),
				],
			],
			'advanced'     => true,
		];

		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view', 'layout1']]
		]);


	}



	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		return apply_filters( "aheto_clients_dynamic_css", $css, $this );
	}
}
