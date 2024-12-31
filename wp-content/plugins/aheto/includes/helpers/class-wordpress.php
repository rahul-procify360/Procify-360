<?php
/**
 * The WordPress helpers.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Helpers
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Helpers;

defined( 'ABSPATH' ) || exit;

/**
 * WordPress class.
 */
trait WordPress {

	/**
	 * Get admin url.
	 *
	 * @param string $page Page name to get url for.
	 * @param array  $args Params to add as query string.
	 *
	 * @return string
	 */
	public static function get_admin_url( $page = '', $args = [] ) {
		$page = $page ? 'aheto-' . $page : 'aheto';
		$args = wp_parse_args( $args, [ 'page' => $page ] );

		return add_query_arg( $args, admin_url( 'admin.php' ) );
	}

	/**
	 * Get admin view file path.
	 *
	 * @param string $view View name to get.
	 *
	 * @return string
	 */
	public static function get_admin_view( $view ) {
		return aheto()->plugin_dir() . "includes/admin/views/{$view}.php";
	}

	/**
	 * Instantiates the WordPress filesystem for use.
	 *
	 * @return object
	 */
	public static function init_filesystem() {
		if ( ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
		}

		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		return $wp_filesystem;
	}

	/**
	 * Get current post type.
	 *
	 * This function has some fallback strategies to get the current screen post type.
	 *
	 * @return string|bool
	 */
	public static function get_post_type() {
		global $post, $typenow, $current_screen, $pagenow;

		if ( $post && $post->post_type ) {
			return $post->post_type;
		}

		if ( $typenow ) {
			return $typenow;
		}

		if ( $current_screen && $current_screen->post_type ) {
			return $current_screen->post_type;
		}

		if ( isset( $_REQUEST['post_type'] ) ) {
			return sanitize_key( $_REQUEST['post_type'] );
		}

		if ( isset( $_REQUEST['post_ID'] ) ) {
			return get_post_type( $_REQUEST['post_ID'] );
		}

		if ( isset( $_REQUEST['post_id'] ) ) {
			return get_post_type( $_REQUEST['post_id'] );
		}

		if ( isset( $_GET['post'] ) ) {
			return get_post_type( $_GET['post'] );
		}

		if ( 'post-new.php' === $pagenow ) {
			return 'post';
		}

		return false;
	}

	/**
	 * Get multiple post meta at once.
	 *
	 * @param integer $post_id Post ID to get meta for.
	 * @param array   $keys    Post meta keys.
	 * @param string  $prefix  Prefix for keys if any.
	 *
	 * @return array
	 */
	public static function get_post_metas( $post_id, $keys, $prefix = '' ) {
		$metas = [];
		foreach ( $keys as $key ) {
			$metas[ $key ] = get_post_meta( $post_id, $prefix . $key, true );
		}

		return $metas;
	}

	/**
	 * Get post meta.
	 *
	 * @param array   $key     Post meta key.
	 * @param integer $post_id Post ID to get meta for.
	 * @param string  $prefix  Prefix for keys if any.
	 *
	 * @return mixed
	 */
	public static function get_post_meta( $key, $post_id = null, $prefix = 'aheto_' ) {
		if ( is_null( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$value = get_post_meta( $post_id, $prefix . $key, true );

		return \Aheto\Settings::normalize_data( $value );
	}

	/**
	 * Get registered taxonomy typs.
	 *
	 * @return array
	 */
	public static function get_taxonomies_types() {
		global $aheto_taxonomies_types;
		if ( is_null( $aheto_taxonomies_types ) ) {
			$aheto_taxonomies_types = get_taxonomies( array( 'public' => true ), 'objects' );
		}

		return $aheto_taxonomies_types;
	}

	/**
	 * Get registered taxonomy list.
	 *
	 * @return array
	 */
	public static function get_taxonomies_list() {
		$data = [];
		$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

		foreach ($taxonomies as $key => $taxonomy) {
			$data[$key] = $taxonomy->label . ' (' . $key . ')';
		}

		return $data;
	}
}
