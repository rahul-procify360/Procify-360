<?php
/**
 * The String helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;
use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Strings class.
 */
trait Strings {

	/**
	 * Check if the string begins with the given value.
	 *
	 * @param  string $needle   The sub-string to search for.
	 * @param  string $haystack The string to search.
	 * @return boolean
	 */
	public static function str_start_with( $needle, $haystack ) {
		return substr_compare( $haystack, $needle, 0, strlen( $needle ) ) === 0;
	}

	/**
	 * Check if the string end with the given value.
	 *
	 * @param  string $needle   The sub-string to search for.
	 * @param  string $haystack The string to search.
	 * @return boolean
	 */
	public static function str_end_with( $needle, $haystack ) {
		return substr_compare( $haystack, $needle, -strlen( $needle ) ) === 0;
	}

	/**
	 * Check if the string contains the given value.
	 *
	 * @param  string $needle   The sub-string to search for.
	 * @param  string $haystack The string to search.
	 * @return boolean
	 */
	public static function str_contains( $needle, $haystack ) {
		return strpos( $haystack, $needle ) !== false;
	}

	/**
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param  string $size The size.
	 * @return int
	 */
	public static function let_to_num( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );

		// @codingStandardsIgnoreStart
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		// @codingStandardsIgnoreEnd

		return $ret;
	}


	/**
	 * This function return bool for check memory_limit value.
	 * @return bool
	 */
	public static function get_et(){
		return ini_get( 'max_execution_time' ) >= 60 ? true : false;
	}


	/**
	 * This function return bool for check memory_limit value.
	 * @return bool
	 */
	public static function get_ml(){

		$ini_all = ini_get_all();
		$limit = str_replace(array('G', 'M', 'K'), array('000000000', '000000', '000'), $ini_all[ 'memory_limit' ][ 'global_value' ]);

		return ($limit >= 256000000);
	}

	/**
	 * Convert a number to K, M, B, etc.
	 *
	 * @param  int|double $number Number which to convert to pretty string.
	 * @return string
	 */
	public static function human_number( $number ) {

		if ( ! is_numeric( $number ) ) {
			return 0;
		}

		$negative = '';
		if ( abs( $number ) != $number ) {
			$negative = '-';
			$number   = abs( $number );
		}

		if ( $number < 1000 ) {
			return $number;
		}

		$unit  = intval( log( $number, 1000 ) );
		$units = [ '', 'K', 'M', 'B', 'T', 'Q' ];

		if ( array_key_exists( $unit, $units ) ) {
			return sprintf( '%s%s%s', $negative, rtrim( number_format( $number / pow( 1000, $unit ), 1 ), '.0' ), $units[ $unit ] );
		}

		return $number;
	}
}
