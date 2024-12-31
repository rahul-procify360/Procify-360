<?php
/**
 * The Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use Aheto\Sanitize;

defined('ABSPATH') || exit;

/**
 * Media class.
 */
class Media extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'media';
		$this->title       = esc_html__('Media', 'aheto');
		$this->icon        = 'fa fa-play-circle';
		$this->description = esc_html__('Add media', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/media/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Simple/Slider Image', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_layout('layout2', [
			'title' => esc_html__('Masonry Gallery', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);

		$this->add_layout('layout3', [
			'title' => esc_html__('Grid Gallery', 'aheto'),
			'image' => $dir . 'layout3.jpg',
		]);

		$this->add_layout( 'layout4', [
			'title' => esc_html__( 'Modern Slider', 'aheto' ),
			'image' => $dir . 'layout4.jpg',
		]);

		$this->add_layout( 'layout5', [
			'title' => esc_html__( 'Metro Gallery', 'aheto' ),
			'image' => $dir . 'layout5.jpg',
		]);

		// Dependency.
		$this->add_dependecy('image', 'template', ['view', 'layout1','layout2','layout3', 'layout4', 'layout5']);
		$this->add_dependecy('show_image_descr', 'template', ['view', 'layout1']);

		$this->add_dependecy('image_hover', 'template', ['layout2','layout3', 'layout5']);
		$this->add_dependecy('image_popup', 'template', ['layout2','layout3', 'layout5']);
		$this->add_dependecy('item_per_row', 'template', ['layout2','layout3', 'layout5']);
		$this->add_dependecy('space', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('item_per_row_lg', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('space_lg', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('item_per_row_md', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('space_md', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('item_per_row_sm', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('space_sm', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('item_per_row_xs', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('space_xs', 'template', ['layout2', 'layout3', 'layout5']);
		$this->add_dependecy('images_height', 'template', ['layout3', 'layout5']);

		$this->add_dependecy('custom_options', 'template', ['view', 'layout1', 'layout4'] );

		$this->register();
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return ['swiper'];
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return ['swiper'];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'image'    => [
				'type'    => 'attach_images',
				'heading' => esc_html__('Images', 'aheto'),
			],
			'show_image_descr' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Show image description on hover?', 'vestry' ),
				'grid'    => 3,
			],
			'item_per_row'    => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Images per row', 'aheto' ),
				'default'   => 3,
				'value'     => 3,
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-media__list' => '--count: {{VALUE}}' ],
			],
			'space'          => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Spaces', 'aheto' ),
				'default'   => 30,
				'value'     => 30,
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-media__list' => '--spaces: {{VALUE}}' ],
			],
			'item_per_row_lg' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(lg)', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'default'     => 3,
				'value'       => 3,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--count-lg: {{VALUE}}' ],
			],
			'space_lg'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(lg)', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'default'     => 30,
				'value'       => 30,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--spaces-lg: {{VALUE}}' ],
			],
			'item_per_row_md' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(md)', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'default'     => 2,
				'value'       => 2,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--count-md: {{VALUE}}' ],
			],
			'space_md'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(md)', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'default'     => 20,
				'value'       => 20,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--spaces-md: {{VALUE}}' ],
			],
			'item_per_row_sm' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(sm)', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'default'     => 2,
				'value'       => 2,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--count-sm: {{VALUE}}' ],
			],
			'space_sm'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(sm)', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'default'     => 20,
				'value'       => 20,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--spaces-sm: {{VALUE}}' ],
			],
			'item_per_row_xs' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(xs)', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'default'     => 1,
				'value'       => 1,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--count-xs: {{VALUE}}' ],
			],
			'space_xs'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(xs)', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'default'     => 15,
				'value'       => 15,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-media__list' => '--spaces-xs: {{VALUE}}' ],
			],
			'images_height'    => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Image Height', 'aheto' ),
				'description' => esc_html__( 'Height relative to image width (percentage). Value between 30-100.', 'aheto' ),
				'selectors'   => [ '{{WRAPPER}} .aheto-media__item' => '--img-height: {{VALUE}}' ],
			],
			'image_hover' => [
				'type'    => 'select',
				'heading' => esc_html__('Hover for images', 'aheto'),
				'options' => [
					'simple_light' => 'Simple Light',
					'simple_dark' => 'Simple Dark',
					'zoom_out_light' => 'Zoom Out Light',
					'zoom_out_dark' => 'Zoom Out Dark',
					'slide_light' => 'Slide Light',
					'slide_dark' => 'Slide Dark',
					'blur_light' => 'Blur Light',
					'blur_dark' => 'Blur Dark',
					'gray_scale_light' => 'Grey Scale Light',
					'gray_scale_dark' => 'Grey Scale Dark',
					'sepia_light' => 'Sepia Light',
					'sepia_dark' => 'Sepia Dark',
					'blur_grey_scale_light' => 'Blur + Grey Scale Light',
					'blur_grey_scale_dark' => 'Blur + Grey Scale Dark',
					'opacity_light' => 'Opacity Light',
					'opacity_dark' => 'Opacity Dark',
					'shine_light' => 'Shine Light',
					'shine_dark' => 'Shine Dark',
					'none' => 'None',
				],
				'default'     => 'simple_light',
				'grid'     => 6,
			],
			'image_popup' => [
				'type'    => 'select',
				'heading' => esc_html__('Popup for images', 'aheto'),
				'options' => [
					'magnific' => 'Magnific Popup',
					'lightgallery' => 'LightGallery Popup',
					'none' => 'None',
				],
				'default'     => 'magnific',
				'grid'     => 6,
			],
			'advanced' => true,
		];


		$carousel_params = array(
			'custom_options' => true,
			'include'        => ['pagination', 'arrows', 'loop', 'autoplay', 'speed', 'slides', 'space', 'overflow', 'initial_slide', 'simulate_touch', 'arrows_color', 'arrows_size'],
			'dependency'     => [ 'template', [ 'view', 'layout1', 'layout4' ] ]
		);

		$carousel_params = apply_filters( "aheto_media_carousel",  $carousel_params );


		\Aheto\Params::add_carousel_params($this, $carousel_params);

		\Aheto\Params::add_image_sizer_params($this, [
			'dependency' => ['template', [ 'view', 'layout1','layout2', 'layout4']]
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

		if ( $this->isSpacesValid( $this->atts['item_per_row'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--count'] = $this->atts['item_per_row'];
		}

		if ( $this->isSpacesValid( $this->atts['space'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--spaces'] = $this->atts['space'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_lg'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--count-lg'] = $this->atts['item_per_row_lg'];
		}

		if ( $this->isSpacesValid( $this->atts['space_lg'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--spaces-lg'] = $this->atts['space_lg'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_md'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--count-md'] = $this->atts['item_per_row_md'];
		}

		if ( $this->isSpacesValid( $this->atts['space_md'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--spaces-md'] = $this->atts['space_md'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_sm'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--count-sm'] = $this->atts['item_per_row_sm'];
		}

		if ( $this->isSpacesValid( $this->atts['space_sm'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--spaces-sm'] = $this->atts['space_sm'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_xs'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--count-xs'] = $this->atts['item_per_row_xs'];
		}

		if ( $this->isSpacesValid( $this->atts['space_xs'] ) ) {
			$css['global']['%1$s .aheto-media__list.js-isotope']['--spaces-xs'] = $this->atts['space_xs'];
		}

		if ( ! empty( $this->atts['images_height'] ) && is_numeric( $this->atts['images_height'] ) && $this->atts['images_height'] > 0 ) {
			$css['global']['%1$s .aheto-media__item']['--img-height'] = $this->atts['images_height'];
		}

		return apply_filters( "aheto_media_dynamic_css", $css, $this );
	}
}
