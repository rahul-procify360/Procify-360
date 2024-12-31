<?php
/**
 * The Contact Info Shortcode.
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
 * Contact Info class.
 */
class Contact_Info extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'contact-info';
		$this->title          = esc_html__( 'Contact Info', 'aheto' );
		$this->icon           = 'fa fa-envelope-open';
		$this->description    = esc_html__( 'Add contact info', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/contact-info/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Modern', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		] );
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Modern with bigger phone', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		] );

		$this->add_dependecy( 'title', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'use_typo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'underline', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'title_space', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'type_logo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'description', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'address', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'website', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'email', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'phone', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'hovercolor', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'use_typo_text', 'template', [ 'view', 'layout1', 'layout2' ] );

		$this->add_dependecy( 'use_typo_logo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'use_typo_logo', 'type_logo', 'text' );

		$this->add_dependecy( 'phonecolor', 'template', [ 'layout2' ] );

		$this->add_dependecy( 'title_typo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'title_typo', 'use_typo', 'true' );

		$this->add_dependecy( 'logo_typo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'logo_typo', 'use_typo_logo', 'true' );

		$this->add_dependecy( 'text_typo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'text_typo', 'use_typo_text', 'true' );

		$this->add_dependecy( 'logo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'logo', 'type_logo', 'image' );

		$this->add_dependecy( 'text_logo', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'text_logo', 'type_logo', 'text' );

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params( [
			'title'         => [
				'type'    => 'text',
				'heading' => esc_html__( 'Title', 'aheto' ),
			],
			'use_typo'      => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 4,
			],
			'underline'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 4,
			],
			'title_space'   => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable smaller space after title?', 'aheto' ),
				'grid'    => 4,
			],
			'type_logo'     => [
				'type'    => 'select',
				'heading' => esc_html__( 'Type of logo', 'aheto' ),
				'options' => [
					'image' => esc_html__( 'Image', 'aheto' ),
					'text'  => esc_html__( 'Text', 'aheto' ),
				],
			],
			'logo'          => [
				'type'    => 'attach_image',
				'heading' => esc_html__( 'Logo', 'aheto' ),
			],
			'text_logo'     => [
				'type'    => 'text',
				'heading' => esc_html__( 'Text Logo', 'aheto' ),
				'grid'    => 6,
			],
			'use_typo_logo' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for logo?', 'aheto' ),
				'grid'    => 6,
			],
			'description'   => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Description', 'aheto' ),
			],
			'address'       => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Address', 'aheto' ),
			],
			'website'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Website', 'aheto' ),
			],
			'email'         => [
				'type'    => 'text',
				'heading' => esc_html__( 'Email', 'aheto' ),
			],
			'phone'         => [
				'type'    => 'text',
				'heading' => esc_html__( 'Phone', 'aheto' ),
			],
			'phonecolor'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Phone color', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .widget_aheto__info--tel .widget_aheto__link, {{WRAPPER}} .widget_aheto__info--tel .widget_aheto__link:hover' => 'color: {{VALUE}}' ],
			],
			'hovercolor'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Links hover color', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .widget_aheto__info .widget_aheto__link:hover' => 'color: {{VALUE}}' ],
			],
			'use_typo_text' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for content?', 'aheto' ),
				'grid'    => 6,
			],
		] );


		\Aheto\Params::add_icon_params( $this, [
			'add_icon'   => true,
			'add_label'  => esc_html__( 'Add address icon?', 'aheto' ),
			'group'      => esc_html__( 'Icons', 'aheto' ),
			'prefix'     => 'address_',
			'exclude'    => [ 'align' ],
			'dependency' => [ 'template', [ 'view', 'layout1', 'layout2' ] ]
		] );

		\Aheto\Params::add_icon_params( $this, [
			'add_icon'   => true,
			'add_label'  => esc_html__( 'Add website icon?', 'aheto' ),
			'group'      => esc_html__( 'Icons', 'aheto' ),
			'prefix'     => 'website_',
			'exclude'    => [ 'align' ],
			'dependency' => [ 'template', [ 'view', 'layout1', 'layout2' ] ]
		] );

		\Aheto\Params::add_icon_params( $this, [
			'add_icon'   => true,
			'add_label'  => esc_html__( 'Add email icon?', 'aheto' ),
			'group'      => esc_html__( 'Icons', 'aheto' ),
			'prefix'     => 'email_',
			'exclude'    => [ 'align' ],
			'dependency' => [ 'template', [ 'view', 'layout1', 'layout2' ] ]
		] );

		\Aheto\Params::add_icon_params( $this, [
			'add_icon'   => true,
			'add_label'  => esc_html__( 'Add phone icon?', 'aheto' ),
			'group'      => esc_html__( 'Icons', 'aheto' ),
			'prefix'     => 'phone_',
			'exclude'    => [ 'align' ],
			'dependency' => [ 'template', [ 'view', 'layout1', 'layout2' ] ]
		] );


		\Aheto\Params::add_image_sizer_params( $this, [
			'dependency' => [ 'type_logo', [ 'image' ] ]
		] );

		$this->add_params( [
			'title_typo' => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag' => false,
				],
				'selector' => '{{WRAPPER}} .widget_aheto__title',
			],
			'advanced'   => true,
		] );

		$this->add_params( [
			'logo_typo' => [
				'type'     => 'typography',
				'group'    => 'Logo Typography',
				'settings' => [
					'tag' => false,
				],
				'selector' => '{{WRAPPER}} .widget_aheto__logo h2',
			],
			'advanced'  => true,
		] );

		$this->add_params( [
			'text_typo' => [
				'type'     => 'typography',
				'group'    => 'Text Typography',
				'settings' => [
					'tag'        => false,
				],
				'selector' => '{{WRAPPER}} p, {{WRAPPER}} p a, {{WRAPPER}} a',
			],
			'advanced'  => true,
		] );
	}

	/**
	 * Get icon template-wise
	 *
	 * @param  string $icon Icon required.
	 *
	 * @return string
	 */
	public function get_icon_for( $icon ) {
		$key = $icon . '_';

		$icon = $this->get_icon_attributes( $key, true, true );

		if ( ! empty( $icon ) ) {
			$this->add_render_attribute( $key . 'icon', 'class', 'widget_aheto__icon' );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['icon'] );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['align'] );
			if ( ! empty( $icon['color'] ) ) {
				$this->add_render_attribute( $key . 'icon', 'style', 'color:' . $icon['color'] );
			}
			if ( ! empty( $icon['font_size'] ) ) {
				$this->add_render_attribute( $key . 'icon', 'style', 'font-size:' . $icon['font_size'] );
			}
		}

		return ! empty( $icon ) ? '<i ' . $this->get_render_attribute_string( $key . 'icon' ) . '></i>' : '';
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( ! empty( $this->atts['text_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s p,%1$s p a, %1$s a'], $this->parse_typography( $this->atts['text_typo'] ) );
		}

		if ( ! empty( $this->atts['title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget_aheto__title'], $this->parse_typography( $this->atts['title_typo'] ) );
		}

		if ( ! empty( $this->atts['logo_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget_aheto__logo h2'], $this->parse_typography( $this->atts['logo_typo'] ) );
		}

		if ( ! empty( $this->atts['hovercolor'] ) ) {
			$css['global']['%1$s .widget_aheto__info .widget_aheto__link:hover']['color'] = Sanitize::color( $this->atts['hovercolor'] );
		}

		if ( ! empty( $this->atts['phonecolor'] ) && $this->atts['template-contact-info'] == 'layout2' ) {
			$css['global']['%1$s .widget_aheto__info--tel .widget_aheto__link, %1$s .widget_aheto__info--tel .widget_aheto__link:hover']['color'] = Sanitize::color( $this->atts['phonecolor'] );
		}

		return apply_filters( "aheto_contact_info_dynamic_css", $css, $this );
	}
}
