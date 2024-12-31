<?php
/**
 * The Recent Posts Shortcode.
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

defined( 'ABSPATH' ) || exit;

/**
 * Recent Posts class.
 */
class Recent_Posts extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'recent-posts';
		$this->title       = esc_html__( 'Recent Posts', 'aheto' );
		$this->icon        = 'fa fa-newspaper-o';
		$this->description = esc_html__( 'Add recent posts', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/recent-posts/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Modern', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);


		$this->add_dependecy('title', 'template', ['view', 'layout1']);
		$this->add_dependecy('underline', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_space', 'template', ['view', 'layout1']);
		$this->add_dependecy('text_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('post_type', 'template', ['view', 'layout1']);
		$this->add_dependecy('limit', 'template', ['view', 'layout1']);
		$this->add_dependecy('hide_thumb', 'template', ['view', 'layout1']);
		$this->add_dependecy('post_title_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('hovercolor', 'template', ['view', 'layout1']);

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
			'underline'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 6,
			],
			'title_space'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable smaller space after title?', 'aheto' ),
				'grid'    => 6,
			],
			'text_typo'   => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} .widget-recent-title',
			],
			'post_type' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Post Types', 'aheto' ),
				'options' => Helper::choices_post_types(),
			],
			'limit'     => [
				'type'    => 'text',
				'heading' => esc_html__( 'Number Of posts', 'aheto' ),
			],
			'hide_thumb'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Hide post thumbnail?', 'aheto' ),
				'grid'    => 9,
			],
			'post_title_typo'   => [
				'type'     => 'typography',
				'group'    => 'Post Title Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} .post-title',
			],
			'hovercolor'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Links color on hover', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} ul li a:hover' => 'color: {{VALUE}}' ],
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
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget-recent-title'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		if ( ! empty( $this->atts['post_title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .post-title'], $this->parse_typography( $this->atts['post_title_typo'] ) );
		}

		if ( ! empty( $this->atts['hovercolor'] ) ) {
			$css['global']['%1$s ul li a:hover']['color'] = Sanitize::color( $this->atts['hovercolor'] );
		}

		return apply_filters( "aheto_recent_posts_dynamic_css", $css, $this );
	}



}
