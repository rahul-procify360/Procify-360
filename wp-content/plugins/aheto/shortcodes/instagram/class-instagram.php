<?php
/**
 * The Instagram Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;

defined( 'ABSPATH' ) || exit;

/**
 * Instagram class.
 */
class Instagram extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'instagram';
		$this->title          = esc_html__( 'Instagram', 'aheto' );
		$this->icon           = 'fa fa-instagram';
		$this->description    = esc_html__( 'Add Instagram gallery', 'aheto' );
		$this->default_layout = 'view';

		$dir = '//assets.aheto.co/instagram/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Classic', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		] );

		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Line', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		] );

		$this->add_dependecy( 'title', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'align_desk_items', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'align_tablet_items', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'align_mob_items', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'image_width', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'image_space', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'use_typo', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'underline', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'title_space', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'size', 'template', [ 'layout2' ] );
		$this->add_dependecy( 'limit', 'template', [ 'view', 'layout1', 'layout2' ] );

		$this->add_dependecy( 'title_typo', 'template', [ 'view', 'layout1' ] );
		$this->add_dependecy( 'title_typo', 'use_typo', 'true' );

		$this->register();
	}


	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'spectragram' ];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'title'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Title', 'aheto' ),
			],
			'use_typo'    => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 4,
			],
			'underline'   => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 4,
			],
			'title_space' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable smaller space after title?', 'aheto' ),
				'grid'    => 4,
			],
			'title_typo'  => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-instagram--title',
			],
			'username'    => [
				'type'    => 'text',
				'heading' => esc_html__( 'Username', 'aheto' ),
			],
			'token'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Access Token', 'aheto' ),
			],
			'size'        => [
				'type'    => 'select',
				'heading' => esc_html__( 'Image Size', 'aheto' ),
				'options' => [
					'small'  => esc_html__( 'Small', 'aheto' ),
					'medium' => esc_html__( 'Medium', 'aheto' ),
					'big'    => esc_html__( 'Big', 'aheto' ),
				],
			],
			'limit'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Number of Photos', 'aheto' ),
				'description' => esc_html__( 'Maximum can be 20.', 'aheto' ),
			],
			'image_width' => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Images Max width', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-instagram__list' => '--width: {{VALUE}}' ],
			],
			'image_space' => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Images Space', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-instagram__list' => '--spaces: {{VALUE}}' ],
			],
			'align_desk_items' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align images for Desktop', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
			'align_tablet_items' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align images for Tablet', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
			'align_mob_items' => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align images for mobile', 'aheto' ),
				'options' => [
					'default' => 'Default',
					'left'    => 'Left',
					'center'  => 'Center',
					'right'   => 'Right',
				],
				'default' => 'default',
			],
			'advanced'    => true,
		];
	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-instagram--title'], $this->parse_typography( $this->atts['title_typo'] ) );
		}

		if ( ! empty( $this->isSpacesValid( $this->atts['image_width'] ) ) ) {
			$css['global']['%1$s .aheto-instagram__list']['--width'] = $this->atts['image_width'];
		}

		if ( ! empty( $this->isSpacesValid( $this->atts['image_space'] ) ) ) {
			$css['global']['%1$s .aheto-instagram__list']['--spaces'] = $this->atts['image_space'];
		}

		return apply_filters( "aheto_instagram_dynamic_css", $css, $this );
	}

}
