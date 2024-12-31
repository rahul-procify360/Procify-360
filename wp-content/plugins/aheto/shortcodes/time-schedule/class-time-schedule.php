<?php
/**
 * The Time Schedule Shortcode.
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

defined( 'ABSPATH' ) || exit;

/**
 * Time Schedule class.
 */
class Time_Schedule extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'time-schedule';
		$this->title       = esc_html__( 'Time Schedule', 'aheto' );
		$this->icon        = 'fa fa-calendar';
		$this->description = esc_html__( 'Add time schedule', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/time-schedule/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Classic', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_dependecy('title', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('underline', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_space', 'template', ['view', 'layout1']);
		$this->add_dependecy('schedules_color', 'template', ['view', 'layout1']);
		$this->add_dependecy('schedules', 'template', ['view', 'layout1']);

		$this->add_dependecy('title_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_typo', 'use_typo', 'true');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'title'     => [
				'type'    => 'text',
				'heading' => esc_html__( 'Title', 'aheto' ),
			],
			'use_typo'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 4,
			],
			'underline'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 4,
			],
			'title_space'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable smaller space after title?', 'aheto' ),
				'grid'    => 4,
			],
			'schedules_color'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Schedules highlight color', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} ul li b' => 'color: {{VALUE}}' ],
			],
			'title_typo'   => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .widget-title',
			],
			'schedules' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Schedules', 'aheto' ),
				'params'  => [
					'highlight' => [
						'type'    => 'switch',
						'heading' => esc_html__( 'Highlight', 'aheto' ),
					],
					'day'       => [
						'type'    => 'select',
						'heading' => esc_html__( 'Day', 'aheto' ),
						'options' => $this->choices_schedule_days(),
					],
					'time'      => [
						'type'    => 'text',
						'heading' => esc_html__( 'Time', 'aheto' ),
					],
				],
			],

			'advanced'  => true,
		];
	}

	/**
	 * Schedule Days.
	 *
	 * @return array
	 */
	private function choices_schedule_days() {
		return [
			esc_html__( 'Monday', 'aheto' )    => esc_html__( 'Monday', 'aheto' ),
			esc_html__( 'Tuesday', 'aheto' )   => esc_html__( 'Tuesday', 'aheto' ),
			esc_html__( 'Wednesday', 'aheto' ) => esc_html__( 'Wednesday', 'aheto' ),
			esc_html__( 'Thursday', 'aheto' )  => esc_html__( 'Thursday', 'aheto' ),
			esc_html__( 'Friday', 'aheto' )    => esc_html__( 'Friday', 'aheto' ),
			esc_html__( 'Saturday', 'aheto' )  => esc_html__( 'Saturday', 'aheto' ),
			esc_html__( 'Sunday', 'aheto' )    => esc_html__( 'Sunday', 'aheto' ),
		];
	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget-title'], $this->parse_typography( $this->atts['title_typo'] ) );
		}

		if ( ! empty( $this->atts['schedules_color'] ) ) {
			$css['global']['%1$s ul li b']['color'] = Sanitize::color( $this->atts['schedules_color'] );
		}

		return apply_filters( "aheto_time_schedule_dynamic_css", $css, $this );
	}
}
