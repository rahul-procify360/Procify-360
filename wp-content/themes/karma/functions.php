<?php
/**
 * Karma functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Karma
 */

defined( 'KARMA_T_URI' ) or define( 'KARMA_T_URI', get_template_directory_uri() );
defined( 'KARMA_T_PATH' ) or define( 'KARMA_T_PATH', get_template_directory() );

require_once ABSPATH . 'wp-admin/includes/plugin.php';

require_once KARMA_T_PATH . '/include/class-tgm-plugin-activation.php';
require_once KARMA_T_PATH . '/include/custom-header.php';
require_once KARMA_T_PATH . '/include/actions-config.php';
require_once KARMA_T_PATH . '/include/helper-function.php';
require_once KARMA_T_PATH . '/include/aheto-shortcodes.php';
require_once KARMA_T_PATH . '/include/customizer.php';

require KARMA_T_PATH . '/vendor/autoload.php';



/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_karma() {

	if ( ! class_exists( 'Appsero\Client' ) ) {
		require_once __DIR__ . '/vendor/appsero/client/src/Client.php';
	}

	$client = new \Appsero\Client( 'e2cc15dc-885f-45da-b56d-9df6ec9a76ad', 'Karma', __FILE__ );

	// Active insights
	$client->insights()->init();

	// Active automatic updater
	$client->updater();

}

appsero_init_tracker_karma();


if ( ! function_exists( 'karma_setup' ) ) :

	function karma_setup() {

		register_nav_menus( array( 'primary-menu' => esc_html__( 'Primary menu', 'karma' ) ) );
		load_theme_textdomain( 'karma', get_template_directory() . '/languages' );


		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );

		add_theme_support( 'woocommerce' );


		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'karma_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );


		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;

add_action( 'after_setup_theme', 'karma_setup' );

// Disable REST API link tag
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

add_filter( 'aheto_template_kit_category', function () {
	return 'karma';
} );

if ( ! function_exists( 'karma_woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function karma_woocommerce_template_loop_product_title() {
		echo '<h4 class="woocommerce-loop-product--title">' . get_the_title() . '</h4>';
	}
}

add_action( 'woocommerce_shop_loop_item_title', 'karma_woocommerce_template_loop_product_title', 20 );


if ( function_exists( 'aheto' ) ) {
	function karma_theme_options( $theme_tabs ) {

		$theme_tabs = [
			'karma_shop' => [
				'icon'  => 'dashicons dashicons-admin-generic pink-color',
				'title' => esc_html__( 'Shop Options', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the theme shop options.', 'aheto' ),
				'file'  => KARMA_T_PATH . '/include/shop-options.php',
			],
		];

		return $theme_tabs;
	}
}

add_filter( 'aheto_theme_options', 'karma_theme_options', 10, 2 );

$shortcodes_dir = get_template_directory() .'/aheto';
$files = glob( $shortcodes_dir . '/*/controllers/*.php' );
foreach ( $files as $file ) {
	require_once( $file );
}

function karma_export_data() {
    if ( class_exists( 'Aheto\Template_Kit\API' ) ) {

        $aheto_api = new Aheto\Template_Kit\API;

        $endpoint = '/aheto/v1/getThemeTemplate/5899';


        $response = $aheto_api->get_demodata( $endpoint, false, false );
        return $response;
    }
}

add_filter( 'export_data', 'karma_export_data', 10 );


function karma_set_script( $scripts, $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
	$script = $scripts->query( $handle, 'registered' );

	if ( $script ) {
		// If already added
		$script->src  = $src;
		$script->deps = $deps;
		$script->ver  = $ver;
		$script->args = $in_footer;

		unset( $script->extra['group'] );

		if ( $in_footer ) {
			$script->add_data( 'group', 1 );
		}
	} else {
		// Add the script
		if ( $in_footer ) {
			$scripts->add( $handle, $src, $deps, $ver, 1 );
		} else {
			$scripts->add( $handle, $src, $deps, $ver );
		}
	}
}



function karma_replace_scripts( $scripts ) {
	$assets_url = KARMA_T_URI . '/assets/js/lib/';

	karma_set_script( $scripts, 'jquery-migrate', $assets_url . 'jquery-migrate.min.js', array(), '1.4.1-wp' );
	karma_set_script( $scripts, 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), '1.12.4-wp' );
}

add_action( 'wp_default_scripts', 'karma_replace_scripts' );

add_filter( 'aheto_wizard', function () {
	return true;
} );