<?php
/**
 * The Team Shortcode.
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
 * Team class.
 */
class Team_Member extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'team-member';
		$this->title       = esc_html__('Team member', 'aheto');
		$this->icon        = 'fa fa-user';
		$this->description = esc_html__('Add team member', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/team-member/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Chess', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Simple', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		// Dependency.
		$this->add_dependecy('position', 'template', ['view','layout1']);
		$this->add_dependecy('description', 'template', ['view','layout1']);

		$this->add_dependecy('image', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('name', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('designation', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('networks', 'template', ['view', 'layout1', 'layout2']);

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'image'       => [
				'type'    => 'attach_image',
				'heading' => esc_html__('Display Image', 'aheto'),
				'grid'    => 12,
			],
			'position'    => [
				'type'    => 'select',
				'heading' => esc_html__('Image Position', 'aheto'),
				'options' => [
					'left'  => esc_html__('Left Side', 'aheto'),
					'right' => esc_html__('Right Side', 'aheto'),
				],
				'default' => 'left',
				'grid'    => 4,
			],
			'name'        => [
				'type'    => 'text',
				'heading' => esc_html__('Name', 'aheto'),
				'default' => esc_html__('Member name', 'aheto'),
			],
			'designation' => [
				'type'    => 'text',
				'heading' => esc_html__('Designation', 'aheto'),
				'default' => esc_html__('Member designation', 'aheto'),
			],
			'description' => [
				'type'    => 'textarea',
				'heading' => esc_html__('Description', 'aheto'),
				'default' => esc_html__('Member description', 'aheto'),
			],
			'networks'    => true,
			'advanced'    => true,
		];


		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template',  ['view', 'layout1', 'layout2']]
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

		return apply_filters( "aheto_team_member_dynamic_css", $css, $this );
	}
}
