<?php
/**
 * The settings functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Traits\Hooker;
use Aheto\Admin\Options;

defined( 'ABSPATH' ) || exit;

/**
 * Settings class.
 */
class Settings {

	use Hooker;

	/**
	 * Hold option keys.
	 *
	 * @var array
	 */
	private $keys = [];

	/**
	 * Hold option data.
	 *
	 * @var array
	 */
	private $options = null;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'init', 'register', 5 );
		$this->filter( 'aheto_override_setting_value', 'override_setting_value', 10, 2 );
		$this->action( 'cmb2_save_options-page_fields_aheto-general-settings_options', 'check_updated_fields', 25, 3 );
	}

	/**
	 * Register Setting screen.
	 */
	public function register() {
		$file = aheto()->plugin_dir() . 'includes/settings/';
		$img = aheto()->assets() . 'admin/img/sidebar-icon/';
		/**
		 * Allow developers to add new section into general setting option panel.
		 *
		 * @param array $tabs
		 */
		$tabs = $this->do_filter( 'general_settings', [
			'general'     => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'General', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the general options.', 'aheto' ),
				'file'  => $file . 'general.php',
			],
			'blog'        => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'Blog', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the blog options.', 'aheto' ),
				'file'  => $file . 'blog.php',
			],
			'blocks'      => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'Elements', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the blocks options.', 'aheto' ),
				'file'  => $file . 'blocks.php',
			],
			'optimization'   => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'Optimization', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the optimization options.', 'aheto' ),
				'file'  => $file . 'optimization.php',
			],
			'preloader'   => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'Preloader', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the optimization options.', 'aheto' ),
				'file'  => $file . 'preloader.php',
			],
			'api-tools'   => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'API Tools', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the API options.', 'aheto' ),
				'file'  => $file . 'api-tools.php',
			],
			'custom-code' => [
				'icon'  => $img . 'settings.png',
				'title' => esc_html__( 'Custom code', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the custom css/js/html code.', 'aheto' ),
				'file'  => $file . 'custom-code.php',
			],
		] );

		new Options( [
			'prefix'     => 'general',
			'key'        => 'aheto-general-settings',
			'menu_icon'  => 'ion-android-options',
			'title'      => esc_html( 'Settings', 'aheto' ),
			'menu_title' => esc_html( 'Settings', 'aheto' ),
			'tabs'       => $tabs,
		] );


		$theme_tabs         = array();
		$theme_tabs         = apply_filters( "aheto_theme_options", $theme_tabs );

		if ( !empty($theme_tabs) ) {
			new Options( [
				'prefix'     => 'theme-options',
				'key'        => 'aheto-theme-options',
				'menu_icon'  => 'ion-android-settings',
				'title'      => esc_html( 'Theme options', 'aheto' ),
				'menu_title' => esc_html( 'Theme options', 'aheto' ),
				'tabs'       => $theme_tabs,
			] );
		}
	}

	/**
	 * Override setting value based on query string.
	 *
	 * @param  string $field_id Field id.
	 * @param  mixed $value Current value.
	 *
	 * @return mixed
	 */
	public function override_setting_value( $field_id, $value ) {

		$field_id = explode( '.', $field_id );
		$field_id = end( $field_id );
		if ( isset( $_GET[ $field_id ] ) && ! empty( $_GET[ $field_id ] ) ) {
			return $_GET[ $field_id ];
		}

		return $value;
	}

	/**
	 * Check if certain fields got updated.
	 *
	 * @param int $object_id The ID of the current object.
	 * @param array $updated Array of field ids that were updated.
	 *                         Will only include field ids that had values change.
	 * @param array $cmb This CMB2 object.
	 */
	public function check_updated_fields( $object_id, $updated, $cmb ) {

		if ( ! in_array( 'builder', $updated ) ) {
			return;
		}

		$installed = get_plugins();
		$plugins   = [
			'elementor'       => [
				'name'    => 'Elementor',
				'premium' => false,
				'file'    => 'elementor/elementor.php',
			],
			'visual-composer' => [
				'name'    => 'WPBakery',
				'premium' => true,
				'file'    => 'js_composer/js_composer.php',
			],
		];
		$plugin    = $plugins[ $cmb->data_to_save['builder'] ];

		new Generate_elementor_admin_css( $plugin );

		$status = true;
		if ( ! isset( $installed[ $plugin['file'] ] ) ) { // Install.
			$status = '%1$s is not installed. Please install the plugin.';
		} elseif ( is_plugin_inactive( $plugin['file'] ) ) { // Activate.
			$status = '%1$s is installed but not activated. Please activate the plugin.';
		}

		if ( true === $status ) {
			foreach ( $plugins as $slug => $deactivate ) {
				if ( $slug === $cmb->data_to_save['builder'] ) {
					continue;
				}

				deactivate_plugins( $deactivate['file'] );
			}

			return;
		}

		Helper::add_notification(
			sprintf( $status, $plugin['name'] ),
			[ 'type' => 'error' ]
		);
	}

	/**
	 * Get keys.
	 *
	 * @return array
	 */
	public function get_keys() {
		return $this->keys;
	}

	/**
	 * Get Setting.
	 *
	 * @param  string $field_id The field id to get value for.
	 * @param  mixed $default The default value if no field found.
	 *
	 * @return mixed
	 */
	public function get( $field_id = '', $default = false ) {
		$opts = $this->get_options();

		if ( empty( $opts ) ) {
			return $default;
		}

		$value = isset( $opts[ $field_id ] ) ? $opts[ $field_id ] : $default;

		return $this->do_filter( 'override_setting_value', $field_id, $value );
	}

	/**
	 * Get raw settings.
	 *
	 * @return array
	 */
	public function get_raw_settings() {
		$options = [];
		if ( ! empty( $this->keys ) ) {
			foreach ( $this->keys as $id => $key ) {
				$options[ $id ] = get_option( $key, [] );
			}
		}

		return $options;
	}

	/**
	 * Add new option data.
	 *
	 * @param string $key Option key.
	 * @param string $prefix Unique id.
	 */
	public function add_option( $key, $prefix ) {
		// Early Bail!
		if ( empty( $key ) || empty( $prefix ) ) {
			return;
		}

		$this->keys[ $prefix ] = $key;

		// Lazy-Load options.
		if ( ! is_null( $this->options ) ) {
			$this->get_from_storage( $key, $prefix );
		}
	}

	/**
	 * Get options once for use throughout the plugin cycle.
	 *
	 * @return array
	 */
	public function get_options() {
		if ( ! is_null( $this->options ) ) {
			return (array) $this->options;
		}

		if ( empty( $this->keys ) ) {
			return [];
		}

		foreach ( $this->keys as $prefix => $key ) {
			$this->get_from_storage( $key, $prefix );
		}

		return (array) $this->options;
	}

	/**
	 * Get option from database
	 *
	 * @param  string $key Option key.
	 * @param  string $prefix Prefix to add to option id.
	 */
	private function get_from_storage( $key, $prefix ) {
		$options = get_option( $key, [] );
		$options = $this->normalize_it( $options, $prefix );

		if ( is_null( $this->options ) ) {
			$this->options = [];
		}
		$this->options = array_merge( $this->options, $options );
	}

	/**
	 * Normalize option data
	 *
	 * @param  mixed $options Array to normalize.
	 * @param  string $prefix Prefix to add to option id.
	 *
	 * @return mixed
	 */
	private function normalize_it( $options, $prefix = '' ) {
		$data   = [];
		$prefix = $prefix ? $prefix . '.' : '';
		foreach ( (array) $options as $key => $value ) {
			$data[ $prefix . $key ] = is_array( $value ) ? $this->normalize_it( $value ) : $this->normalize_data( $value );
		}

		return $data;
	}

	/**
	 * Normalize option value.
	 *
	 * @param mixed $value Value to normalize.
	 *
	 * @return mixed
	 */
	public static function normalize_data( $value ) {

		if ( 'true' === $value || 'on' === $value ) {
			return true;
		}

		if ( 'false' === $value || 'off' === $value ) {
			return false;
		}

		if ( '0' === $value || '1' === $value ) {
			return intval( $value );
		}

		return $value;
	}
}
