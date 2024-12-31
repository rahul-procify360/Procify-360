<?php
/**
 * The Conditional helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * Conditional class.
 */
trait Conditional {

	/**
	 * Check if the request is heartbeat.
	 *
	 * @return boolean
	 */
	public static function is_heartbeat() {
		if ( isset( $_POST ) && isset( $_POST['action'] ) && 'heartbeat' === $_POST['action'] ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if its an ajax request.
	 *
	 * @return boolean
	 */
	public static function is_ajax() {
		return defined( 'DOING_AJAX' );
	}

	/**
	 * Check if we need setup wizard.
	 *
	 * @return boolean
	 */
	public static function is_setup_wizard() {
		return apply_filters( 'aheto_enable_setup_wizard', true );
	}

	/**
	 * Is WooCommerce Installed
	 *
	 * @return bool
	 */
	public static function is_woocommerce_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}


	/**
	 * Check if IE
	 */
	public static function checkIE() {
		$ua = htmlentities( $_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8' );
		if ( preg_match( '~MSIE|Internet Explorer~i', $ua ) || ( strpos( $ua, 'Trident/7.0' ) !== false && strpos( $ua, 'rv:11.0' ) !== false ) ) {
			return true;
		}
		return false;
	}


}
