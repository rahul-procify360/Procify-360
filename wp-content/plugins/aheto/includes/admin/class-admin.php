<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Dynamic_CSS;
use Aheto\Template_Kit\Visual_Composer;
use Aheto\Traits\Hooker;
use Aheto\CMB2\CMB2_Fields;
use Aheto\Frontend\Script_Manager;
use Aheto\Generate_elementor_admin_css;

use Aheto\Template_Kit\API;

defined( 'ABSPATH' ) || exit;

/**
 * Admin class.
 */
class Admin {

	use Hooker;

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->includes();
		$this->hooks();

		// Loaded action.
		$this->do_action( 'admin_loaded' );
	}

	/**
	 * Include required files
	 */
	public function includes() {
		new Metaboxes;
		new SetupWizard;
		new CMB2_Fields;
		new Skin_Generator;
		new Visual_Composer;
		new Import;
	}

	/**
	 * Hook into actions and filters
	 */
	public function hooks() {
		/*
		 * Redirect to about page.
		 *
		 * We don't use the 'was_setup' option for the redirection as
		 * if the install fails the first time this will create a redirect loop
		 * on the about page.
		 */
		if ( true === boolval( get_option( 'aheto_redirect_about', false ) ) ) {
			$this->action( 'init', 'redirect_to_welcome' );
		}

		$this->action( 'init', 'register_pages', 5 );
		$this->action( 'admin_menu', 'fix_first_submenu', 999 );
		$this->action( 'admin_enqueue_scripts', 'register_assets' );
		$this->action( 'enqueue_block_editor_assets', 'add_gutenberg_assets' );
		$this->action( 'elementor/editor/before_enqueue_scripts', 'elementor_editor_assets' );

		$this->filter( 'admin_body_class', 'add_admin_body_class' );
		$this->action( 'elementor/widget/render_content', 'admin_elementor_scripts', 10, 2 );
		//$this->action( 'elementor/frontend/the_content', 'content_function', 10, 1 );
		$this->filter( 'elementor/fonts/additional_fonts', 'additional_google_fonts', 10, 1 );

		$this->action( 'wp_ajax_regenerating_css_js', 'regenerating_css_js_callback', 30 );
		$this->action( 'wp_ajax_nopriv_regenerating_css_js', 'regenerating_css_js_callback', 30 );
		$this->action( 'after_rocket_clean_domain', 'regenerating_css_js_callback', 70 );

	}

	/**
	 * Add Additional Fonts
	 */
	public function additional_google_fonts( $additional_fonts ) {
		$additional_fonts['Mansalva']   = 'googlefonts';
		$additional_fonts['Bebas Neue'] = 'googlefonts';
		$additional_fonts['DM Sans'] = 'googlefonts';
		$additional_fonts['Red Hat Text'] = 'googlefonts';
		$additional_fonts['Courier Prime'] = 'googlefonts';

		return $additional_fonts;
	}


	/**
	 * Function including admin scripts for elementor
	 *
	 * @param $content
	 * @param $widget
	 *
	 * @return string
	 */
	public function admin_elementor_scripts( $content, $widget ) {

		if ( ! empty( $widget ) && ! empty( $widget->slug ) ) {
			$shortcode_slug = $widget->slug;
			$settings       = $widget->get_settings();
		}

		$template = '';
		$script   = '';
		$links    = '';

		if ( isset( $settings['template'] ) && ! empty( $settings['template'] ) ) {
			$template = $settings['template'];
		}

		if ( ! empty( $shortcode_slug ) && isset( $settings['template'] ) && ! empty( $settings['template'] ) ) {
			$dir = explode( 'aheto_', $shortcode_slug );
			$pos = strpos( $template, '_layout' );

			if ( $pos === false && file_exists( aheto()->plugin_dir() . 'shortcodes/' . $dir[1] . '/assets/js/' . $template . '.js' ) && $shortcode_slug != 'aheto_instagram') {
				$script .= '<script type="text/javascript" src="' . aheto()->plugin_url() . 'shortcodes/' . $dir[1] . '/assets/js/' . $template . '.js"></script>';
			}else if(file_exists( get_template_directory() . '/aheto/' . $dir[1] . '/assets/js/' . $template . '.js' ) && $shortcode_slug != 'aheto_instagram'){
				$script .= '<script type="text/javascript" src="' . get_template_directory_uri() . '/aheto/' . $dir[1] . '/assets/js/' . $template . '.js"></script>';
			}

			if ( $shortcode_slug == 'aheto_instagram' ) {
				$pos = strpos( $template, '_layout' );
				if ( $pos === false ) {
					$links .= '<link rel="stylesheet" id="instagram-theme-css" href="' . aheto()->plugin_url() . 'shortcodes/instagram/assets/css/' . $template . '.css" type="text/css" media="all">';
				} else {
					$script .= '<script type="text/javascript" src="' . get_template_directory_uri() . '/aheto/' . $dir[1] . '/assets/js/' . $template . '.min.js"></script>';
					$links  .= '<link rel="stylesheet" id="instagram-plugin-css" href="' . get_template_directory_uri() . '/aheto/instagram/assets/css/' . $template . '.css" type="text/css" media="all">';
				}
			}
		}

		$links  = ( ! empty( $links ) ) ? $links : '';
		$script = ( ! empty( $script ) ) ? $script : '';

		return $links . $content . $script;

	}


	/**
	 * Function callback for likes Ajax
	 *
	 */
	public function regenerating_css_js_callback() {

		$plugin['name'] = 'Elementor';
		$css_jss_object = new Generate_elementor_admin_css( $plugin );

	}


	/**
	 * Redirect to welcome page
	 *
	 * Redirect the user to the welcome page after plugin activation.
	 */
	public function redirect_to_welcome() {
		$page = true === get_option( 'aheto_wizard_completed' ) ? '' : 'wizard';
		delete_option( 'aheto_redirect_about' );
		wp_redirect( Helper::get_admin_url( $page ) );
		exit;
	}

	/**
	 * Register admin pages for plugin
	 */
	public function register_pages() {

		$aheto_dashboard_pages = aheto()->plugin_dashboard_pages();
		$check_setup_wizard = get_option( 'aheto_finish_wizard' );

		if ( array_key_exists( 'setup', $aheto_dashboard_pages ) ) {
			new Page( 'aheto-setup', esc_html__( 'Setup', 'aheto' ), [
				'position' => 3,
				'parent'   => 'aheto',
				'render'   => Helper::get_admin_view( 'setup' ),
			] );

		}


		if ( array_key_exists( 'setting-up', $aheto_dashboard_pages ) ) {
			// Welcome / About.
			new Page( 'aheto', aheto()->plugin_name(), [
				'position' => 2,
				'render'   => Helper::get_admin_view( 'welcome' ),
			] );

			// Help Manager.
			new Page( 'aheto-setting-up', esc_html__( 'Dashboard', 'aheto' ), [
				'position' => 10,
				'parent'   => 'aheto',
				'render'   => Helper::get_admin_view( 'help' ),
				'assets'   => [
					'styles'  => [
						'aheto-common'   => '',
						'aheto-help'     => aheto()->plugin_url() . 'assets/admin/css/help.css',
//					'font-awesome-5'   => aheto()->plugin_url() . 'assets/fonts/font-awesome-5/all.min.css',
						'font-awesome-5' => '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css',
					],
					'scripts' => [
						'clipboard'  => '',
						'aheto-help' => aheto()->plugin_url() . 'assets/admin/js/help.js',
					],
				],
			] );
		}

		// Template Kit.

		if ( array_key_exists( 'templates', $aheto_dashboard_pages ) ) {

			if ( 'visual-composer' !== Helper::get_settings( 'general.builder' ) ) {

				new Page( 'aheto-templates', esc_html__( 'Template Kits', 'aheto' ), [
					'position' => 20,
					'parent'   => 'aheto',
//					'render'   => Helper::get_admin_view( 'template-kit' ),
					'render'   => Helper::get_admin_view( 'import' ),
					'assets'   => [
						'styles'  => [
							'aheto-common'   => '',
							'aheto-cmb2'     => '',
//					'select2' => aheto()->plugin_url() . 'assets/select2/select2.min.css',
							'select2'        => 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
							'aheto-help'     => aheto()->plugin_url() . 'assets/admin/css/template-kit.css',
//					'font-awesome-5'   => aheto()->plugin_url() . 'assets/fonts/font-awesome-5/all.min.css',
							'font-awesome-5' => '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css',
						],
						'scripts' => [
//					'select2' => aheto()->plugin_url() . 'assets/select2/select2.min.js',
							'select2'      => 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
							'template-kit' => aheto()->plugin_url() . 'assets/admin/js/template-kit.js',
							'aheto-lazy'   => aheto()->plugin_url() . 'assets/frontend/vendors/lazyload/lazyload.min.js'

						],
					],
				] );
			}
		}

		if ( array_key_exists( 'import-export', $aheto_dashboard_pages ) ) {
			// Export / Import.
			new Page( 'aheto-import-export', esc_html__( 'Import &amp; Export', 'aheto' ), [
				'position' => 30,
				'parent'   => 'aheto',
				'render'   => Helper::get_admin_view( 'import-export' ),
				'onsave'   => [ $this, 'import_export_handler' ],
				'assets'   => [
					'styles' => [
						'aheto-common' => '',
						'aheto-cmb2'   => '',
					],
				],
			] );
		}
	}


	/**
	 * Fix first submenu name
	 */
	public function fix_first_submenu() {
		global $submenu;

		if ( isset( $submenu['aheto'] ) ) {
			remove_submenu_page( 'aheto', 'aheto' );
		}
	}

	/**
	 * Function elementor editor assets
	 *
	 */
	public function elementor_editor_assets() {

		$script_manager = new Script_Manager();
		$script_manager->register_styles();

		$font_icons = (array) Helper::get_settings( 'general.font-icons', [] );
		$lazyload   = Helper::get_settings( 'general.lazyload' );


		if ( ! empty( $font_icons ) ) {
			foreach ( $font_icons as $handle ) {
				$handle = $handle === 'font-awesome' ? 'font-awesome-4.7.0' : $handle;
				wp_enqueue_style( $handle );
			}
		}

		if ( $lazyload == 'enable' ) {
			wp_enqueue_script( 'aheto-lazy', aheto()->plugin_url() . 'assets/frontend/vendors/lazyload/lazyload.min.js', [ 'jquery' ], aheto()->version );

		}

		wp_enqueue_style( 'aheto-elementor-editor', aheto()->plugin_url() . 'assets/admin/css/elementor-editor.css', null, aheto()->version );

	}

	/**
	 * Register Styles and Scripts required by plugin
	 */
	public function register_assets() {
		$script_manager = new Script_Manager();
		$script_manager->register_styles();
		$script_manager->admin_scripts();

		$font_icons = (array) Helper::get_settings( 'general.font-icons', [] );

		if ( ! empty( $font_icons ) ) {
			foreach ( $font_icons as $handle ) {
				$handle = $handle === 'font-awesome' ? 'font-awesome-4.7.0' : $handle;
				wp_enqueue_style( $handle );
			}
		}

		// Styles.
		$css = aheto()->plugin_url() . 'assets/admin/css/';
		wp_register_style( 'aheto-cmb2', $css . 'cmb2.css', null, aheto()->version );
		wp_register_style( 'aheto-common', $css . 'common.css', null, aheto()->version );
		if (is_rtl ()) {
			wp_enqueue_style('aheto-common-rtl', $css . 'rtl.css', null, aheto()->version);
		}

		// Scripts.
		$js = aheto()->plugin_url() . 'assets/admin/js/';
		wp_register_script( 'aheto-common', $js . 'common.js', [ 'jquery' ], aheto()->version, true );

		// Post edit screen script.
		$screen = get_current_screen();
		if ( 'post' === $screen->base ) {
			wp_enqueue_script( 'aheto-post-edit', $js . 'post-edit.js', [ 'jquery' ], aheto()->version, true );
		}

		if ( strpos( $screen->base, 'aheto' ) !== false ) {
			wp_enqueue_script( 'aheto-sidebar-info', $js . 'sidebar-info.js', [ 'jquery' ], aheto()->version, true );
		}

		wp_enqueue_style( 'aheto-general', $css . 'general.css', null, aheto()->version );

	}

	/**
	 * Settings Import Export Hanlder
	 */
	public function import_export_handler() {

		if ( ! isset( $_POST['object_id'] ) || ! in_array( $_POST['object_id'], [ 'export-plz', 'import-plz' ] ) ) {
			return;
		}

		if ( 'export-plz' === $_POST['object_id'] ) {
			$this->export_settings();
		}

		if ( isset( $_FILES['import-me'] ) && 'import-plz' === $_POST['object_id'] ) {
			$this->import_settings();
		}
	}

	/**
	 * Handle export.
	 */
	private function export_settings() {
		$data = [];
		if ( ! empty( $_POST['panels'] ) && is_array( $_POST['panels'] ) ) {
			$panels = array_map( 'sanitize_text_field', $_POST['panels'] );
		}
		if ( ! empty( $_POST['skins'] ) ) {
			$skins = sanitize_text_field( $_POST['skins'] );
		}
		$generated = get_option( 'aheto_generated_skins' );

		if ( isset( $panels ) ) {
			foreach ( $panels as $panel ) {
				$data[ $panel ] = get_option( $panel, [] );
			}

			if ( isset( $data['aheto-skin-generator'] ) ) {
				unset( $data['aheto-skin-generator'] );
				$data['aheto_generated_skins'] = Helper::skins();
				foreach ( $data['aheto_generated_skins'] as $skin => $label ) {
					$skin          = 'aheto_skin_' . $skin;
					$data[ $skin ] = get_option( $skin );
				}
			}

			$filename = 'aheto-settings-' . date( 'Y-m-d-H-i-s' ) . '.txt';
			$this->download_file( $filename, $data );

		}


		if ( isset( $skins ) ) {
			$name          = $generated[ $skins ];
			$skin          = 'aheto_skin_' . $skins;
			$response      = get_option( $skin );
			$data['name']  = $name;
			$data[ $skin ] = $response;

			$filename = 'aheto-settings-' . $skins . '.json';
			$this->download_file( $filename, $data );
		}

		exit;

	}

	/**
	 * Function downloading skin
	 *
	 * @param $filename
	 * @param $data
	 */
	public function download_file( $filename, $data ) {
		header( 'Content-Type: application/txt' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Cache-Control: no-cache, no-store, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );

		echo wp_json_encode( $data );
		exit;
	}

	/**
	 * Handle import.
	 */
	private function import_settings() {
		// Handle Upload.
		$file = wp_handle_upload( $_FILES['import-me'] );
		if ( is_wp_error( $file ) ) {
			Helper::add_notification( esc_html__( 'Settings could not be imported:', 'aheto' ) . ' ' . $file->get_error_message() );

			return false;
		}
		if ( is_array( $file ) && isset( $file['error'] ) ) {
			Helper::add_notification( esc_html__( 'Settings could not be imported:', 'aheto' ) . ' ' . $file['error'] );

			return false;
		}
		if ( ! isset( $file['file'] ) ) {
			Helper::add_notification( esc_html__( 'Settings could not be imported:', 'aheto' ) . ' ' . esc_html__( 'Upload failed.', 'aheto' ) );

			return false;
		}

		// Parse Options.
		$wp_filesystem = Helper::init_filesystem();
		$settings      = $wp_filesystem->get_contents( $file['file'] );
		$settings      = json_decode( $settings, true );

		\unlink( $file['file'] );

		$down = false;

		$single_skin = !$settings['aheto_generated_skins'] ? true : false;
		$array = get_option( 'aheto_generated_skins', true );
		$array = empty( $array ) ? array() : $array;

		foreach ( $settings as $key => $options ) {

			if ( ! empty( $options ) ) {

				$down = true;
				if ( $key != 'name' && $key != 'aheto-general-settings' && $key != 'aheto-theme-options' && $single_skin ) {
					$skin_name = str_replace( 'aheto_skin_', '', $key );
					update_option( $key, $options );

					$array[$skin_name] =  $settings['name'];
				}
				else {
					update_option( $key, $options );
				}
			}
		}

		if ( $single_skin ) {
			update_option( 'aheto_generated_skins',  $array );
		}

		\error_reporting( 0 );
		if ( isset( $settings['aheto_generated_skins'] ) ) {
			foreach ( $settings['aheto_generated_skins'] as $skin => $label ) {
				new Dynamic_CSS( $skin, $settings[ 'aheto_skin_' . $skin ] );
			}
		}


		if ( $down ) {
			Helper::add_notification( esc_html__( 'Settings successfully imported.', 'aheto' ), 'success' );
		}

		wp_cache_flush();
	}


	/**
	 * Add admin body classes according to layout.
	 *
	 * @param array $classes An array of body classes.
	 *
	 * @return array
	 */
	public function add_admin_body_class( $classes ) {
		$layout = Helper::get_settings( 'general.single_template', 'theme' );

		$screen = get_current_screen();

		if ( 'post' == $screen->base && 'theme' !== $layout ) {
			$classes .= ' blog--single';
			$classes .= 'fullwidth' === $layout ? ' blog--single__full' : ' blog--single__sidebar';
		}

		return $classes;
	}

	/**
	 * Getting Aheto uploads dir
	 *
	 * @return string
	 */
	public function aheto_upload_dir() {
		$upload_dir = wp_upload_dir();

		return $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles';
	}

	/**
	 * Upload folder url
	 *
	 * @return string
	 */
	public function aheto_upload_url() {
		$upload_dir = wp_upload_dir();

		return $upload_dir['baseurl'] . '/aheto-styles';
	}

	/**
	 * Add backend styles for Gutenberg.
	 */

	public function add_gutenberg_assets() {
		// Load the plugin styles within Gutenberg.

		$plugin_url = aheto()->plugin_url();

		if (isset($this->skin['search_select'])){
			$skin_select = $this->skin['search_select'];
		}else{
			$skin_select = isset($this->skin) && !empty($this->skin) ? $this->skin : 'default';
		}

		$this->skin     = Helper::get_active_skin();
		$skin_page      = Helper::get_page_skin();
		$skin_page      = ! empty( $skin_page ) ? $skin_page : $skin_select;
		$css_admin_name = 'aheto-admin-' . $skin_page . '.css';
		$plugin_url     = aheto()->plugin_url();
		$folder_path    = $this->aheto_upload_dir();
		$folder_url     = $this->aheto_upload_url();
		$file_path      = $folder_path . DIRECTORY_SEPARATOR . $css_admin_name;
		$file_url       = $folder_url . DIRECTORY_SEPARATOR . $css_admin_name;

		if ( file_exists( $file_path ) ) {
			wp_enqueue_style( 'aheto-admin-style', $file_url );
		}

		wp_enqueue_style( 'aheto-gutenberg', $plugin_url . 'assets/admin/css/gutenberg.css' );
	}

}
