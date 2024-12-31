<?php
/**
 * The Button Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Params;
use Aheto\Helper;

defined('ABSPATH') || exit;

/**
 * Button class.
 */
class Button extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'button';
		$this->title       = esc_html__('Button', 'aheto');
		$this->icon        = 'fa fa-square';
		$this->description = esc_html__('Add button', 'aheto');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		Params::add_button_params($this, [
			'add_button' => false,
			'icons'      => true,
			'group'      => esc_html__('General', 'aheto'),
		]);

		Params::add_button_params($this, [
			'add_label' => esc_html__('Add additional button?', 'aheto'),
			'group'		=> esc_html__('Additional button', 'aheto'),
			'prefix'    => 'add_',
		]);

		$this->add_params([
			'align'         => [
				'type'    => 'select',
				'heading' => esc_html__('Align for Desktop', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
				'group'   => esc_html__('General', 'aheto'),
			],
			'align_tablet'         => [
				'type'    => 'select',
				'heading' => esc_html__('Align for Tablet', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
				'group'   => esc_html__('General', 'aheto'),
			],
			'align_mobile'         => [
				'type'    => 'select',
				'heading' => esc_html__('Align for Mobile', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
				'group'   => esc_html__('General', 'aheto'),
			],
			'advanced'      => true,
		]);

	}
}
