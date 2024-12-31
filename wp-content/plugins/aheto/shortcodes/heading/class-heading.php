<?php
/**
 * The Heading Shortcode.
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
 * Heading class.
 */
class Heading extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'heading';
		$this->title          = esc_html__('Heading', 'aheto');
		$this->icon           = 'fa fa-header';
		$this->description    = esc_html__('Add Heading Content', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/heading/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Default', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout('layout2', [
			'title' => esc_html__('Typing With Icon', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);


		// Dependency.
		$this->add_dependecy('heading', 'template', ['view', 'layout1', 'layout2']);
		$this->add_dependecy('description', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('text_tag', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('alignment', 'template', ['view','layout1']);
		$this->add_dependecy('title_animation', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('source', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('use_typo', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('use_typo_hightlight', 'template', ['view','layout1']);
		$this->add_dependecy('use_typo_descr', 'template', ['view','layout1']);
		$this->add_dependecy('image', 'template', 'layout2');
		$this->add_dependecy('align_tablet', 'template', ['view','layout1']);
		$this->add_dependecy('align_mobile', 'template', ['view','layout1']);
		$this->add_dependecy('text_indent', 'template', ['view','layout1']);

		$this->add_dependecy('text_typo', 'template', ['view','layout1', 'layout2']);
		$this->add_dependecy('text_typo', 'use_typo', 'true');

		$this->add_dependecy('text_typo_hightlight', 'template', ['view','layout1']);
		$this->add_dependecy('text_typo_hightlight', 'use_typo_hightlight', 'true');

		$this->add_dependecy('descr_typo', 'template', ['view','layout1']);
		$this->add_dependecy('descr_typo', 'use_typo_descr', 'true');

		$this->add_dependecy('heading', 'source', '');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {

		\Aheto\Params::add_icon_params($this, [
			'add_icon' => true,
			'exclude'  => ['align'],
			'dependency' => ['template', ['view','layout1']]
		]);

		$this->add_params([
			'source'      => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Heading source', 'aheto' ),
				'description' => esc_html__( 'Select heading source.', 'aheto' ),
				'options'     => [
					''           => esc_html__( 'Custom heading', 'aheto' ),
					'post_title' => esc_html__( 'Post or Page Title', 'aheto' ),
				],
				'default'    => '',
				'grid'        => 12,
			],
			'heading'     => [
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Title', 'aheto' ),
				'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'aheto' ),
				'admin_label' => true,
				'default'     => esc_html__( 'Heading with [[ hightlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'aheto' ),
			],
			'text_tag'    => [
				'type'    => 'select',
				'heading' => esc_html__( 'Element tag for title', 'aheto' ),
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
				'default'    => 'h2',
				'grid'    => 6,
			],
			'text_indent'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable text indent for title?', 'aheto' ),
				'grid'    => 6,
			],
			'use_typo'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 6,
			],
			'title_animation'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable animation for heading?', 'aheto' ),
				'grid'    => 6,
			],
			'use_typo_hightlight'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for hightlight?', 'aheto' ),
				'grid'    => 6,
			],
			'description' => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Description', 'aheto' ),
				'default' => esc_html__('Please add your description text.', 'aheto')
			],
			'use_typo_descr'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for Description?', 'aheto' ),
				'grid'    => 6,
			],
			'descr_typo'   => [
				'type'     => 'typography',
				'group'    => 'Description Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-heading__desc',
			],
			'alignment'   => [
				'global' => 'align',
			],
			'image'       => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Icon', 'aheto' ),
			],
			'text_typo'   => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-heading__title',
			],
			'text_typo_hightlight'   => [
				'type'     => 'typography',
				'group'    => 'Hightlight Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} .aheto-heading__title span',
			],
			'align_tablet' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align for tablet', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
				'description' => esc_html__( 'It works only when custom font option for align is off', 'aheto' ),
			],
			'align_mobile' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align for mobile', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
				'description' => esc_html__( 'It works only when custom font option for align is off', 'aheto' ),

			],
			'advanced'    => true,
		]);
	}

	/**
	 * Get heading.
	 *
	 * @return string
	 */
	public function get_heading() {
		$source = $this->atts['source'];
		if ( 'post_title' === $source ) {
			return get_the_title();
		}

		return wp_kses_post( $this->atts['heading'] );
	}

	/**
	 * Highlight Text
	 *
	 * @param  string  $text Text to highlight.
	 * @param  boolean $type TYpe.
	 * @return string
	 */
	public function highlight_text( $text, $type = false ) {
		if($type){
			$text = str_replace( ']]', '</span>', $text );
			$text = str_replace( '[[', '<span class="js-typed">', $text );
		}else{
			$text = str_replace( ']]', '</span>', $text );
			$text = str_replace( '[[', '<span>', $text );
		}

		return wp_kses_post( $text );
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */


	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['use_typo'] ) && ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-heading__title'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		if ( ! empty( $this->atts['use_typo_hightlight'] ) && ! empty( $this->atts['text_typo_hightlight'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-heading__title span'], $this->parse_typography( $this->atts['text_typo_hightlight'] ) );
		}

		if ( ! empty( $this->atts['use_typo_descr'] ) && ! empty( $this->atts['descr_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-heading__desc'], $this->parse_typography( $this->atts['descr_typo'] ) );
		}

		return apply_filters( "aheto_heading_dynamic_css", $css, $this );
	}
}
