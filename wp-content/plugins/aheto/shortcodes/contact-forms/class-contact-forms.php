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

use Aheto\Params;
use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * Contact Forms class.
 */
class Contact_Forms extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'contact-forms';
		$this->title       = esc_html__( 'Contact Forms', 'aheto' );
		$this->icon        = 'fa fa-id-card';
		$this->description = esc_html__( 'Add contact form', 'aheto' );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/contact-forms/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Subscribe classic', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);
		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Subscribe modern', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		]);

		$this->add_layout( 'layout3', [
			'title' => esc_html__( 'Subscribe simple', 'aheto' ),
			'image' => $dir . 'layout3.jpg',
		]);

		$this->add_layout( 'layout4', [
			'title' => esc_html__( 'Classic Form', 'aheto' ),
			'image' => $dir . 'layout4.jpg',
		]);

		$this->add_layout( 'layout5', [
			'title' => esc_html__( 'Subscribe line', 'aheto' ),
			'image' => $dir . 'layout5.jpg',
		]);



		$this->add_dependecy( 'title', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'use_title_typo', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ] );


		$this->add_dependecy( 'underline', 'template', [ 'view', 'layout1', 'layout2', 'layout3' ] );
		$this->add_dependecy( 'title_space', 'template', [ 'view', 'layout1', 'layout2', 'layout3' ] );
		$this->add_dependecy( 'full_width_button', 'template', [ 'view', 'layout1', 'layout2', 'layout3' ] );
		$this->add_dependecy( 'description', 'template', [ 'view', 'layout1', 'layout2', 'layout3' ] );
		$this->add_dependecy( 'count_input', 'template', [ 'view', 'layout4' ] );
		$this->add_dependecy( 'button_align', 'template', [ 'view', 'layout4' ] );
		$this->add_dependecy( 'border_radius_button', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'border_radius_input', 'template', [ 'view','layout1', 'layout2', 'layout3', 'layout4', 'layout5' ] );
		$this->add_dependecy( 'bg_color_fields', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4', 'layout5' ] );
		$this->add_dependecy( 'border_color_error', 'template', [ 'view', 'layout1', 'layout5' ] );

		$this->add_dependecy( 'title_typo', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ]  );
		$this->add_dependecy( 'title_typo', 'use_title_typo', 'true' );


		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params([
			'title'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Title', 'aheto' ),
			],
			'use_title_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 4,
			],
			'underline'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable underline for title?', 'aheto' ),
				'grid'    => 4,
			],
			'title_space'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable smaller space after title?', 'aheto' ),
				'grid'    => 4,
			],
			'contact_form'       => [
				'type'    => 'text',
				'heading' => esc_html__( 'Contact Form', 'aheto' ),
				'description' => esc_html__( 'Add your form id from shortcode Contact Form 7 Plugin.', 'aheto' ),
			],
			'count_input'    => [
				'type'     => 'select',
				'heading'  => esc_html__( 'Max inputs per row', 'aheto' ),
				'options'  => [
					'four'       => esc_html__( 'Four', 'aheto' ),
					'two' => esc_html__( 'Two', 'aheto' ),
				],
				'grid'     => 6,
			],
			'border_radius_input'  => [
				'type'    => 'text',
				'heading' => esc_html__( 'Border radius for fields', 'aheto' ),
				'description' => esc_html__( 'Enter border radius for fields. Value must be with unit. For example: 5px', 'aheto' ),
				'selectors' => [
					'{{WRAPPER}}:not(.aheto__cf--line) select' => 'border-radius: {{VALUE}}',
					'{{WRAPPER}}:not(.aheto__cf--line) textarea' => 'border-radius: {{VALUE}}',
					'{{WRAPPER}}:not(.aheto__cf--line) input:not([type="submit"])' => 'border-radius: {{VALUE}}',
					'{{WRAPPER}}.aheto__cf--line p' => 'border-radius: {{VALUE}}',
				],
				'grid'    => 6,
			],
			'full_width_button'     => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Enable full width button?', 'aheto' ),
				'grid'    => 6,
			],
			'border_radius_button'  => [
				'type'    => 'text',
				'heading' => esc_html__( 'Border radius for button', 'aheto' ),
				'description' => esc_html__( 'Enter border radius for button. Value must be with unit. For example: 5px', 'aheto' ),
				'selectors' => [ '{{WRAPPER}} input[type="submit"]' => 'border-radius: {{VALUE}}' ],
				'grid'    => 6,
			],
			'button_align'    => [
				'type'     => 'select',
				'heading'  => esc_html__( 'Button align', 'aheto' ),
				'options'  => [
					'center'       => esc_html__( 'Center', 'aheto' ),
					'left' => esc_html__( 'Left', 'aheto' ),
					'right' => esc_html__( 'Right', 'aheto' ),
				],
				'grid'     => 12,
				'description' => esc_html__( 'This options for not full width button', 'aheto' ),
			],
			'bg_color_fields'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__( 'Background color for text fields', 'aheto' ),
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} input:not([type="submit"]), {{WRAPPER}} textarea, {{WRAPPER}} select' => 'background: {{VALUE}}' ],
			],
			'border_color_error'    => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Border and text error color', 'aheto'),
				'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors' => 'border-color: {{VALUE}}; color: {{VALUE}};'],
			],
			'description' => [
				'type'    => 'textarea',
				'heading' => esc_html__( 'Description', 'aheto' ),
			],

		]);

		$form_button = array(
			'add_button' => false,
			'link'       => false,
			'prefix'     => 'form_',
			'layouts'    => 'layout1',
			'dependency' => ['template', ['view', 'layout1', 'layout4', 'layout5']]
		);

		$form_button = apply_filters( "aheto_button_contact-forms",  $form_button );

		Params::add_button_params($this, $form_button);

		$this->add_params([
			'title_typo' => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .widget_aheto__title',
			],
			'advanced'  => true,
		]);

	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( !empty($this->atts['use_title_typo']) && ! empty( $this->atts['title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .widget_aheto__title'], $this->parse_typography( $this->atts['title_typo'] ) );
		}

		if ( ! empty( $this->atts['bg_color_fields'] ) ) {
			$css['global']['%1$s textarea, %1$s select, %1$s input:not([type="submit"])']['background'] = Sanitize::color( $this->atts['bg_color_fields'] );
		}

		if ( !empty($this->atts['border_radius_input']) ) {
			$css['global'][
				'%1$s:not(.aheto__cf--line) textarea,
				 %1$s:not(.aheto__cf--line) select,
				 %1$s:not(.aheto__cf--line) input:not([type="submit"]),
				 %1$s.aheto__cf--line p'
			]['border-radius'] =  Sanitize::size( $this->atts['border_radius_input'] );
		}

		if ( !empty($this->atts['border_radius_button']) ) {
			$css['global']['%1$s input[type="submit"]']['border-radius'] = Sanitize::size( $this->atts['border_radius_button'] );
		}

		if (isset($this->atts['border_color_error']) && !empty($this->atts['border_color_error'])) {
			$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($this->atts['border_color_error']);
			$css['global']['%1$s div.wpcf7-validation-errors']['color'] = \Aheto\Sanitize::color($this->atts['border_color_error']);
		}

		return apply_filters( "aheto_contact_forms_dynamic_css", $css, $this );
	}
}
