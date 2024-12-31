<?php
/**
 * The Sanitize
 *
 * A collection of sanitization methods.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helpers\Color;

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize class.
 */
class Sanitize {

	/**
	 * Sanitize colors.
	 * Determine if the current value is a hex or an rgba color and call the appropriate method.
	 *
	 * @param  string|array $color The color.
	 * @param  string       $mode  The mode to be used.
	 * @return string
	 */
	public static function color( $color = '', $mode = 'auto' ) {

		if ( is_string( $color ) && 'transparent' === trim( $color ) ) {
			return 'transparent';
		}

		$obj = Color::newColor( $color );

		if ( 'auto' === $mode ) {
			$mode = $obj->mode;
		}

		return $obj->toCSS( $mode );

	}

	/**
	 * Santizie background.
	 *
	 * @param  array $value The background settings.
	 * @return array
	 */
	public static function background( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		$new_value = [];
		foreach ( $value as $key => $val ) {
			if ( empty( $val ) || 'off' === $val ) {
				continue;
			}

			switch ( $key ) {
				case 'image':
					$new_value[ 'background-' . $key ] = 'url(' . $val . ')';
					break;
				default:
					$new_value[ 'background-' . $key ] = $val;
			}
		}

		return $new_value;
	}

	/**
	 * Santizie typography.
	 *
	 * @param  array $value The typography settings.
	 * @return array
	 */
	public static function typography( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = $val;
					break;
				case 'font-weight':
					$variant = $value['font-weight'];

					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $variant, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = 'regular' === $variant || 'italic' === $variant ? 400 : absint( $variant );
					// Get font-style from variant.
					$value['font-style'] = false === strpos( $variant, 'italic' ) ? 'normal' : 'italic';
					break;
				case 'font-size':
					$newValue = '' === trim( $value[ $key ] ) ? '' : explode( ',' , $val );
					if ( is_array($newValue) && 1 === count( $newValue ) ) {
						$value[ $key ] = '' === trim( $newValue[0] ) ? '' : self::size( $newValue[0] );
					} else if( is_array($newValue) ) {
						$newValue['desktop'] = '' === $newValue[0] ? '' : self::size( $newValue[0] );
						$newValue['tablet'] = '' === $newValue[1] ? '' : self::size( $newValue[1] );
						$newValue['mobile'] = '' === $newValue[2] ? '' : self::size( $newValue[2] );
						$value[ $key ] = $newValue;
					}

					break;
				case 'line-height':
					$newValue = '' === trim( $value[ $key ] ) ? '' : explode( ',' , $val );
					if ( is_array($newValue) && 1 === count( $newValue ) ) {
						$value[ $key ] = '' === trim( $newValue[0] ) ? '' : self::size( $newValue[0], false );
					} elseif( is_array($newValue) ) {
						$newValue['desktop'] = '' === $newValue[0] ? '' : self::size( $newValue[0], false );
						$newValue['tablet'] = '' === $newValue[1] ? '' : self::size( $newValue[1], false );
						$newValue['mobile'] = '' === $newValue[2] ? '' : self::size( $newValue[2], false );
						$value[ $key ] = $newValue;
					}

					break;
				case 'letter-spacing':
					$newValue = '' === trim( $value[ $key ] ) ? '' : explode( ',' , $val );
					if ( is_array($newValue) && 1 === count( $newValue ) ) {
						$value[ $key ] = '' === trim( $newValue[0] ) ? '' : self::size( $newValue[0], false );
					} elseif( is_array($newValue) ) {
						$newValue['desktop'] = '' === $newValue[0] ? '' : self::size( $newValue[0], false );
						$newValue['tablet'] = '' === $newValue[1] ? '' : self::size( $newValue[1], false );
						$newValue['mobile'] = '' === $newValue[2] ? '' : self::size( $newValue[2], false );
						$value[ $key ] = $newValue;
					}
					break;
				case 'word-spacing':
				case 'margin-top':
				case 'margin-bottom':
					$value[ $key ] = '' === trim( $value[ $key ] ) ? '' : self::size( $val );
					break;
				case 'text-align':
					if ( ! in_array( $val, [ '', 'inherit', 'left', 'center', 'right', 'justify' ], true ) ) {
						$value['text-align'] = '';
					}
					break;
				case 'text-transform':
					if ( ! in_array( $val, [ '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}
					break;
				case 'text-decoration':
					if ( ! in_array( $val, [ '', 'none', 'underline', 'overline', 'line-through', 'initial', 'inherit' ], true ) ) {
						$value['text-decoration'] = '';
					}
					break;
				case 'color':
					$value['color'] = '' === $value['color'] || '#' === $value['color'] ? '' : self::color( $val );
					break;
				case 'color_hover':
					$value['color_hover'] = '';
					break;
			}
		}

		return $value;
	}

	/**
	 * Sanitize values like for example 10px, 30% etc.
	 *
	 * @param  string $value          The value to sanitize.
	 * @param  string $fallback_unit  The unit to add if none has.
	 * @return string
	 */
	public static function size( $value, $fallback_unit = 'px' ) {
		// Trim the value.
		$value = trim( $value );
		if ( in_array( $value, [ 'auto', 'inherit', 'initial' ], true ) ) {
			return $value;
		}

		// Return empty if there are no numbers in the value.
		// Prevents some CSS errors.
		if ( ! preg_match( '#[0-9]#', $value ) ) {
			return;
		}

		if ( false !== strpos( $value, 'calc' ) ) {
			return $value;
		}

		$unit = self::get_unit( $value );
		if ( $fallback_unit && '' === $unit ) {
			$unit = ( true === $fallback_unit ) ? 'px' : $fallback_unit;
		}
		return self::number( $value ) . $unit;

		// if ( is_numeric( $value ) ) {
		// 	return self::number( $value );
		// }
		//
		// return self::number( $value ) . self::get_unit( $value, $fallback_unit );
	}

	/**
	 * Sanitizes a number value.
	 *
	 * @param  string|int|float $value The value to sanitize.
	 * @return float|int
	 */
	public static function number( $value ) {
		return filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}

	/**
	 * Return the unit of a given value.
	 *
	 * @param  string $value     A value with unit.
	 * @return string The unit of the given value.
	 */
	public static function get_unit( $value ) {

		$unit_used = '';

		// Trim the value.
		$value = trim( $value );

		// The array of valid units.
		$units = [ 'px', 'rem', 'em', '%', 'vmin', 'vmax', 'vh', 'vw', 'ex', 'cm', 'mm', 'in', 'pt', 'pc', 'ch' ];

		foreach ( $units as $unit ) {
			// Find what unit we're using.
			if ( false !== strpos( $value, $unit ) ) {
				$unit_used = $unit;
				break;
			}
		}

		return $unit_used;
	}

	/**
	 * Sanitize values for spacing.
	 *
	 * @param  array  $value The value to sanitize.
	 * @param  string $type Type for spacing, either padding or margin.
	 * @return string
	 */
	public static function spacing( $value, $type = 'padding' ) {

		// All.
		if ( ! empty( $value['all'] ) ) {
			return [ $type => self::size( $value['all'], $value['units'] ) ];
		}

		// Vertical / Horizontal.
		$vertical   = ! empty( $value['vertical'] );
		$horizontal = ! empty( $value['horizontal'] );
		if ( $vertical || $horizontal ) {
			if ( $vertical && $horizontal ) {
				return [ $type => self::size( $value['vertical'], $value['units'] ) . ' ' . self::size( $value['horizontal'], $value['units'] ) ];
			}

			if ( $vertical ) {
				$value['vertical'] = self::size( $value['vertical'], $value['units'] );
				return [
					"{$type}-top"    => $value['vertical'],
					"{$type}-bottom" => $value['vertical'],
				];
			}
			if ( $horizontal ) {
				$value['horizontal'] = self::size( $value['horizontal'], $value['units'] );
				return [
					"{$type}-left"  => $value['horizontal'],
					"{$type}-right" => $value['horizontal'],
				];
			}
		}

		// All sides.
		$new_value = [];
		$type      = $type ? $type . '-' : '';
		foreach ( [ 'top', 'right', 'bottom', 'left' ] as $key ) {
			if ( ! isset( $value[ $key ] ) || '' === $value[ $key ] ) {
				continue;
			}

			$new_value[ "{$type}{$key}" ] = self::size( $value[ $key ], $value['units'] );
		}

		return $new_value;
	}

	/**
	 * Sanitize values for border-radius.
	 *
	 * @param  array $value The value to sanitize.
	 * @return string
	 */
	public static function border_radius( $value ) {

		$new_value = [];
		foreach ( [ 'top-left', 'top-right', 'bottom-left', 'bottom-right' ] as $key ) {
			if ( empty( $value[ $key ] ) ) {
				continue;
			}

			$new_value[ "border-{$key}-radius" ] = self::size( $value[ $key ], $value['units'] );
		}

		return $new_value;
	}

	/**
	 * Sanitize values for border.
	 *
	 * @param  array $value The value to sanitize.
	 * @return string
	 */
	public static function border( $value ) {

		$value = is_array($value) ? $value : array();
		
		if ( !isset($value['units']) || empty( $value['units'] ) ) {
			$value['units'] = 'px';
		}

		// Width.
		$new_value = self::spacing( $value, 'border' );

		// Style.
		$style = false;
		if ( ! empty( $value['style'] ) && 'none' !== $value['style'] ) {
			$style = $value['style'];
		}

		// Color.
		$color = false;
		if ( ! empty( $value['color'] ) && '#' !== $value['color'] ) {
			$color = self::color( $value['color'] );
		}

		// Output.
		if ( isset( $new_value['border'] ) ) {
			return [ 'border' => join( ' ', [ $new_value['border'], $style, $color ] ) ];
		}

		if ( 1 === count( $new_value ) ) {
			$key = key( $new_value );
			return [ $key => join( ' ', [ $new_value[ $key ], $style, $color ] ) ];
		}

		foreach ( $new_value as $id => $val ) {
			$new_value[ $id ] = join( ' ', [ $val, $style, $color ] );
		}

		return $new_value;
	}

	/**
	 * Sanitize values for box-shdadow.
	 *
	 * @param  array $value The value to sanitize.
	 * @return string
	 */
	public static function box_shadow( $value ) {
		$shadow = [];

		if ( ! isset( $value['hoffset'] ) || ! isset( $value['voffset'] ) || '' === $value['hoffset'] || '' === $value['voffset'] ) {
			return '';
		}

		$shadow[] = $value['inset'];
		$shadow[] = self::size( $value['hoffset'] );
		$shadow[] = self::size( $value['voffset'] );
		$shadow[] = self::size( $value['blur'] );
		$shadow[] = self::size( $value['spread'] );
		$shadow[] = self::color( $value['color'] );

		return join( ' ', array_filter( $shadow ) );
	}

	/**
	 * Parse responsive spacing value.
	 *
	 * @param  string $value Value to parse.
	 * @param  string $type  Type for spacing, either padding or margin.
	 * @return array
	 */
	public static function responsive_spacing( $value, $type = 'padding' ) {
		return \Aheto\Visual_Composer\Params\Responsive_Spacing::parse( $value, $type );
	}
}
