<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Testimonials class.
 */
class Testimonials extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'testimonials';
		$this->title          = esc_html__( 'Testimonials', 'aheto' );
		$this->icon           = 'fa fa-comments';
		$this->description    = esc_html__( 'Add testimonials', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/testimonials/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Classic Slider', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		] );

		$this->add_dependecy( 'testimonials', 'template', ['view', 'layout1'] );

		$this->register();
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'swiper' ];
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'swiper' ];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {

		$carousel_params = array(
			'custom_options' => true,
			'include'        => [ 'pagination', 'arrows', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_color', 'arrows_size', 'lazy' ],
			'dependency' => ['template', ['view', 'layout1']]
		);

		$carousel_params = apply_filters( "aheto_testimonials_carousel",  $carousel_params );

		\Aheto\Params::add_carousel_params( $this, $carousel_params );

		$this->add_params( [
			'testimonials' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Testimonials', 'aheto' ),
				'params'  => [
					'g_image'       => [
						'type'    => 'attach_image',
						'heading' => esc_html__( 'Display Image', 'aheto' ),
					],
					'g_name'        => [
						'type'    => 'text',
						'heading' => esc_html__( 'Name', 'aheto' ),
						'default' => esc_html__( 'Author name', 'aheto' ),
					],
					'g_company'     => [
						'type'    => 'text',
						'heading' => esc_html__( 'Position', 'aheto' ),
						'default' => esc_html__( 'Author position', 'aheto' ),
					],
					'g_testimonial' => [
						'type'    => 'textarea',
						'heading' => esc_html__( 'Testimonial', 'aheto' ),
						'default' => esc_html__( 'Please add your testimonial text.', 'aheto' ),
					],
					'g_rating'      => [
						'type'    => 'select',
						'heading' => esc_html__( 'Rating', 'aheto' ),
						'options' => [
							'1'   => esc_html__( '1', 'aheto' ),
							'1.5' => esc_html__( '1.5', 'aheto' ),
							'2'   => esc_html__( '2', 'aheto' ),
							'2.5' => esc_html__( '2.5', 'aheto' ),
							'3'   => esc_html__( '3', 'aheto' ),
							'3.5' => esc_html__( '3.5', 'aheto' ),
							'4'   => esc_html__( '4', 'aheto' ),
							'4.5' => esc_html__( '4.5', 'aheto' ),
							'5'   => esc_html__( '5', 'aheto' ),
						],
						'default' => '5',
					],
				],
			],
			'advanced'     => true,
		] );

		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view', 'layout1']]
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
		if ( !empty($this->atts['arrows_color']) ) {
			$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($this->atts['arrows_color']);
		}

		if ( !empty($this->atts['arrows_size']) ) {
			$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size($this->atts['arrows_size'] );
		}

		return apply_filters( "aheto_testimonials_dynamic_css", $css, $this );
	}


}
