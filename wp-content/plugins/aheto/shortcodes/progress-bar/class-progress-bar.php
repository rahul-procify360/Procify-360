<?php
/**
 * The Progress Bar Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Helper;
use Aheto\Shortcode;

defined( 'ABSPATH' ) || exit;

/**
 * Progress_Bar class.
 */
class Progress_Bar extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'progress-bar';
		$this->title       = esc_html__( 'Progressbar', 'aheto' );
		$this->icon        = 'fa fa-tasks';
		$this->description = esc_html__( 'Add progressbar', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/progress-bar/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Circle', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Progressbar with Numbers', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);
		$this->add_layout( 'layout3', [
			'title' => esc_html__( 'Numerical with Icon', 'aheto' ),
			'image' => $dir . 'layout3.jpg',
		]);

		$this->add_layout( 'layout4', [
			'title' => esc_html__( 'Modern Numerical with Icon', 'aheto' ),
			'image' => $dir . 'layout4.jpg',
		]);

		// Dependency.
		$this->add_dependecy( 'percentage', 'template', [ 'view', 'layout1', 'layout2', 'layout3' , 'layout4'  ] );
		$this->add_dependecy( 'heading', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'description', 'template', [ 'view', 'layout1', 'layout3', 'layout4' ] );

		$this->register();

	}


	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'percentage'  => [
				'type'    => 'text',
				'heading' => esc_html__( 'Counter value', 'aheto' ),
				'description' => esc_html__( 'For percentage, specify value from 0 to 100.', 'aheto' ),
			],
			'heading'     => [
				'type'    => 'text',
				'heading' => esc_html__( 'Heading', 'aheto' ),
			],
			'description' => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Description', 'aheto' ),
			],
			'advanced'    => true,
		]);

		\Aheto\Params::add_icon_params( $this,
			[
				'add_icon' => true,
				'exclude'    => ['align'],
				'dependency' => ['template', [ 'view', 'layout1', 'layout3', 'layout4' ]]
			]
		);
	}

	/**
	 * The icon.
	 *
	 * @param string $classes Icon classes.
	 */
	public function the_icon( $classes = 'aheto-progress__chart-icon' ) {

		$icon = $this->get_icon_attributes( '', true, true );

		if ( empty( $icon ) ) {
			return;
		}

		$this->add_render_attribute( 'icon', 'class', $classes );
		$this->add_render_attribute( 'icon', 'class', 'icon ' . $icon['icon'] );
		$this->add_render_attribute( 'icon', 'class', $icon['align'] );
		if ( ! empty( $icon['color'] ) ) {
			$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
		}

		echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';
	}



	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		return apply_filters( "aheto_progress_bar_dynamic_css", $css, $this );
	}

}
