<?php
/**
 * The Contacts Shortcode.
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
 * Contacts class.
 */
class Contacts extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'contacts';
		$this->title       = esc_html__( 'Contacts', 'aheto' );
		$this->icon        = 'fa fa-phone-square';
		$this->description = esc_html__( 'Add contacts', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/contacts/previews/';

		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Classic', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Modern', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);
		$this->add_layout( 'layout3', [
			'title' => esc_html__( 'Simple', 'aheto' ),
			'image' => $dir . 'layout3.jpg',
		]);

		// Dependency.
		$this->add_dependecy( 's_heading', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'email', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'phone', 'template', [ 'view', 'layout1', 'layout2' ] );
		$this->add_dependecy( 'link_url', 'template', 'layout2' );
		$this->add_dependecy( 'link_title', 'template', 'layout2' );
		$this->add_dependecy( 'address', 'template', 'layout2' );
		$this->add_dependecy( 'networks', 'template', 'layout2' );
		$this->add_dependecy( 'contacts', 'template', 'layout3' );
		$this->add_dependecy( 'use_heading', 'template', [ 'view', 'layout1', 'layout2', 'layout3'] );
		$this->add_dependecy( 'use_content', 'template', [ 'view', 'layout1', 'layout2', 'layout3'] );
		$this->add_dependecy( 'button', 'template', [ 'view', 'layout1', 'layout2', 'layout3'] );

		$this->add_dependecy( 't_heading', 'template', [ 'view', 'layout1', 'layout2', 'layout3'] );
		$this->add_dependecy( 't_heading', 'use_heading', 'true' );

		$this->add_dependecy( 't_content', 'template', [ 'view', 'layout1', 'layout2', 'layout3'] );
		$this->add_dependecy( 't_content', 'use_content', 'true' );

		$this->add_dependecy( 'use_newtab', 'template', [ 'view', 'layout2'] );

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'use_newtab' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Open networks in new tab?', 'aheto' ),
			],
			'use_heading' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for heading?', 'aheto' ),
				'grid'    => 6,
			],
			'use_content' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for content?', 'aheto' ),
				'grid'    => 6,
			],
			's_heading'   => [
				'type'    => 'text',
				'heading' => esc_html__( 'Heading', 'aheto' ),
			],
			'address'     => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Address', 'aheto' ),
			],
			'button'      => [
				'prefix' => 'link',
			],
			'email'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Email', 'aheto' ),
			],
			'phone'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Phone', 'aheto' ),
			],
			'networks'    => true,
			'contacts'    => [
				'type'    => 'group',
				'heading' => esc_html__( 'Contacts', 'aheto' ),
				'params'  => [
					'contact' => [
						'type'    => 'select',
						'heading' => esc_html__( 'Content', 'aheto' ),
						'options' => [
							'address' => esc_html__( 'Address', 'aheto' ),
							'email'   => esc_html__( 'Email', 'aheto' ),
							'phone'   => esc_html__( 'Phone', 'aheto' ),
						],
					],
					'icon'    => [
						'type'    => 'select',
						'heading' => esc_html__( 'Icon', 'aheto' ),
						'options' => Helper::choices_icons(),
					],
					'heading' => [
						'type'    => 'text',
						'heading' => esc_html__( 'Heading', 'aheto' ),
					],
					'content' => [
						'type'    => 'text',
						'heading' => esc_html__( 'Content', 'aheto' ),
					],
				],
			],
			't_heading'   => [
				'type'     => 'typography',
				'group'    => 'Heading Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-contact__title,{{WRAPPER}} .aheto-contact .aheto-contact__type',
			],
			't_content'   => [
				'type'     => 'typography',
				'group'    => 'Content Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-contact p,{{WRAPPER}} .aheto-contact h3.aheto-contact__info,{{WRAPPER}} .aheto-contact__mail,{{WRAPPER}} .aheto-contact__tel,{{WRAPPER}} .aheto-contact__info',
			],
			'advanced'    => true,
		];
	}


	/**
	 * Get icon template-wise
	 *
	 * @param  string $icon Icon required.
	 * @return string
	 */
	public function get_icon_for( $icon ) {
		$key  = $icon . '_';

		$icon = $this->get_icon_attributes( $key, true, true );

		if ( ! empty( $icon ) ) {
			$this->add_render_attribute( $key . 'icon', 'class', 'widget_aheto__icon' );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['icon'] );
			$this->add_render_attribute( $key . 'icon', 'class', $icon['align'] );
			if ( ! empty( $icon['color'] ) ) {
				$this->add_render_attribute( $key . 'icon', 'style', 'color:' . $icon['color'] . ';' );
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
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['use_heading'] ) && ! empty( $this->atts['t_heading'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-contact__title, %1$s .aheto-contact .aheto-contact__type'], $this->parse_typography( $this->atts['t_heading'] ) );
		}

		if ( ! empty( $this->atts['use_content'] ) && ! empty( $this->atts['t_content'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-contact p,%1$s .aheto-contact h3,%1$s .aheto-contact__mail,%1$s .aheto-contact__tel,%1$s .aheto-contact__info'], $this->parse_typography( $this->atts['t_content'] ) );
		}

		return apply_filters( "aheto_contacts_dynamic_css", $css, $this );
	}
}
