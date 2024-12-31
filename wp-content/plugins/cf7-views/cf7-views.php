<?php
/*
 * Plugin Name: CF7 Views
 * Plugin URI: https://cf7views.com
 * Description: Display Contact Form 7 Submissions in frontend.
 * Version: 3.1.3
 * Author: WebHolics
 * Author URI: https://cf7views.com
 * Text Domain: cf7-views
 * Requires Plugins: contact-form-7, flamingo
 * Copyright 2024.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CF7_VIEWS_URL', plugins_url() . '/' . basename( dirname( __FILE__ ) ) );
define( 'CF7_VIEWS_DIR_URL', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );

function cf7_views_load_plugin_textdomain() {
	load_plugin_textdomain( 'cf7-views', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'cf7_views_load_plugin_textdomain' );
add_action( 'plugins_loaded', 'cf7_views_include_files', 100 );


add_action(
	'admin_notices',
	function () {

		if ( ! defined( 'WPCF7_VERSION' ) ) {
			if ( current_user_can( 'update_plugins' ) ) {
				?>
				<div class="admin-notice notice notice-warning">
					<p>
						<strong>CF7 Views</strong> depends on Contact Form 7. Please install <a target="_blank" href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a>.
					</p>
				</div>
				<?php
			}
		}

		if ( ! defined( 'FLAMINGO_VERSION' ) ) {
			if ( current_user_can( 'update_plugins' ) ) {
				?>
				<div class="admin-notice notice notice-warning">
					<p>
						<strong>CF7 Views</strong> depends on Flamingo add-on for Contact Form 7. Please install <a target="_blank" href="https://wordpress.org/plugins/flamingo/">Flamingo add-on</a>.
					</p>
				</div>
				<?php
			}
		}
		return;

	}
);


function cf7_views_include_files() {
	if ( ! defined( 'CF7_VIEWS_PRO_URL' ) ) {
		require_once CF7_VIEWS_DIR_URL . '/inc/helpers.php';

		// Backend
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-posttype.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-list-table.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-editor.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-ajax.php';
		// require_once CF7_VIEWS_DIR_URL . '/inc/admin/review/class-cf7-views-review.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-support.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/elementor/class-cf7-views-elementor-widget-init.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/admin/class-cf7-views-upgrade-to-pro-page.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/class-cf7-views-image-upload.php';

		// Frontend
		require_once CF7_VIEWS_DIR_URL . '/inc/pagination.php';
		require_once CF7_VIEWS_DIR_URL . '/inc/class-cf7-views-shortcode.php';
	}
}
add_action( 'admin_enqueue_scripts', 'cf7_views_admin_scripts' );

add_action( 'wp_enqueue_scripts', 'cf7_views_frontend_scripts' );

function cf7_views_admin_scripts( $hook ) {
	if ( ! defined( 'CF7_VIEWS_PRO_URL' ) ) {
		global $post;

		if ( ( $hook === 'edit.php' ) && ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'cf7-views' ) ) {
			wp_enqueue_style( 'sweet-alert', CF7_VIEWS_URL . '/assets/css/sweetalert2.min.css' );
			wp_enqueue_script( 'sweet-alert', CF7_VIEWS_URL . '/assets/js/sweetalert2.min.js', array( 'jquery' ), '', true );

			wp_enqueue_style( 'cf7_views_admin', CF7_VIEWS_URL . '/assets/css/admin.css' );
			wp_enqueue_script( 'cf7_views_admin', CF7_VIEWS_URL . '/assets/js/admin.js', array( 'jquery' ), '', true );
			$cf7_views_admin = array(
				'admin_url'    => admin_url(),
				'create_nonce' => wp_create_nonce( 'cf7-views-create' ),
			);
			wp_localize_script( 'cf7_views_admin', 'cf7_views_admin', $cf7_views_admin );

		}

		if ( $hook === 'admin_page_cf7-views' || $hook === 'dashboard_page_cf7-views' ) {

			wp_enqueue_style( 'fontawesome', CF7_VIEWS_URL . '/assets/css/font-awesome.css' );
			wp_enqueue_style( 'pure-css', CF7_VIEWS_URL . '/assets/css/pure-min.css' );
			wp_enqueue_style( 'pure-grid-css', CF7_VIEWS_URL . '/assets/css/grids-responsive-min.css' );
			wp_enqueue_style( 'cf7-views-editor', CF7_VIEWS_URL . '/assets/css/cf7-views-editor.css', array( 'wp-components' ) );

			$js_dir   = CF7_VIEWS_DIR_URL . '/build/static/js';
			$js_files = array_diff( scandir( $js_dir ), array( '..', '.' ) );
			$count    = 0;
			foreach ( $js_files as $js_file ) {
				if ( strpos( $js_file, '.js.map' ) === false ) {
					$js_file_name = $js_file;
					wp_enqueue_script( 'cf7_views_script' . $count, CF7_VIEWS_URL . '/build/static/js/' . $js_file_name, array( 'jquery' ), '', true );
					$count++;
					// wp_localize_script( 'react_grid_script'.$count, 'formData' , $form_data );
				}
			}

			$css_dir   = CF7_VIEWS_DIR_URL . '/build/static/css';
			$css_files = array_diff( scandir( $css_dir ), array( '..', '.' ) );

			foreach ( $css_files as $css_file ) {
				if ( strpos( $css_file, '.css.map' ) === false ) {
					$css_file_name = $css_file;
				}
			}
			// $grid_options = get_option( 'gf_stla_form_id_grid_layout_4');
			wp_enqueue_style( 'cf7_views_style', CF7_VIEWS_URL . '/build/static/css/' . $css_file_name );
		}
	}
}

function cf7_views_frontend_scripts() {
	if ( ! defined( 'CF7_VIEWS_PRO_URL' ) ) {
		wp_enqueue_style( 'pure-css', CF7_VIEWS_URL . '/assets/css/pure-min.css' );
		wp_enqueue_style( 'pure-grid-css', CF7_VIEWS_URL . '/assets/css/grids-responsive-min.css' );
		wp_enqueue_style( 'cf7-views-front', CF7_VIEWS_URL . '/assets/css/cf7-views-display.css' );
	}
}
