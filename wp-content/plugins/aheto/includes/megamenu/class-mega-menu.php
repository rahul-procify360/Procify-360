<?php
/**
 * The Mega-Menu functionality
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Mega_Menu class.
 */
class Mega_Menu {

	use Hooker;

	/**
	 * The Constructor
	 */
	public function __construct() {
		if ( ! is_customize_preview() ) {
			$this->action( 'wp_update_nav_menu_item', 'update_custom_nav_fields', 110, 3 );
		}

		$this->action( 'admin_enqueue_scripts', 'enqueue', 25 );
		$this->filter( 'wp_setup_nav_menu_item', 'setup_nav_menu_item', 110 );
		$this->filter( 'wp_edit_nav_menu_walker', 'add_custom_fields', 110 );
	}

	/**
	 * Enqueue css and javascript.
	 */
	public function enqueue() {
		$screen = get_current_screen();
		if ( 'nav-menus' !== $screen->base ) {
			return;
		}

		$dir = aheto()->plugin_url() . 'includes/megamenu/assets/';
		wp_enqueue_style( 'aheto-nav-menus', $dir . 'nav-menu.css', null, aheto()->version );
		wp_enqueue_script( 'aheto-nav-menus', $dir . 'nav-menu.js', [ 'jquery' ], aheto()->version, true );
		wp_dequeue_script( 'karma_mega_menu' );
	}

	/**
	 * Function to replace normal edit nav walker for fusion core mega menus.
	 *
	 * @return string Class name of new navwalker
	 */
	public function add_custom_fields() {
		return '\\Aheto\\Admin\\Megamenu_Edit_Walker';
	}

	/**
	 * Add custom fields to $item nav object in order to be used in custom Walker.
	 *
	 * @param object $menu_item The menu item object.
	 *
	 * @return object The menu item.
	 */
	public function setup_nav_menu_item( $menu_item ) {

		$menu_item->is_image        = get_post_meta( $menu_item->ID, '_menu_item_is_image', true );
		$menu_item->icon        = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
		$menu_item->is_megamenu = boolval( get_post_meta( $menu_item->ID, '_menu_item_is_megamenu', true ) );

		return $menu_item;
	}

	/**
	 * Add the custom megamenu fields menu item data to fields in database.
	 *
	 * @param string|int $menu_id         The menu ID.
	 * @param string|int $menu_item_db_id The menu ID from the db.
	 * @param array      $args            The arguments array.
	 */
	public function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

		if ( isset( $_REQUEST['menu-item-megamenu'] ) && is_array( $_REQUEST['menu-item-megamenu'] ) ) {
			$value = isset( $_REQUEST['menu-item-megamenu'][ $menu_item_db_id ] ) ? boolval( $_REQUEST['menu-item-megamenu'][ $menu_item_db_id ] ) : 0;
			$value = empty( $value )  ? false : $value;
			update_post_meta( $menu_item_db_id, '_menu_item_is_megamenu', $value );
		}
		else {
			update_post_meta( $menu_item_db_id, '_menu_item_is_megamenu', 0 );
		}

		if ( isset( $_REQUEST['menu-item-image'] ) && is_array( $_REQUEST['menu-item-image'] ) ) {
			$value = isset( $_REQUEST['menu-item-image'][ $menu_item_db_id ] ) ? boolval( $_REQUEST['menu-item-image'][ $menu_item_db_id ] ) : 0;
			$value = empty( $value )  ? false : $value;
			update_post_meta( $menu_item_db_id, '_menu_item_is_image', $value );
		}
		else {
			update_post_meta( $menu_item_db_id, '_menu_item_is_image', 0 );
		}

		if ( isset( $_REQUEST['menu-item-icon'] ) && is_array( $_REQUEST['menu-item-icon'] ) ) {
			$value = isset( $_REQUEST['menu-item-icon'][ $menu_item_db_id ] ) ? $_REQUEST['menu-item-icon'][ $menu_item_db_id ] : 0;
			update_post_meta( $menu_item_db_id, '_menu_item_icon', $value );
		}

	}
}
