<?php
/**
 * The Social Networks Shortcode.
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
 * Social Networks class.
 */
class Social_Networks extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'social-networks';
		$this->title       = esc_html__( 'Social Networks', 'aheto' );
		$this->icon        = 'fa fa-share-alt';
		$this->description = esc_html__( 'Add social identities', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/social-networks/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Layout 1', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Layout 2', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);

		$this->add_dependecy( 'networks', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'size', 'template', ['view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'style', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'color', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'socials_align', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'socials_align_mob', 'template', ['view', 'layout1']  );
		$this->add_dependecy( 'scheme', 'template', ['view', 'layout1']  );


		$this->add_dependecy( 'hovercolor_circle', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'hovercolor_circle', 'style', 'circle' );
		$this->add_dependecy( 'hovercolor_default', 'template', ['view', 'layout1'] );
		$this->add_dependecy( 'hovercolor_default', 'style', 'default' );
		$this->add_dependecy( 'hovercolor_share', 'template', [ 'view', 'layout2' ] );

		$this->register();
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'ionicons' ];
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'networks' => true,
			'size'     => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Size', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} i.icon' => 'font-size: {{VALUE}}px' ],
				'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
			],
			'style'    => [
				'type'     => 'select',
				'heading'  => esc_html__( 'Type', 'aheto' ),
				'options'  => [
					'default'       => esc_html__( 'Default', 'aheto' ),
					'circle' => esc_html__( 'Circle', 'aheto' ),
				],
				'grid'     => 6,
				'selector' => '{{WRAPPER}} i.icon font-size: {{VALUE}}px',
			],
			'color'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Color', 'aheto' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link i.icon,
					 {{WRAPPER}} .aheto-socials--default a.aheto-socials__link:not(.aheto-socials__link-inverse) i.icon,
					 {{WRAPPER}} .aheto-socials--default a.aheto-socials__link.aheto-socials__link-inverse:hover i.icon' => 'color: {{VALUE}}'
				],
			],
			'hovercolor_circle'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Border color & Background color on hover', 'aheto' ),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link:not(.aheto-socials__link-inverse):hover' => 'background: {{VALUE}}',
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link:not(.aheto-socials__link-inverse)' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link.aheto-socials__link-inverse' => 'background: {{VALUE}}; border-color: {{VALUE}}',
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link.aheto-socials__link-inverse:hover' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .aheto-socials--circle a.aheto-socials__link.aheto-socials__link-inverse:hover i.icon' => 'color: {{VALUE}}',
				],
			],
			'hovercolor_default'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Color on hover', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-socials--default a.aheto-socials__link:not(.aheto-socials__link-inverse):hover i,
				{{WRAPPER}} .aheto-socials--default a.aheto-socials__link.aheto-socials__link-inverse i' => 'color: {{VALUE}}' ],
			],
			'socials_align'      => [
				'type'    => 'select',
				'heading' => esc_html__('Socials align', 'aheto'),
				'grid'      => 6,
				'options' => [
					'left'   => esc_html__('Left', 'aheto'),
					'right' => esc_html__('Right', 'aheto'),
					'center' => esc_html__('Center', 'aheto'),
					'justify' => esc_html__('Justify', 'aheto'),
				],
			],
			'socials_align_mob'      => [
				'type'    => 'select',
				'heading' => esc_html__('Socials align on mobile', 'aheto'),
				'grid'      => 6,
				'options' => [
					'left'   => esc_html__('Left', 'aheto'),
					'right' => esc_html__('Right', 'aheto'),
					'center' => esc_html__('Center', 'aheto'),
					'justify' => esc_html__('Justify', 'aheto'),
				],
			],
			'scheme'   => [
				'grid' => 6,
			],
			'advanced' => true,
			'hovercolor_share'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Background hover color', 'aheto'),
				'selectors' => ['{{WRAPPER}} .aht-page__socials__wrapper:hover .aht-page__socials__icon' => 'background: {{VALUE}};'],
			],
		];
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['size'] ) ) {
			$css['global']['%1$s i.icon']['font-size'] = Sanitize::size( $this->atts['size'] );
		}
		if ( ! empty( $this->atts['color'] ) ) {
			$css['global']['%1$s i.icon']['color'] = Sanitize::color( $this->atts['color'] );
		}
		if ( ! empty( $this->atts['hovercolor_circle'] ) ) {
			$css['global']['%1$s .aheto-socials--circle a.aheto-socials__link:hover']['background'] = Sanitize::color( $this->atts['hovercolor_circle'] );
			$css['global']['%1$s .aheto-socials--circle a.aheto-socials__link:hover']['border-color'] = Sanitize::color( $this->atts['hovercolor_circle'] );
		}
		if ( ! empty( $this->atts['hovercolor_default'] ) ) {
			$css['global']['%1$s .aheto-socials--default a.aheto-socials__link:hover i']['color'] = Sanitize::color( $this->atts['hovercolor_default'] );
		}

		if (isset($this->atts['hovercolor_share']) && !empty($this->atts['hovercolor_share'])) {
			$css['global']['%1$s .aht-page__socials__wrapper:hover .aht-page__socials__icon']['background'] = \Aheto\Sanitize::color($this->atts['hovercolor_share']);

		}

		return apply_filters( "aheto_social_networks_dynamic_css", $css, $this );
	}
}
