<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Sanitize;
use Aheto\Shortcode;

defined( 'ABSPATH' ) || exit;

/**
 * Contents class.
 */
class Contents extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'contents';
		$this->title       = esc_html__( 'Contents', 'aheto' );
		$this->icon        = 'fa fa-window-restore';
		$this->description = esc_html__( 'Add contents', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/contents/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Faq', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Text with icon', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);

		// Dependency.


		$this->add_dependecy( 'faqs', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'first_is_opened', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'multi_active', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'title_typo', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'text_typo', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'text', 'template', 'layout2' );
		$this->add_dependecy( 'alignment', 'template', 'layout2' );

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {

		$this->add_params([
			'faqs'       => [
				'type'    => 'group',
				'heading' => esc_html__( 'Faqs', 'aheto' ),
				'params'  => [
					'title'       => [
						'type'    => 'text',
						'heading' => esc_html__( 'Title', 'aheto' ),
					],
					'description' => [
						'type'    => 'textarea',
						'heading' => esc_html__( 'Description', 'aheto' ),
					],
				],
				'default' => [
					[
						'title' => __( 'Title #1', 'aheto' ),
						'description' => __( 'Please add your title #1 text.', 'aheto' ),
					],
					[
						'title' => __( 'Title #2', 'elementor' ),
						'description' => __( 'Please add your title #2 text.', 'aheto' ),
					],
				]
			],
			'first_is_opened'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'First element is opened?', 'aheto' ),
				'grid'    => 6,
			],
			'multi_active'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Multi active items?', 'aheto' ),
				'grid'    => 6,
			],
			'title_typo' => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-contents__title',
			],
			'text_typo'  => [
				'type'     => 'typography',
				'group'    => 'Content Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-contents__desc',
			],
			'text'     => [
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Text', 'aheto' ),
				'admin_label' => true,
				'default'     => esc_html__( 'Add your text here..', 'aheto' ),
			],
			'alignment'   => [
				'global' => 'align',
			],
			'advanced'   => true,
		]);
		\Aheto\Params::add_icon_params($this, [
			'add_icon' => true,
			'exclude'  => ['align'],
			'dependency' => ['template', ['layout2']]
		]);
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-contents__desc'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		if ( ! empty( $this->atts['title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-contents__title'], $this->parse_typography( $this->atts['title_typo'] ) );
		}

		return apply_filters( "aheto_contents_dynamic_css", $css, $this );
	}
}
