<?php
/**
 * The Finish wizard.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Helpers\Color;

defined( 'ABSPATH' ) || exit;

/**
 * Finish_Wizard class.
 */
class Finish_Wizard {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$settings   = get_option( 'current_theme_in_progress' );

		$name       = 'style' . date( '_dm' );
		$label      = 'Style ' . date( 'dm' );
		$this->data = include_once aheto()->plugin_dir() . 'includes/skin/skins-data.php';

		$this->set_color_scheme( $settings['color'] );
		$this->set_typography_scheme( $settings['typography'] );

		// Init Skin.
		$this->skin = array_merge(
			[
				'name'           => $name,
				'primary_font'   => [ 'font-family' => $this->get_typography( 'primary' ) ],
				'secondary_font' => [ 'font-family' => $this->get_typography( 'secondary' ) ],
				'tertiary_font'  => [ 'font-family' => $this->get_typography( 'tertiary' ) ],
			],
			$this->colors
		);
		$this->set_headings( $settings['typography'] );
		$this->set_paragraph( $settings['typography'] );
		$this->set_subtitle_font( $settings['typography'] );
		$this->set_link( $settings['typography'] );
		$this->set_button( $settings['typography'] );
		$this->set_testimonial( $settings['typography'] );

		$this->skin['widget_title'] = [
			'font-family'    => $this->get_typography( 'primary' ),
			'font-weight'    => '700',
			'text-transform' => 'uppercase',
			'font-size'      => '14px',
			'line-height'    => '24px',
			'letter-spacing' => '2px',
			'color'          => $this->get_color( 'white' ),
			'margin-top'     => '',
			'margin-bottom'  => '50px',
		];

		$this->skin['widget_title_border'] = [
			'top'    => '',
			'right'  => '',
			'bottom' => '',
			'left'   => '',
			'style'  => 'none',
			'color'  => '#',
		];

		$this->skin['widget_title_padding'] = [
			'top'    => '',
			'right'  => '',
			'bottom' => '3',
			'left'   => '',
			'units'  => 'px',
		];

