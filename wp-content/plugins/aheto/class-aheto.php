<?php
/**
 * Aheto
 *
 * @package      Aheto
 * @copyright    Copyright (C) 2018, UPQODE
 * @link         https://upqode.com
 *
 * @wordpress-plugin
 * Plugin Name:       Aheto
 * Version:           1.1.1.0.1
 * Plugin URI:        https://aheto.co
 * Description:       Beautifully designed templates for popular WordPress page builders from UPQODE
 * Author:            UPQODE
 * Author URI:        https://upqode.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aheto
 * Domain Path:       /i18n/languages
 */

defined( 'ABSPATH' ) || exit;

define( 'AHETO_FILE', __FILE__ );
defined( 'AHETO_URL' ) or define( 'AHETO_URL', plugins_url( 'aheto' ) );

add_action('admin_bar_menu', 'register_admin_bar_link', 99);


/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_aheto() {

	if ( ! class_exists( 'Appsero\Client' ) ) {
		require_once __DIR__ . '/vendor/appsero/client/src/Client.php';
	}

	$client = new Appsero\Client( '67d54f16-4a47-4afa-8a33-e658bb83fd16', 'Aheto', __FILE__ );

	// Active insights
	$client->insights()->init();

	// Active automatic updater
	$client->updater();

}

appsero_init_tracker_aheto();

/*
 * Uncomment when need not manually process of deactivating layouts
add_action( 'save_post', 'action_function_name', 10, 2 );
/**
 * Function saving layouts info in db
 *
 * @param $post_ID
 * @param $post
function action_function_name( $post_ID, $post ) {
	$a = str_replace('\"', '"' , $_POST['actions']);
	$data = json_decode( $a );
	$layouts = [];
	$current_options  =  get_option('aheto-layouts');
	foreach ($data->save_builder->data->elements as $element ) {
		$elements = $element->elements[0]->elements[0];
		$widget_type = $elements->widgetType;
		$pos = strpos( $widget_type, 'aheto_' );
		if ( $pos !== false ) {
			$layout =  $elements->settings->template;
			$layout = ( empty( $layout ) ) ? 'layout1' : $layout;
			$current_options[$widget_type]['relations'][$post_ID] = $layout;
			$array_values = array_values($current_options[$widget_type]['relations']);
			$uniques = array_unique($array_values);
			$current_options[$widget_type]['uniques'] = $uniques;
		}
	}
	update_option( 'aheto-layouts', $current_options, '', 'yes' );
}
*/

/**
 * PSR-4 Autoload.
 */
function aheto_autoload() {
	// Composer ClassLoader.
	$loader = include dirname( __FILE__ ) . '/vendor/autoload.php';


	// Get aheto option.
	$options = get_option( 'aheto-general-settings' );

	// Set builder.
	$builder = isset( $options['builder'] ) && !empty($options['builder']) ? $options['builder'] : 'elementor';

	// Kinda Dependency Injection :).
	$loader->addClassMap([
		'Aheto\\Shortcode' => dirname( __FILE__ ) . '/includes/builders/' . $builder . '/abstract-shortcode.php',
	]);
}


/**
 * Register admin bar link for plugin
 */
function register_admin_bar_link() {

	global $wp_admin_bar;

	$wp_admin_bar->add_node( array(
		'id'    => 'aheto-setting-up',
		'title' => __( '<img src="' . aheto()->plugin_icon() .'" style="width:auto;height:16px;position:relative;top:3px;"> ' . aheto()->plugin_name(), 'aheto' ),
		'href'  => admin_url( 'admin.php?page=aheto-setting-up' ),
	));

}



/**
 * Main instance of Aheto.
 *
 * Returns the main instance of Aheto to prevent the need to use globals.
 *
 * @return Aheto
 */
function aheto() {
	return \Aheto\Aheto::instance();
}

// Kick it off.
aheto_autoload();
add_action( 'plugins_loaded', 'aheto', 11 );

add_action('init', 'aheto_demo_layouts');

