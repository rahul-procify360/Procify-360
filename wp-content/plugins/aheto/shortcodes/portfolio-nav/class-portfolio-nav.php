<?php
/**
 * The Portfolio Nav Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Portfolio_Nav class.
 */
class Portfolio_Nav extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'portfolio-nav';
		$this->title       = esc_html__( 'Portfolio Nav', 'aheto' );
		$this->icon        = 'fa fa-file-image-o';
		$this->description = esc_html__( 'Add portfolio nav', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/portfolio-nav/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Classic', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_layout('layout2', [
			'title' => esc_html__('Simple Tags', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		$this->add_layout('layout3', [
			'title' => esc_html__('Modern', 'aheto'),
			'image' => $dir . 'layout3.jpg',
		]);

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'advanced' => true,

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

		return apply_filters( "aheto_portfolio_nav_dynamic_css", $css, $this );
	}
}
