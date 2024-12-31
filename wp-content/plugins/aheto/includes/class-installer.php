<?php
/**
 * Fired during plugin activation.
 *
 * Installation related functions and actions.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Installer class.
 */
class Installer {

	use Hooker;

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param boolean $network_wide True  if WPMU superadmin uses "Network Activate" action,
	 *                              False if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function install( $network_wide ) {
		new Installer( $network_wide );
	}

	/**
	 * The Constructor
	 *
	 * @param bool $network_wide Is network wide activated.
	 */
	protected function __construct( $network_wide ) {

		$this->action( 'wpmu_new_blog', 'activate_new_blog' );
		$this->filter( 'wpmu_drop_tables', 'on_delete_blog' );

		if ( function_exists( 'is_multisite' ) && is_multisite() && $network_wide ) {

			$blog_ids = $this->get_blog_ids();
			if ( ! empty( $blog_ids ) ) {
				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					$this->activate();
				}
				restore_current_blog();
			}
		} else {
			$this->activate();
		}

		add_action( 'admin_init', 'flush_rewrite_rules', 11, 0 );
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @param int $blog_id ID of the new blog.
	 */
	public function activate_new_blog( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		$this->activate();
		restore_current_blog();
	}

	/**
	 *  Drop tables when MU blog is being deleted.
	 *
	 * @param  array $tables List of tables that will be deleted by WP.
	 * @return array
	 */
	public function on_delete_blog( $tables ) {
		global $wpdb;

		return $tables;
	}

	/**
	 * Placeholder for activation function.
	 *
	 * Fired for each blog when the plugin is activated.
	 */
	private function activate() {

		// Update to latest version.
		add_option( 'aheto_redirect_about', true );
		add_option( 'aheto_version', \aheto()->version );
		add_option( 'aheto_db_version', \aheto()->db_version );
	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @return array|false The blog ids, false if no matches.
	 */
	private function get_blog_ids() {
		global $wpdb;

		return $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE archived = '0' AND spam = '0' AND deleted = '0'" );
	}

	/**
	 * Check if table exists in db or not.
	 *
	 * @param  string $table_name Table name to check for existance.
	 * @return bool
	 */
	private function check_table_exists( $table_name ) {
		global $wpdb;

		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) ) ) === $table_name ) {
			return true;
		}

		return false;
	}

}
