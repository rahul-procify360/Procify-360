<?php
/**
 * The HTML helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * HTML class.
 */
trait HTML {

	/**
	 * Generate html attribute string for array.
	 *
	 * @param array  $attributes   Contains key/value pair to generate a string.
	 * @param string $prefix       If you want to append a prefic before every key.
	 * @param bool   $remove_empty Remove empty values
	 * @return string
	 */
	public static function html_generate_attributes( $attributes = [], $prefix = '', $remove_empty = false ) {

		// Early Bail!
		if ( empty( $attributes ) ) {
			return false;
		}

		$rendered_attributes = [];
		foreach ( $attributes as $attribute_key => $attribute_values ) {
			if ( is_array( $attribute_values ) ) {
				$attribute_values = implode( ' ', $attribute_values );
			}

			if ( true === $attribute_values ) {
				$attribute_values = 'true';
			}

			if ( false === $attribute_values ) {
				$attribute_values = 'false';
			}

			if (
				$remove_empty &&
				(
					( is_array( $attribute_values ) && empty( $attribute_values ) ) ||
					'' === $attribute_values
				)
			) {
				continue;
			}

			$rendered_attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( $attribute_values ) );
		}

		return implode( ' ', $rendered_attributes );
	}

	/**
	 * Get tooltip html.
	 *
	 * @param  string $message Message to show in tooltip.
	 * @return string
	 */
	public static function get_tooltip( $message ) {
		return '<span class="aheto-tooltip"><em class="dashicons-before dashicons-editor-help"></em><span>' . $message . '</span></span>';
	}

	/**
	 * Generate CSS.
	 *
	 * @param  array $atts Array of attributes.
	 * @return string
	 */
	public static function generate_css( $atts ) {
		static $aheto_shortcode_css;
		if ( is_null( $aheto_shortcode_css ) ) {
			$aheto_shortcode_css = new \Aheto\Shortcode;
		}
		$aheto_shortcode_css->atts = $atts;

		$css = $aheto_shortcode_css->get_advanced_css_array();
		$css = \Aheto\Visual_Composer\Params\Shapes::add_css_array( $atts, $css );
		$css = self::dynamic_css_parser( $css );
		if ( '%1$s{}' === $css ) {
			$css = '';
		}

		if ( isset( $atts['content_width'] ) && ! empty( $atts['content_width'] ) ) {
			$css .= '@media only screen and (min-width: ' . \Aheto\Sanitize::size( $atts['content_width'] ) . '){ %1$s{ padding-right: calc((100vw - ' . \Aheto\Sanitize::size( $atts['content_width'] ) . ')/2) ;padding-left: calc((100vw - ' . \Aheto\Sanitize::size( $atts['content_width'] ) . ')/2);}}';
		}

		$custom_css = isset( $aheto_shortcode_css->atts['custom_css'] ) ? trim( $aheto_shortcode_css->atts['custom_css'] ) : '';
		if ( empty( $css ) && empty( $custom_css ) ) {
			return;
		}

		$css        = str_replace( '%1$s', 'selector', $css );
		$css        = str_replace( '%', '%%', $css );
		$custom_css = str_replace( 'selector', '%1$s', $custom_css . $css );

		return sprintf( "<style type=\"text/css\">{$custom_css}</style>", '.' . $aheto_shortcode_css->atts['_id'] );
	}

	/**
	 * Get the array of dynamically-generated CSS and convert it to a string.
	 * Parses the array and adds quotation marks to font families and prefixes for browser-support.
	 *
	 * @param  array $css The CSS array.
	 * @return string
	 */
	public static function dynamic_css_parser( $css ) {

		// Prefixes.
		foreach ( $css as $media_query => $elements ) {

			foreach ( $elements as $element => $style_array ) {

				foreach ( (array) $style_array as $property => $value ) {

					if ( false === $value || '' === $value ) {
						continue;
					}

					// @codingStandardsIgnoreStart

					// Font family.
					if ( 'font-family' === $property ) {

						if ( false === strpos( $value, ',' ) && false === strpos( $value, "'" ) && false === strpos( $value, '"' ) ) {
							$value = "'" . $value . "'";
						}
						$css[ $media_query ][ $element ]['font-family'] = $value;
					}

					// Transform.
					elseif ( 'transform' == $property ) {
						$css[ $media_query ][ $element ]['-webkit-transform'] = $value;
						$css[ $media_query ][ $element ]['-ms-transform']     = $value;
					}

					// Transition.
					elseif ( 'transition' == $property ) {
						$css[ $media_query ][ $element ]['-webkit-transition'] = $value;
					}

					// Transition-property.
					elseif ( 'transition-property' == $property ) {
						$css[ $media_query ][ $element ]['-webkit-transition-property'] = $value;
					}

//					 Linear-gradient.
					elseif ( is_array( $value ) ) {
						foreach ( $value as $subvalue ) {
							if ( false !== strpos( $subvalue, 'linear-gradient' ) ) {
								$css[ $media_query ][ $element ][ $property ][] = '-webkit-' . $subvalue;
							} // calc.
							elseif ( 0 === stripos( $subvalue, 'calc' ) ) {
								$css[ $media_query ][ $element ][ $property ][] = '-webkit-' . $subvalue;
							}
						}
					}

					// @codingStandardsIgnoreEnd
				}
			}
		}

		/**
		 * Process the array of CSS properties and produce the final CSS.
		 */
		$final_css = '';
		foreach ( $css as $media_query => $styles ) {

			$final_css .= ( 'global' != $media_query ) ? $media_query . '{' : '';

			foreach ( $styles as $style => $style_array ) {

				if ( empty( $style_array ) ) {
					continue;
				}

				$final_css .= $style . '{';
				foreach ( (array) $style_array as $property => $value ) {

					if ( $value ) {
						if ( is_array( $value ) && ! empty( $value ) ) {
							foreach ( $value as $sub_value ) {
								$final_css .= $property . ':' . $sub_value . ';';
							}
						} else {
							$final_css .= $property . ':' . $value . ';';
						}
					}
				}
				$final_css .= '}';
			}

			$final_css .= ( 'global' != $media_query ) ? '}' : '';

		}

		return trim( $final_css );
	}
}