if(!function_exists('aheto_demo_layouts')) {
	function aheto_demo_layouts() {
		$shortcodes_dir = __DIR__ . DIRECTORY_SEPARATOR . 'shortcodes';
		$parent_theme_path = get_template_directory();
		$parent_theme_array = explode( '/themes/', $parent_theme_path );
		$parent_theme = $parent_theme_array[1];
		$addon_dir      = WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/shortcodes/';

		$files = glob( $shortcodes_dir . '/*/controllers/*.php' );

		$all_plugins = (array) get_option( 'active_plugins', array() );

		foreach ( $files as $file ) {

			$shortcode      = explode( 'shortcodes', $file );
			$shortcode      = explode( '/controllers/', $shortcode[1] );
			$shortcode_name = $shortcode[0];
			$layout_name    = $shortcode[1];

			if (!strpos($layout_name, 'skins')) {
				$layout_prefix  = explode( '_layout', $layout_name );
				$layout_number  = isset( $layout_prefix[1] ) && ! empty( $layout_prefix[1] ) ? $layout_prefix[1] : '';
				$file_theme_exist = file_exists( $parent_theme_array[0] . '/themes/' . $parent_theme .'/aheto/' . $shortcode_name  . DIRECTORY_SEPARATOR . $layout_name ) || ( ! empty( $layout_number ) && ( $layout_name == $parent_theme . '_layout' . $layout_number ) && file_exists( $parent_theme_array[0] . '/themes/' . $parent_theme .'/aheto/'. $shortcode_name . DIRECTORY_SEPARATOR . 'cs_layout' . $layout_number ) );

			}else{

				$file_theme_exist = file_exists( $parent_theme_array[0] . '/themes/' . $parent_theme .'/aheto/' . $shortcode_name  . DIRECTORY_SEPARATOR . 'controllers/' . $layout_name  );
			}

			$file_addon_exist = in_array('aheto-wdsg-add-ons/index.php', $all_plugins) && file_exists( $addon_dir . $shortcode_name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $layout_name );

			if ( $file_addon_exist || $file_theme_exist ) {
				continue;
			}

			require_once( $file );
		}
	}
}



/**
 * Aheto dependency
 */
if(!function_exists('aheto_demos_add_dependency')){
	function aheto_demos_add_dependency ( $id, $args = array(), $shortcode = array() ){

		if ( is_array( $id ) ) {

			foreach ( $id as $slug ) {
				if(isset($shortcode->depedency[$slug]['template'])){
					$param = (array)$shortcode->depedency[$slug]['template'];
					$shortcode->depedency[$slug]['template'] = array_merge($args, $param );
				}
			}

		} else {
			$param = (array)$shortcode->depedency[$id]['template'];
			$shortcode->depedency[$id]['template'] = array_merge($args, $param );
		}

		return;
	}
}

// Set up the activation redirect
register_activation_hook( __FILE__, 'aheto_activate' );
add_action( 'admin_init', 'aheto_activation_redirect' );

/**
 * Plugin activation callback. Registers option to redirect on next admin load.
 *
 * Saves user ID to ensure it only redirects for the user who activated the plugin.
 */
function aheto_activate() {
	// Don't do redirects when multiple plugins are bulk activated
	if (
		( isset( $_REQUEST['action'] ) && 'activate-selected' === $_REQUEST['action'] ) &&
		( isset( $_POST['checked'] ) && count( $_POST['checked'] ) > 1 ) ) {
		return;
	}
	add_option( 'aheto_activation_redirect', wp_get_current_user()->ID );
}

/**
 * Redirects the user after plugin activation.
 */
function aheto_activation_redirect() {
	if ( is_user_logged_in() ) {
		// Make sure it's the correct user

		$check_setup_wizard = false;
		$check_setup_wizard = apply_filters( "aheto_wizard", $check_setup_wizard );


		if ( intval( get_option( 'aheto_activation_redirect', false ) ) === wp_get_current_user()->ID && $check_setup_wizard ) {
			// Make sure we don't redirect again after this one
			delete_option( 'aheto_activation_redirect' );
			wp_safe_redirect( admin_url( '/admin.php?page=aheto-setup' ) );
			exit;
		}
	}
}
