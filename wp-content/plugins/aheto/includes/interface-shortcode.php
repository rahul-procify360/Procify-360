<?php
/**
 * The Shortcode interface
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

defined( 'ABSPATH' ) || exit;

/**
 * Interface for shortcode to force consistency.
 */
interface IShortcode {

	/**
	 * Register the shortcode
	 */
	public function register();

	/**
	 * Set map for the builder
	 */
	public function set_map();

	/**
	 * Parse group values.
	 *
	 * @param string $atts Group value to parse.
	 */
	public function parse_group( $atts );
}
