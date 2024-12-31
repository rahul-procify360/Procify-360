<?php
/**
 * The Google Map Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Sanitize;

defined('ABSPATH') || exit;


/**
 * Google_Map class.
 */
class Google_Map extends Shortcode {

	public $admin_enqueue_js = '';

	public function setAdminJs() {
		$api_key = !empty( get_option('aheto-general-settings')['google_api_key'] ) ? get_option('aheto-general-settings')['google_api_key'] : '';
		$admin_map_dir          = array(
			'https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&sensor=false',
			aheto()->plugin_url() . 'shortcodes/google-map/assets/js/g-maps-admin.js',
		);
		$this->admin_enqueue_js = $admin_map_dir;
	}

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'google-map';
		$this->title       = esc_html__('Google Map', 'aheto');
		$this->icon        = 'fa fa-map-marker';
		$this->description = esc_html__('Add google map', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/google-map/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		// Enqueue admin js
		$this->setAdminJs();

		$this->add_dependecy('height', 'template', ['view', 'layout1']);
		$this->add_dependecy('overlay', 'template', ['view', 'layout1']);
		$this->add_dependecy('addresses', 'template', ['view', 'layout1']);
		$this->add_dependecy('marker', 'template', ['view', 'layout1']);
		$this->add_dependecy('zoom', 'template', ['view', 'layout1']);
		$this->add_dependecy('zoom_buttons', 'template', ['view', 'layout1']);
		$this->add_dependecy('item_marker', 'choose_marker', 'custom');


		$this->register();
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return ['googlemap-api', 'googlemap'];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'height'    => [
				'type'      => 'slider',
				'heading'   => esc_html__('Map Height', 'aheto'),
				'grid'      => 4,
				'size_units' => [ 'px', 'vh', '%' ],
				'range'     => [
					'px' => [
						'min'  => 200,
						'max'  => 2000,
						'step' => 5,
					],
					'vh' => [
						'min'  => 0,
						'max'  => 100,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .aheto-map' => 'height: {{SIZE}}{{UNIT}};',
				],
			],
			'overlay'         => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Overlay Color', 'aheto'),
				'grid'      => 12,
				'default'   => 'rgba(255,255,255,0)'
			],
			'zoom_buttons'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Hide zoom buttons?', 'aheto' ),
				'grid'    => 6,
			],
			'addresses'    => [
				'type'    => 'group',
				'heading' => esc_html__( 'Addresses', 'aheto' ),
				'params'  => [
					'address' => [
						'type'    => 'text',
						'heading' => esc_html__( 'Address', 'aheto' ),
					],
					'choose_marker'       => [
						'type'    => 'select',
						'heading' => esc_html__( 'Marker', 'aheto' ),
						'options' => [
							'same'  => 'Same for all addresses',
							'custom'  => 'Custom marker',
						],
						'default' => 'same',
					],
					'item_marker'    => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Marker Image', 'aheto'),
					],
				],
			],
			'marker'    => [
				'type'    => 'attach_image',
				'heading' => esc_html__('Marker Image', 'aheto'),
			],
			'zoom'      => [
				'type'    => 'text',
				'heading' => esc_html__('Zoom', 'aheto'),
			],
			'advanced'  => true,
		];
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css($css) {
		if ( !empty($this->atts['height']) ) {

			$height = Sanitize::size($this->atts['height']);

			$css['global']['%1$s .aheto-map']['height'] = $height;
		}

		return apply_filters( "aheto_google_map_dynamic_css", $css, $this );
	}
}
