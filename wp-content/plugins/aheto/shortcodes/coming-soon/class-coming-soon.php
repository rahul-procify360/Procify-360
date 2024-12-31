<?php
/**
 * The Coming soon Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

//use Aheto\Sanitize;
use Aheto\Shortcode;

defined('ABSPATH') || exit;

/**
 * Contents class.
 */
class Coming_Soon extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'coming-soon';
		$this->title       = esc_html__('Coming Soon', 'aheto');
		$this->icon        = 'fa fa-hourglass-half';
		$this->description = esc_html__('Add contents', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/coming-soon/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Default', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		// Dependency.
		$this->add_dependecy( 'light', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'time', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'days_desktop', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'days_mobile', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'hours_desktop', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'hours_mobile', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'mins_desktop', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'mins_mobile', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'secs_desktop', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'secs_mobile', 'template', ['layout1', 'view']);

		$this->add_dependecy( 'use_typo_numbers', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'typo_numbers', 'template',  ['layout1', 'view']);
		$this->add_dependecy( 'typo_numbers', 'use_typo_numbers', 'true');

		$this->add_dependecy( 'use_typo_caption', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'typo_caption', 'template', ['layout1', 'view']);
		$this->add_dependecy( 'typo_caption', 'use_typo_caption', 'true');


		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'light'        => [
				'type'    => 'switch',
				'heading' => esc_html__('Enable light style?', 'aheto'),
			],
			'time_out' => [
				'type'    => 'date_time',
				'heading' => esc_html__('Time', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('2020-10-18 15:51', 'aheto'),
			],
			'days_desktop' => [
				'type'    => 'text',
				'heading' => esc_html__('Caption days(desktop)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('DAYS', 'aheto'),
			],
			'days_mobile'  => [
				'type'    => 'text',
				'heading' => esc_html__('Caption days(mobile)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('DAYS', 'aheto'),
			],
			'hours_desktop' => [
				'type'    => 'text',
				'heading' => esc_html__('Caption hours(desktop)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('HOURS', 'aheto'),
			],
			'hours_mobile'  => [
				'type'    => 'text',
				'heading' => esc_html__('Caption hours(mobile)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('HOURS', 'aheto'),
			],
			'mins_desktop' => [
				'type'    => 'text',
				'heading' => esc_html__('Caption mins(desktop)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('MINUTES', 'aheto'),
			],
			'mins_mobile'  => [
				'type'    => 'text',
				'heading' => esc_html__('Caption mins(mobile)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('MINS', 'aheto'),
			],
			'secs_desktop' => [
				'type'    => 'text',
				'heading' => esc_html__('Caption secs(desktop)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('SECONDS', 'aheto'),
			],
			'secs_mobile'  => [
				'type'    => 'text',
				'heading' => esc_html__('Caption secs(mobile)', 'aheto'),
				'grid'    => 6,
				'default' => esc_html__('SECS', 'aheto'),
			],


			'use_typo_numbers'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for numbers?', 'aheto' ),
				'grid'    => 6,
			],

			'typo_numbers'   => [
				'type'     => 'typography',
				'group'    => 'Numbers Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-coming-soon__number',
			],

			'use_typo_caption'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for caption?', 'aheto' ),
				'grid'    => 6,
			],

			'typo_caption'   => [
				'type'     => 'typography',
				'group'    => 'Caption Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-coming-soon__caption',
			],

			'advanced'     => true,
		];
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['use_typo_numbers'] ) && ! empty( $this->atts['typo_numbers'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__number'], $this->parse_typography( $this->atts['typo_numbers'] ) );
		}

		if ( ! empty( $this->atts['use_typo_caption'] ) && ! empty( $this->atts['typo_caption'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__caption'], $this->parse_typography( $this->atts['typo_caption'] ) );
		}

		return apply_filters( "aheto_coming_soon_dynamic_css", $css, $this );
	}
}
