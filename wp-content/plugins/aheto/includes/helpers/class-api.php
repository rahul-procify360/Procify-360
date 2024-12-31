<?php
/**
 * The Api helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Api class.
 */
trait Api {

	/**
	 * Add notification.
	 *
	 * @param string $message Message string.
	 * @param array  $options Set of options.
	 */
	public static function add_notification( $message, $options = [] ) {
		aheto()->notification->add( $message, $options );
	}

	/**
	 * Get Setting.
	 *
	 * @param  string $field_id The field id to get value for.
	 * @param  mixed  $default  The default value if no field found.
	 * @return mixed
	 */
	public static function get_settings( $field_id = '', $default = false ) {
		return aheto()->settings->get( $field_id, $default );
	}

	/**
	 * Add something to JSON object.
	 *
	 * @param string $key         Unique identifier.
	 * @param mixed  $value       The data itself can be either a single or an array.
	 * @param string $object_name Name for the JavaScript object. Passed directly, so it should be qualified JS variable.
	 */
	public static function add_json( $key, $value, $object_name = 'aheto' ) {
		aheto()->json->add( $key, $value, $object_name );
	}

	/**
	 * Remove something from JSON object.
	 *
	 * @param string $key         Unique identifier.
	 * @param string $object_name Name for the JavaScript object. Passed directly, so it should be qualified JS variable.
	 */
	public static function remove_json( $key, $object_name = 'aheto' ) {
		aheto()->json->remove( $key, $object_name );
	}

	/**
	 * Get icon data
	 *
	 * @param  array  $atts     Array of attributes to parse data from.
	 * @param  string $prefix   Prefix if any.
	 * @param  bool   $add_icon Add icon is set or not.
	 * @return array
	 */
	public static function get_icon_attributes( $atts, $prefix = '', $add_icon = false ) {
		$atts = shortcode_atts([
			$prefix . 'add_icon'              => false,
			$prefix . 'icon_font'             => 'font-awesome',
			$prefix . 'icon_elegant'          => false,
			$prefix . 'icon_font-awesome'     => false,
			$prefix . 'icon_ionicons'         => false,
			$prefix . 'icon_pe-icon-7-stroke' => false,
			$prefix . 'icon_themify'          => false,
			$prefix . 'icon_color'            => false,
			$prefix . 'icon_fz'            => false,
			$prefix . 'icon_align'            => false,
		], $atts );

		if ( $add_icon && 'true' !== $atts[ $prefix . 'add_icon' ] ) {
			return '';
		}

		$type       = $atts[ $prefix . 'icon_font' ];
		$icon_class = isset( $atts[ $prefix . 'icon_' . $type ] ) ? esc_attr( $atts[ $prefix . 'icon_' . $type ] ) : 'fa fa-adjust';
		$icon_color = isset( $atts[ $prefix . 'icon_color' ] ) ? $atts[ $prefix . 'icon_color' ] : '';
		$icon_fz = isset( $atts[ $prefix . 'icon_fz' ] ) ? $atts[ $prefix . 'icon_fz' ] : '';
		$icon_align = isset( $atts[ $prefix . 'icon_align' ] ) ? $atts[ $prefix . 'icon_align' ] : 'left';

		wp_enqueue_style( $type );

		return [
			'type'  => $type,
			'color' => $icon_color,
			'font_size' => $icon_fz,
			'icon'  => $icon_class,
			'align' => $icon_align,
		];
	}
}