		Skin_Generator::update_skin_choices( $name, $label );
		Skin_Generator::update_skin_options( $name, $this->skin );
		update_option( 'aheto-skin-generator', $this->skin );
		cmb2_options( 'aheto-general-settings' )->update( 'skin', $name, true );
	}

	/**
	 * Get color.
	 *
	 * @param string $id ID to get.
	 *
	 * @return string
	 */
	private function get_color( $id ) {
		if ( '' === $id ) {
			return '';
		}

		if ( 'white' === $id || '#ffffff' === $id ) {
			return '#ffffff';
		}

		if ( 'transparent' === $id ) {
			return 'transparent';
		}

		return $this->colors[ $id ];
	}

	/**
	 * Get typography.
	 *
	 * @param string $id ID to get.
	 *
	 * @return string
	 */
	private function get_typography( $id ) {
		return $this->typography[ "{$id}_font" ];
	}

	/**
	 * Set color scheme.
	 *
	 * @param string $id Color scheme id.
	 */
	private function set_color_scheme( $id ) {
		$this->colors = $this->data['colors'][ $id ];
	}

	/**
	 * Set typography scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_typography_scheme( $id ) {
		$this->typography = $this->data['typography'][ $id ];
	}

	/**
	 * Set subtitle font scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_subtitle_font( $id ) {
		$scheme = $this->data['subtitle_font'][ $id ];

		$this->skin['subtitle_font'] = [
			'font-weight'    => $scheme['font-weight'],
			'font-size'      => $scheme['font-size'],
			'letter-spacing' => $scheme['letter-space'],
			'margin-bottom'  => $scheme['margin-bottom'],
		];
	}

	/**
	 * Set heading scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_headings( $id ) {
		$scheme = $this->data['headings'][ $id ];

		$this->skin['headings'] = [
			'font-family'    => $this->get_typography( $scheme['h-font-family'] ),
			'font-weight'    => $scheme['h-fnt-wgt'],
			'letter-spacing' => $scheme['h-ltr-spacing'],
			'color'          => $this->get_color( $scheme['h-color'] ),
		];

		$this->skin['heading1'] = [
			'font-size'   => $scheme['h1-fnt-size'],
			'line-height' => $scheme['h1-ln-height'],
			'letter-spacing' => $scheme['h1-ltr-spacing'],
		];

		$this->skin['heading2'] = [
			'font-size'   => $scheme['h2-fnt-size'],
			'line-height' => $scheme['h2-ln-height'],
			'letter-spacing' => $scheme['h2-ltr-spacing'],
		];

		$this->skin['heading3'] = [
			'font-size'   => $scheme['h3-fnt-size'],
			'line-height' => $scheme['h3-ln-height'],
			'letter-spacing' => $scheme['h3-ltr-spacing'],
		];

		$this->skin['heading4'] = [
			'font-size'   => $scheme['h4-fnt-size'],
			'line-height' => $scheme['h4-ln-height'],
			'letter-spacing' => $scheme['h4-ltr-spacing'],
		];

		$this->skin['heading5'] = [
			'font-size'   => $scheme['h5-fnt-size'],
			'line-height' => $scheme['h5-ln-height'],
			'letter-spacing' => $scheme['h5-ltr-spacing'],
		];

		$this->skin['heading6'] = [
			'font-size'   => $scheme['h6-fnt-size'],
			'line-height' => $scheme['h6-ln-height'],
			'letter-spacing' => $scheme['h6-ltr-spacing'],
		];
	}

	/**
	 * Set paragraph scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_paragraph( $id ) {
		$scheme = $this->data['paragraph'][ $id ];

		$this->skin['paragraph_font'] = [
			'font-family'    => $this->get_typography( $scheme['fnt-family'] ),
			'font-size'      => $scheme['fnt-size'],
			'line-height'    => $scheme['ln-height'],
			'letter-spacing' => $scheme['ltr-spng'],
			'color'          => $this->get_color( $scheme['color'] ),
		];
	}

	/**
	 * Set link scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_link( $id ) {
		$scheme = $this->data['links'][ $id ];

		$this->skin['links'] = [
			'font-family'    => $this->get_typography( $scheme['fnt-family'] ),
			'font-weight'    => $scheme['fnt-wgt'],
			'font-size'      => $scheme['fnt-size'],
			'letter-spacing' => $scheme['ltr-spng'],
			'color'          => $this->get_color( $scheme['color'] ),
		];
	}

	/**
	 * Set testimonial scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_testimonial( $id ) {
		$scheme = $this->data['testimonial'][ $id ];

		$this->skin['testimonial_padding'] = [
			'top'    => '70px',
			'right'  => '100px',
			'bottom' => '40px',
			'left'   => '100px',
			'units'  => 'px',
		];

		$this->skin['testimonial_bg']           = $this->get_color( $scheme['background'] );
		$this->skin['testimonial_avatar_size']  = '50px';
		$this->skin['testimonial_author_color'] = $this->get_color( $scheme['author_color'] );
		$this->skin['testimonial_author_size']  = $scheme['author_size'];
		$this->skin['testimonial_star_color']   = $this->get_color( 'alter' );
	}

	/**
	 * Set button scheme.
	 *
	 * @param string $id Typography scheme id.
	 */
	private function set_button( $id ) {
		$scheme    = $this->data['buttons'][ $id ];
		$button    = $scheme['button'];
		$big       = $scheme['big'];
		$large     = $scheme['large'];
		$small     = $scheme['small'];
		$inline    = $scheme['inline'];
		$dark      = $scheme['dark'];
		$light     = $scheme['light'];
		$circle    = $scheme['circle'];
		$gradient  = $scheme['gradient'];
		$secondary = $scheme['secondary'];

		$this->skin['button'] = [
			[
				'background'      => $this->get_color( $button['background'] ),
				'icon_size'       => $button['icon_size'],
				'icon_size_large' => $button['icon_size_large'],
				'icon_margin'     => $button['icon_margin'],
				'border_radius'   => $button['border_radius'],
				'font'            => [
					'font-family'    => $this->get_typography( $button['font']['font-family'] ),
					'font-weight'    => $button['font']['font-weight'],
					'font-size'      => $button['font']['font-size'],
					'line-height'    => $button['font']['line-height'],
					'letter-spacing' => $button['font']['letter-spacing'],
					'color'          => $this->get_color( $button['font']['color'] ),
				],
				'padding'         => [
					'vertical'   => $button['padding']['vertical'],
					'horizontal' => $button['padding']['horizontal'],
					'units'      => $button['padding']['units'],
				],
				'mobile_padding'        => [
					'vertical'   => $large['mobile_padding']['vertical'],
					'horizontal' => $large['mobile_padding']['horizontal'],
					'units'      => $large['mobile_padding']['units'],
				],
				'border'          => [
					'all'   => $button['border']['all'],
					'style' => $button['border']['style'],
					'color' => Color::setAlpha( $this->get_color( $button['border']['color'] ), $button['border']['opacity'] ),
				],
				'box_shadow'      => [
					'voffset' => $button['box_shadow']['voffset'],
					'hoffset' => $button['box_shadow']['hoffset'],
					'blur'    => $button['box_shadow']['blur'],
					'spread'  => $button['box_shadow']['spread'],
					'color'   => Color::setAlpha( $this->get_color( $button['box_shadow']['color'] ), $button['box_shadow']['opacity'] ),
					'inset'   => $button['box_shadow']['inset'],
				],
			],
		];

		$this->skin['button_large'] = [
			[
				'font_size'      => $large['font_size'],
				'letter_spacing' => $large['letter_spacing'],
				'padding'        => [
					'vertical'   => $large['padding']['vertical'],
					'horizontal' => $large['padding']['horizontal'],
					'units'      => $large['padding']['units'],
				],
				'mobile_padding'        => [
					'vertical'   => $large['mobile_padding']['vertical'],
					'horizontal' => $large['mobile_padding']['horizontal'],
					'units'      => $large['mobile_padding']['units'],
				],
			],
		];

		$this->skin['button_small'] = [
			[
				'font_size'      => $small['font_size'],
				'letter_spacing' => $small['letter_spacing'],
				'padding'        => [
					'vertical'   => $small['padding']['vertical'],
					'horizontal' => $small['padding']['horizontal'],
					'units'      => $small['padding']['units'],
				],
			],
		];

		$this->skin['button_inline'] = [
			[
				'font_size'      => $inline['font_size'],
				'letter_spacing' => $inline['letter_spacing'],
				'weight'         => $inline['weight'],
			],
		];

		$this->skin['button_secondary'] = [
			[
				'background' => $this->get_color( $secondary['background'] ),
				'border'     => $secondary['border'],
				'color'      => $this->get_color( $secondary['color'] ),
				'box_shadow' => [
					'voffset' => $secondary['box_shadow']['voffset'],
					'hoffset' => $secondary['box_shadow']['hoffset'],
					'blur'    => $secondary['box_shadow']['blur'],
					'spread'  => $secondary['box_shadow']['spread'],
					'color'   => $this->get_color( $secondary['box_shadow']['color'] ),
					'inset'   => $secondary['box_shadow']['inset'],
				],
			],
		];

		$this->skin['button_light'] = [
			[
				'background' => $this->get_color( $light['background'] ),
				'border'     => $light['border'],
				'color'      => $this->get_color( $light['color'] ),
				'box_shadow' => [
					'voffset' => $light['box_shadow']['voffset'],
					'hoffset' => $light['box_shadow']['hoffset'],
					'blur'    => $light['box_shadow']['blur'],
					'spread'  => $light['box_shadow']['spread'],
					'color'   => $this->get_color( $light['box_shadow']['color'] ),
					'inset'   => $light['box_shadow']['inset'],
				],
			],
		];

		$this->skin['button_dark'] = [
			[
				'background' => $this->get_color( $dark['background'] ),
				'border'     => $dark['border'],
				'color'      => $this->get_color( $dark['color'] ),
				'box_shadow' => [
					'voffset' => $dark['box_shadow']['voffset'],
					'hoffset' => $dark['box_shadow']['hoffset'],
					'blur'    => $dark['box_shadow']['blur'],
					'spread'  => $dark['box_shadow']['spread'],
					'color'   => $this->get_color( $dark['box_shadow']['color'] ),
					'inset'   => $dark['box_shadow']['inset'],
				],
			],
		];

		$this->skin['button_gradient'] = [
			[
				'circle'     => $gradient['circle'],
				'default'    => $gradient['default'],
				'box_shadow' => [
					'voffset' => $gradient['box_shadow']['voffset'],
					'hoffset' => $gradient['box_shadow']['hoffset'],
					'blur'    => $gradient['box_shadow']['blur'],
					'spread'  => $gradient['box_shadow']['spread'],
					'color'   => $gradient['box_shadow']['color'],
					'inset'   => $gradient['box_shadow']['inset'],
				],
			],
		];

		$this->skin['button_big'] = [
			[
				'font_size'      => $big['font_size'],
				'letter_spacing' => $big['letter_spacing'],
				'padding'        => [
					'top'    => $big['padding']['top'],
					'right'  => $big['padding']['right'],
					'bottom' => $big['padding']['bottom'],
					'left'   => $big['padding']['left'],
					'units'  => $big['padding']['units'],
				],
			],
		];

		$this->skin['button_circle'] = [
			[
				'width'      => $circle['width'],
				'height'     => $circle['height'],
				'icon_size'  => $circle['icon_size'],
				'box_shadow' => [
					'voffset' => $circle['box_shadow']['voffset'],
					'hoffset' => $circle['box_shadow']['hoffset'],
					'blur'    => $circle['box_shadow']['blur'],
					'spread'  => $circle['box_shadow']['spread'],
					'color'   => Color::setAlpha( $circle['box_shadow']['color'], $circle['box_shadow']['opacity'] ),
					'inset'   => $circle['box_shadow']['inset'],
				],
			],
		];
	}
}
