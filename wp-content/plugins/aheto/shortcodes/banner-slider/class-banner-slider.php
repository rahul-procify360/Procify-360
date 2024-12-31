<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Sanitize;
use Aheto\Shortcode;
use Aheto\Params;

defined( 'ABSPATH' ) || exit;

/**
 * Banner_Slider class.
 */
class Banner_Slider extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'banner-slider';
		$this->title          = esc_html__( 'Banner Slider', 'aheto' );
		$this->icon           = 'fa fa-image';
		$this->description    = esc_html__( 'Add banner slider', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/banner-slider/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Banner Slider 1', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		] );

		$this->add_dependecy( 'banners', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'use_heading', 'template', ['layout1', 'view']  );

		$this->add_dependecy( 'video', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 'video', 'add_video', 'true' );

		$this->add_dependecy( 't_heading', 'template', ['layout1', 'view'] );
		$this->add_dependecy( 't_heading', 'use_heading', 'true' );

		$this->register();
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'swiper', 'magnific' ];
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'swiper', 'magnific' ];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'banners'     => [
				'type'    => 'group',
				'heading' => esc_html__( 'Banners', 'aheto' ),
				'params'  => [
					'image'         => [
						'type'    => 'attach_image',
						'heading' => esc_html__( 'Image', 'aheto' ),
					],
					'title'         => [
						'type'    => 'text',
						'heading' => esc_html__( 'Title', 'aheto' ),
					],
					'desc'          => [
						'type'    => 'textarea',
						'heading' => esc_html__( 'Description', 'aheto' ),
					],
					'align'         => true,
					'btn_direction' => [
						'type'    => 'select',
						'heading' => esc_html__( 'Buttons Direction', 'aheto' ),
						'options' => [
							''            => esc_html__( 'Horizontal', 'aheto' ),
							'is-vertical' => esc_html__( 'Vertical', 'aheto' ),
						],
					],
				]
			],
			'use_heading' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for heading?', 'aheto' ),
				'grid'    => 3,
			],
			't_heading'   => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-banner__title',
			],
		];

		Params::add_button_params( $this, [
			'prefix' => 'main_',
			'include'    => [ 'style', 'size', 'type', 'shadow', 'underline'],
		], 'banners' );

		Params::add_button_params( $this, [
			'add_label' => esc_html__( 'Add additional button?', 'aheto' ),
			'prefix'    => 'add_',
			'include'    => [ 'style', 'size', 'type', 'shadow', 'underline'],
		], 'banners' );

		Params::add_video_button_params( $this, [
			'group' => esc_html__( 'General', 'aheto' ),
		], 'banners' );


		$carousel_params = array(
			'custom_options' => true,
			'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'arrows_color', 'arrows_size', 'simulate_touch'],
			'dependency' => ['template', ['view', 'layout1']]
		);

		$carousel_params = apply_filters( "aheto_banner_slider_carousel",  $carousel_params );

		Params::add_carousel_params( $this, $carousel_params );


		Params::add_image_sizer_params($this, [
			'dependency' => ['template',  ['view', 'layout1']]
		]);

		$this->add_params( [
			'advanced' => true,
		] );
	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['use_heading'] ) && ! empty( $this->atts['t_heading'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-banner__title'], $this->parse_typography( $this->atts['t_heading'] ) );
		}

		if ( !empty($this->atts['arrows_color']) ) {
			$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($this->atts['arrows_color']);
		}

		if ( !empty($this->atts['arrows_size']) ) {
			$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $this->atts['arrows_size'] );
		}

		return apply_filters( "aheto_banner_slider_dynamic_css", $css, $this );
	}




}
