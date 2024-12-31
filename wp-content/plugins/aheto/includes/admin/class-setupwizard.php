<?php
/**
 * The setup wizard.
 *
 * Walkthrough to the basic setup upon installation.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Dynamic_CSS;
use Aheto\Helpers\Color;
use Header_Footer_Generator;
use TGM_Plugin_Activation;
use Aheto\Elementor\Importer;

use Elementor\Core\Base\Document;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * SetupWizard class.
 */
class SetupWizard {

	use Hooker;

	/**
	 * Hold current step.envato_setup_default_content
	 *
	 * @var string
	 */
	protected $step = '';

	/**
	 * Hold steps data.
	 *
	 * @var array
	 */
	protected $steps = [];

	public $public_base_url = '';

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->enqueue();

		if ( ! Helper::is_setup_wizard() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		wp_enqueue_script( 'jquery-blockui', aheto()->plugin_url() . 'assets/admin/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
		wp_enqueue_script( 'envato-setup', aheto()->plugin_url() . 'assets/admin/js/envato-setup.js', array(
			'jquery',
			'jquery-blockui'
		), aheto()->version );

		wp_localize_script( 'envato-setup', 'envato_setup_params', array(
			'tgm_plugin_nonce' => array(
				'update'  => wp_create_nonce( 'tgmpa-update' ),
				'install' => wp_create_nonce( 'tgmpa-install' ),
			),
			'tgm_bulk_url'     => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),
			'wpnonce'          => wp_create_nonce( 'envato_setup_nonce' ),
			'verify_text'      => esc_html__( '...verifying', 'aheto' ),
		) );

		$this->action( 'admin_menu', 'admin_menus', 35 );
		$this->action( 'admin_init', 'setup_wizard' );
		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
		add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
		add_action( 'wp_ajax_envato_setup_content', array( $this, 'ajax_content' ) );

		add_filter( 'aheto_plugin_dashboard_pages', array( $this, 'aheto_plugin_dashboard_pages_unset' ), 10, 1 );

		// TODO: UNCOMMENT when test exporting pages
		add_action( 'elementor/template-library/after_save_template', array( $this, 'export_page_new' ), 999, 2 );
	}


	/**
	 * Function exporting pages via json
	 *
	 * @param $template_id
	 * @param $template_data
	 *
	 * @return bool
	 */
	public function export_page_new( $template_id, $template_data ) {

		// or $template_data['post_id']
		$header_id = get_post_meta( $template_data['editor_post_id'], 'aheto_header_layout', true );
		$footer_id = get_post_meta( $template_data['editor_post_id'], 'aheto_footer_layout', true );
		$skin_id   = get_post_meta( $template_data['editor_post_id'], 'aheto_skin_layout', true );

		$settings = get_post_meta( $template_data['editor_post_id'], '_elementor_page_settings', true );
		$settings = ! empty( $settings ) ? json_encode( $settings ) : '';

		$document = Plugin::$instance->documents->get( $template_id );
		$content  = $document ? $document->get_elements_data() : [];

		$content[0]['header']         = $header_id;
		$content[0]['footer']         = $footer_id;
		$content[0]['skin']           = $skin_id;
		$content[0]['style_settings'] = $settings;

		update_post_meta( $template_id, '_elementor_data', $content );

		/* Another way to export
			$input_array = json_decode( get_post_meta( $template_id, '_elementor_data', true ) );
			$array       = array(
				'header' => $header_id,
				'footer' => $footer_id,
				'skin'   => $skin_id,
			);
			$input_array[0]->header = $header_id;
			$input_array[0]->footer = $footer_id;
			$input_array[0]->skin   = $skin_id;
			$result = json_encode( $input_array );
			update_metadata( 'post', $template_id, '_elementor_data', $result );
		*/

		return $content;

	}

	/**
	 * Function getting json meta
	 *
	 * @param $post
	 * @param $key
	 *
	 * @return array|mixed|string
	 */
	public function get_json_meta( $post, $key ) {
		$meta = get_post_meta( $post, $key, true );

		if ( is_string( $meta ) && ! empty( $meta ) ) {
			$meta = json_decode( $meta, true );
		}

		if ( empty( $meta ) ) {
			$meta = [];
		}

		return $meta;
	}

	/**
	 * Function checking wizard setup
	 *
	 * @return bool
	 */
	private function is_wizard_setup() {
		$page = array();

		if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
			$page = explode( '&', $_SERVER['QUERY_STRING'] );
		}


		return current( $page ) == 'page=aheto-setup' ? true : false;
	}

	/**
	 * Function load  ( break redirect in installing process)
	 *
	 * @param $status
	 *
	 * @return bool
	 */
	public function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}

	/**
	 * Function checking finish of setup wizard
	 *
	 * @return bool
	 */
	public function check_finish_wizard() {
		return $this->is_wizard_setup() && get_option( 'aheto_finish_wizard' );
	}

	/**
	 * Add admin menus/screens
	 */
	public function admin_menus() {

		$aheto_dashboard_pages = aheto()->plugin_dashboard_pages();

		if ( array_key_exists( 'setup', $aheto_dashboard_pages ) ) {

			$hook = add_submenu_page(
				null,
				aheto()->plugin_name() . esc_html__( ' Setup', 'aheto' ),
				esc_html__( 'Wizard', 'aheto' ),
				'manage_options',
				'aheto-setup',
				[ $this, 'render' ]
			);

			$this->action( 'load-' . $hook, 'enqueue' );

		}
	}

	/**
	 * Show the setup wizard
	 */
	public function setup_wizard() {
		if ( 'aheto-setup' !== Helper::param_get( 'page' ) ) {
			return;
		}

		$this->setup_steps();
		$this->plugin_status();
		$this->action( 'admin_body_class', 'body_classes' );

		if ( ! empty( $_POST['save_step'] ) && isset( $this->steps[ $this->step ]['save'] ) && check_admin_referer( 'aheto-setup' ) ) {
			call_user_func( $this->steps[ $this->step ]['save'] );
		}
	}

	/**
	 * Add classes to body tag.
	 *
	 * @param string $classes Class string.
	 *
	 * @return string
	 */
	public function body_classes( $classes ) {
		return $classes . 'aheto-page aheto-setup aheto-setup-body-' . sanitize_html_class( $this->step );
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'aheto-setup', aheto()->plugin_url() . 'assets/admin/css/setup-wizard.css', [
			'wp-admin',
			'buttons',
			'aheto-common'
		], aheto()->version );
		wp_enqueue_style( 'envato-setup', aheto()->plugin_url() . 'assets/admin/css/envato-setup.css', [
			'wp-admin',
			'buttons',
			'aheto-common'
		], aheto()->version );

		wp_enqueue_script( 'aheto-setup', aheto()->plugin_url() . 'assets/admin/js/setup-wizard.js', [ 'jquery' ], aheto()->version );

	}

	/**
	 * Render content.
	 */
	public function render() {
		$img = aheto()->assets() . 'admin/img/sidebar-icon/';
		?>

        <div class="wrap" style="max-width: 1220px">
            <span class="wp-header-end"></span>
        </div>

        <div class="wrap aheto-wrap limit-wrap main-wrap">

			<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

            <div class="aheto-option-content">

                <div class="aheto-option-header">
                    <h4><span class="img-box"><img src="<?php echo esc_attr( $img . 'aheto-setup.png' ); ?>"
                                                   alt="aheto"/></span><?php echo aheto()->plugin_name() . esc_html__( ' Setup', 'aheto' ); ?>
                        <span class="aheto-switch right-sidebar-option">
							<input type="checkbox" value="false" id="aheto-right-sidebar-option">
							<label for="aheto-right-sidebar-option"></label>
						</span>
                    </h4>
                </div>

                <div class="aheto-option-body">

					<?php $this->navigation(); ?>

					<?php $this->content(); ?>

                </div>

            </div>

        </div>
		<?php
	}

	/**
	 * Render page content.
	 */
	private function content() {
		$content = $this->steps[ $this->step ]['view'];
		if ( is_string( $content ) ) {
			include_once $content;

			return;
		}

		call_user_func( $this->steps[ $this->step ]['view'] );
	}

	/**
	 * Setup steps
	 */
	private function setup_steps() {

		$this->steps = $this->do_filter( 'wizard_setup_steps', [
			'introduction'     => [
				'name' => esc_html__( 'Introduction', 'aheto' ),
				'view' => Helper::get_admin_view( 'setup/introduction' ),
			],
			'plugins'          => [
				'name' => esc_html__( 'Builder Install', 'aheto' ),
				'view' => Helper::get_admin_view( 'setup/plugin-install' ),
				'save' => [ $this, 'set_builder' ],
			],
			'required_plugins' => [
				'name' => esc_html__( 'Required Plugins', 'aheto' ),
				'view' => Helper::get_admin_view( 'setup/required-plugins' ),
				'save' => [ $this, 'install_plugins' ],
			],
			'import'           => [
				'name' => esc_html__( 'Import Settings', 'aheto' ),
				'view' => Helper::get_admin_view( 'setup/import' ),
				'save' => [ $this, 'set_finish' ],
			],
//			'typography'   => [
//				'name' => esc_html__( 'Typography', 'aheto' ),
//				'view' => Helper::get_admin_view( 'setup/typography' ),
//				'save' => [ $this, 'set_typography' ],
//			],
//			'colors'       => [
//				'name' => esc_html__( 'Colors', 'aheto' ),
//				'view' => Helper::get_admin_view( 'setup/colors' ),
//				'save' => [ $this, 'set_colors' ],
//			],
//			'header' => [
//				'name' => esc_html__('Headers', 'aheto'),
//				'view' => Helper::get_admin_view('setup/header'),
//				'save' => [$this, 'set_header'],
//			],
//			'footer' => [
//				'name' => esc_html__('Footers', 'aheto'),
//				'view' => Helper::get_admin_view('setup/footer'),
//				'save' => [$this, 'set_footer'],
//			],
			'thank'            => [
				'name' => esc_html__( 'Thank you', 'aheto' ),
				'view' => Helper::get_admin_view( 'setup/thank-you' ),
				'save' => [ $this, 'set_finish' ],
			],
		] );


		$this->step = sanitize_key( Helper::param_get( 'step', current( array_keys( $this->steps ) ) ) );

	}

	/**
	 * Output the steps
	 */
	protected function navigation() {
		$ouput_steps  = $this->steps;
		$array_keys   = array_keys( $ouput_steps );
		$current_step = array_search( $this->step, $array_keys, true );
		$counter      = 0;
		?>
        <div class="aheto-setup-steps">

			<?php
			foreach ( $ouput_steps as $step_key => $step ) :
				if ( isset( $step['hide'] ) && $step['hide'] ) {
					continue;
				}

				$counter ++;

				$class = '';
				if ( $step_key === $this->step ) {
					$class = 'active';
				} elseif ( $current_step > array_search( $step_key, $array_keys, true ) ) {
					$class = 'done';
				}
				?>

                <a class="step <?php echo esc_attr( $class ); ?>"
                   href="<?php echo esc_url( add_query_arg( 'step', $step_key ) ); ?>"
                   title="<?php echo esc_attr( $step['name'] ); ?>"><span><?php echo $counter; ?></span></a>

			<?php endforeach; ?>

        </div>


		<?php

        if ( ! Helper::get_ml() ) { ?>
            <p class="notice notice-error is-dismissible"><?php esc_html_e( 'Please make sure your ', 'aheto' ); ?>
                <strong>memory_limit</strong><?php esc_html_e( ' is greater than 256MB.', 'aheto' ); ?></p>
		<?php }

		if ( ! Helper::get_et() ) {?>
            <p class="notice notice-error is-dismissible"><?php esc_html_e( 'Please make sure your ', 'aheto' ); ?>
                <strong>max_execution_time</strong><?php esc_html_e( ' is greater than 60.', 'aheto' ); ?></p>
		<?php
		}
	}

	/**
	 * Get the next step buttons
	 */
	public function plugins_next_step_buttons() {
		?>
        <p class="aheto-setup-actions step wp-core-ui">
            <input type="submit" class="custom-btn default" value="<?php esc_attr_e( 'Next Step', 'aheto' ); ?>"
                   name="save_step"/>
			<?php wp_nonce_field( 'aheto-setup' ); ?>
        </p>
		<?php
	}

	/**
	 * Get the next step buttons
	 */
	public function next_step_buttons() {
		?>
        <p class="aheto-setup-actions step wp-core-ui">
            <input type="submit" class="custom-btn" value="<?php esc_attr_e( 'Next Step', 'aheto' ); ?>"
                   name="save_step"/>
			<?php wp_nonce_field( 'aheto-setup' ); ?>
        </p>
		<?php
	}


	/**
	 * Get the prev step buttons
	 */
	public function prev_step_buttons() { ?>

        <a href="<?php echo esc_url( $this->get_prev_step_link() ); ?>"
           class="custom-btn default button-prev"><?php esc_html_e( 'Prev step', 'aheto' ); ?></a>

		<?php
	}


	/**
	 * Get sip link.
	 */
	public function step_skip_link() {
		?>
        <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
           class="button button-large button-next"><?php esc_html_e( 'Skip step', 'aheto' ); ?></a>
		<?php
	}


	/**
	 * Get the next step link
	 *
	 * @return string
	 */
	public function get_prev_step_link() {
		$keys  = array_keys( $this->steps );
		$index = array_search( $this->step, $keys ) - 1;
		if ( isset( $keys[ $index ] ) ) {
			return add_query_arg( 'step', $keys[ $index ] );
		}

		return admin_url( 'admin.php?page=aheto-setting-up' );
	}


	/**
	 * Get the next step link
	 *
	 * @return string
	 */
	public function get_next_step_link() {
		$keys  = array_keys( $this->steps );
		$index = array_search( $this->step, $keys ) + 1;
		if ( isset( $keys[ $index ] ) ) {
			return add_query_arg( 'step', $keys[ $index ] );
		}

		return admin_url( 'admin.php?page=aheto-general-settings' );
	}

	/**
	 * Save plugin.
	 */
	public function plugin_status() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		// Activate plugin.
		if ( isset( $_GET['action'] ) && 'aheto-activate' == $_GET['action'] ) {

			check_admin_referer( 'aheto-activate' );
			activate_plugin( $_GET['plugin'] );
			delete_transient( '_vc_page_welcome_redirect' );
			wp_safe_redirect( remove_query_arg( [ 'plugin', 'action' ] ) );
			exit;
		}
	}

	/**
	 * Generate plugin action link
	 *
	 * @param string $slug Slug of plugin.
	 * @param array $plugin Array of plugin info.
	 * @param string $status Plugin status.
	 */
	public function tgmpa_plugin_action( $slug, $plugin, $status ) {

		if ( 'not-installed' === $status ) {

			if ( ! $plugin['premium'] ) { ?>
                <a href="#" data-slug="<?php echo $plugin['premium'] ? '' : $slug; ?>"
                   class="aheto-plugin-button plugin-not-installed <?php echo $plugin['premium'] ? 'premium-plugin' : 'install-now'; ?>">
					<?php echo $plugin['premium'] ? esc_html__( 'Buy Now', 'aheto' ) : esc_html_x( 'Install', aheto()->plugin_name() . ' plugin installation page.', 'aheto' ); ?>
                </a>
			<?php }

			return;
		}

		if ( 'installed' === $status ) {
			$nonce_url = wp_nonce_url(
				add_query_arg(
					[
						'plugin' => urlencode( $plugin['file'] ),
						'action' => 'aheto-activate',
					]
				),
				'aheto-activate'
			);
			?>
            <a href="<?php echo $nonce_url; ?>" data-slug="<?php echo $slug; ?>"
               class="aheto-plugin-button plugin-installed activate-now button-primary"><span><?php echo esc_html_x( 'Activate', aheto()->plugin_name() . ' plugin installation page.', 'aheto' ); ?></span></a>
			<?php
			return;
		}

		?>
        <span
                class="aheto-plugin-button plugin-active"><?php echo esc_html_x( 'Active', aheto()->plugin_name() . ' plugin installation page.', 'aheto' ); ?></span>
		<?php
	}

	/**
	 * Save builder selection.
	 */
	public function set_builder() {

		if ( ! isset( $_POST['plugin-select'] ) ) {
			Helper::add_notification( 'No plugin selected.', [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'builder' => $_POST['plugin-select'] ] );
		wp_safe_redirect( $this->get_next_step_link() );
		exit;
	}


	/**
	 * Sanitize key function
	 *
	 * @param $key
	 *
	 * @return mixed|void
	 */
	public function sanitize_key( $key ) {
		$raw_key = $key;
		$key     = preg_replace( '`[^A-Za-z0-9_-]`', '', $key );

		/**
		 * Filter a sanitized key string.
		 *
		 * @since 2.5.0
		 *
		 * @param string $key Sanitized key.
		 * @param string $raw_key The key prior to sanitization.
		 */
		return apply_filters( 'tgmpa_sanitize_key', $key, $raw_key );
	}

	/**
	 * Try to grab information from WordPress API.
	 *
	 * @since 2.5.0
	 *
	 * @param string $slug Plugin slug.
	 *
	 * @return object Plugins_api response object on success, WP_Error on failure.
	 */
	protected function get_plugins_api( $slug ) {
		static $api = array(); // Cache received responses.

		if ( ! isset( $api[ $slug ] ) ) {
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}

			$response = plugins_api( 'plugin_information', array(
				'slug'   => $slug,
				'fields' => array( 'sections' => false )
			) );

			$api[ $slug ] = false;

			if ( is_wp_error( $response ) ) {
				wp_die( esc_html( $this->strings['oops'] ) );
			} else {
				$api[ $slug ] = $response;
			}
		}

		return $api[ $slug ];
	}

	/**
	 * Save typography selection.
	 */
	public function set_typography() {

		if ( ! isset( $_POST['typography-select'] ) ) {
			Helper::add_notification( 'No typography selected.', [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'typography' => $_POST['typography-select'] ], 'current_theme_in_progress' );
		wp_safe_redirect( $this->get_next_step_link() );
		exit;
	}

	/**
	 * Save color selection.
	 */
	public function set_colors() {

		if ( ! isset( $_POST['color-select'] ) ) {
			Helper::add_notification( 'No color selected.', [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'color' => $_POST['color-select'] ], 'current_theme_in_progress' );
		wp_safe_redirect( $this->get_next_step_link() );
		exit;
	}

	/**
	 * Save header selection.
	 */
	public function set_header() {

		if ( ! isset( $_POST['header-select'] ) ) {
			Helper::add_notification( 'No header selected.', [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'header' => $_POST['header-select'] ], 'current_theme_in_progress' );

		$Header_Footer_Generator = new Header_Footer_Generator();
		$Header_Footer_Generator->header_create();

		if ( $error = $Header_Footer_Generator->get_error() ) {
			Helper::add_notification( $error, [ 'type' => 'error' ] );

			return;
		}

		wp_safe_redirect( $this->get_next_step_link() );
		exit;
	}

	/**
	 * Save footer selection.
	 */
	public function set_footer() {

		if ( ! isset( $_POST['footer-select'] ) ) {
			Helper::add_notification( 'No footer selected.', [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'header' => $_POST['header-select'] ], 'current_theme_in_progress' );

		$Header_Footer_Generator = new Header_Footer_Generator();
		$Header_Footer_Generator->footer_create();

		if ( $error = $Header_Footer_Generator->get_error() ) {
			Helper::add_notification( $error, [ 'type' => 'error' ] );

			return;
		}

		$this->set_options( [ 'footer' => $_POST['footer-select'] ], 'current_theme_in_progress' );
		$this->finish_wizard();
		wp_safe_redirect( $this->get_next_step_link() );


//		$this->set_options('aheto_finish_wizard', 'true');
		add_option( 'aheto_finish_wizard', 'true' );
		exit;
	}

	/**
	 * Function setting wizzard finished
	 *
	 */
	public function set_finish() {

		$import_finished = get_option( "aheto_import_finished" );
		if ( $import_finished ) {
			update_option( 'aheto_finish_wizard', 'true' );
		}

	}

	/**
	 * Get typography set.
	 *
	 * @return array
	 */
	public function get_typography_set() {
		$dir = aheto()->assets() . 'admin/img/typography/';

		return [
			'typo_1'  => [
				'image' => $dir . 'typo_1.png',
				'title' => esc_html__( 'Typography style 1', 'aheto' ),
			],
			'typo_2'  => [
				'image' => $dir . 'typo_2.png',
				'title' => esc_html__( 'Typography style 2', 'aheto' ),
			],
			'typo_3'  => [
				'image' => $dir . 'typo_3.png',
				'title' => esc_html__( 'Typography style 3', 'aheto' ),
			],
			'typo_4'  => [
				'image' => $dir . 'typo_4.png',
				'title' => esc_html__( 'Typography style 4', 'aheto' ),
			],
			'typo_5'  => [
				'image' => $dir . 'typo_5.png',
				'title' => esc_html__( 'Typography style 5', 'aheto' ),
			],
			'typo_6'  => [
				'image' => $dir . 'typo_6.png',
				'title' => esc_html__( 'Typography style 6', 'aheto' ),
			],
			'typo_7'  => [
				'image' => $dir . 'typo_7.png',
				'title' => esc_html__( 'Typography style 7', 'aheto' ),
			],
			'typo_8'  => [
				'image' => $dir . 'typo_8.png',
				'title' => esc_html__( 'Typography style 8', 'aheto' ),
			],
			'typo_9'  => [
				'image' => $dir . 'typo_9.png',
				'title' => esc_html__( 'Typography style 9', 'aheto' ),
			],
			'typo_10' => [
				'image' => $dir . 'typo_10.png',
				'title' => esc_html__( 'Typography style 10', 'aheto' ),
			],
			'typo_11' => [
				'image' => $dir . 'typo_11.png',
				'title' => esc_html__( 'Typography style 11', 'aheto' ),
			],
			'typo_12' => [
				'image' => $dir . 'typo_12.png',
				'title' => esc_html__( 'Typography style 12', 'aheto' ),
			],
			'typo_13' => [
				'image' => $dir . 'typo_13.png',
				'title' => esc_html__( 'Typography style 13', 'aheto' ),
			],
			'typo_14' => [
				'image' => $dir . 'typo_14.png',
				'title' => esc_html__( 'Typography style 14', 'aheto' ),
			],
			'typo_15' => [
				'image' => $dir . 'typo_15.png',
				'title' => esc_html__( 'Typography style 15', 'aheto' ),
			],
		];
	}

	/**
	 * Get color set.
	 *
	 * @return array
	 */
	public function get_colors_set() {

		return [
			'color_1'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 1', 'aheto' ),
			],
			'color_2'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 2', 'aheto' ),
			],
			'color_3'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 3', 'aheto' ),
			],
			'color_4'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 4', 'aheto' ),
			],
			'color_5'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 5', 'aheto' ),
			],
			'color_6'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 6', 'aheto' ),
			],
			'color_7'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 7', 'aheto' ),
			],
			'color_8'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 8', 'aheto' ),
			],
			'color_9'  => [
				'image' => '',
				'title' => esc_html__( 'Color style 9', 'aheto' ),
			],
			'color_10' => [
				'image' => '',
				'title' => esc_html__( 'Color style 10', 'aheto' ),
			],
			'color_11' => [
				'image' => '',
				'title' => esc_html__( 'Color style 11', 'aheto' ),
			],
			'color_12' => [
				'image' => '',
				'title' => esc_html__( 'Color style 12', 'aheto' ),
			],
			'color_13' => [
				'image' => '',
				'title' => esc_html__( 'Color style 13', 'aheto' ),
			],
			'color_14' => [
				'image' => '',
				'title' => esc_html__( 'Color style 14', 'aheto' ),
			],
			'color_15' => [
				'image' => '',
				'title' => esc_html__( 'Color style 15', 'aheto' ),
			],
		];
	}

	/**
	 * Get header set.
	 *
	 * @return array
	 */
	public function get_header_set() {

		return [
			'header_1'  => [
				'image' => '',
			],
			'header_2'  => [
				'image' => '',
			],
			'header_3'  => [
				'image' => '',
			],
			'header_4'  => [
				'image' => '',
			],
			'header_5'  => [
				'image' => '',
			],
			'header_6'  => [
				'image' => '',
			],
			'header_7'  => [
				'image' => '',
			],
			'header_8'  => [
				'image' => '',
			],
			'header_9'  => [
				'image' => '',
			],
			'header_10' => [
				'image' => '',
			],
			'header_11' => [
				'image' => '',
			],
			'header_12' => [
				'image' => '',
			],
			'header_13' => [
				'image' => '',
			],
			'header_14' => [
				'image' => '',
			],
			'header_15' => [
				'image' => '',
			],
		];
	}

	/**
	 * Get footer set.
	 *
	 * @return array
	 */
	public function get_footer_set() {

		return [
			'footer_1'  => [
				'image' => '',
			],
			'footer_2'  => [
				'image' => '',
			],
			'footer_3'  => [
				'image' => '',
			],
			'footer_4'  => [
				'image' => '',
			],
			'footer_5'  => [
				'image' => '',
			],
			'footer_6'  => [
				'image' => '',
			],
			'footer_7'  => [
				'image' => '',
			],
			'footer_8'  => [
				'image' => '',
			],
			'footer_9'  => [
				'image' => '',
			],
			'footer_10' => [
				'image' => '',
			],
			'footer_11' => [
				'image' => '',
			],
			'footer_12' => [
				'image' => '',
			],
			'footer_13' => [
				'image' => '',
			],
			'footer_14' => [
				'image' => '',
			],
			'footer_15' => [
				'image' => '',
			],
		];
	}

	/**
	 * Update option values.
	 *
	 * @param array $values Hold values to update.
	 * @param string $option_id Option key.
	 */
	private function set_options( $values, $option_id = 'aheto-general-settings' ) {
		$options = get_option( $option_id );
		$options = wp_parse_args( $values, $options );

		update_option( $option_id, $options );
	}

	/**
	 * Finish wizard.
	 *
	 * Create Dynamic CSS and Import Header and Footer.
	 */
	private function finish_wizard() {
		new Finish_Wizard;
		delete_option( 'current_theme_in_progress' );
	}

	/**
	 * Funtion get_plugins
	 *
	 * @return array
	 */
	public function _get_plugins() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins  = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);

		foreach ( $instance->plugins as $slug => $plugin ) {
			if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $slug ] = $plugin;

				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][ $slug ] = $plugin;
					}

					if ( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}
				}
			}
		}

		return $plugins;
	}

	/**
	 * Function for setting installing plugins for required_plugins step
	 *
	 * @return bool
	 */
	public function envato_setup_default_plugins() {

		tgmpa_load_bulk_installer();
		// install plugins with TGM.
		if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
			die( 'Failed to find TGM' );
		}
		$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
		$plugins = $this->_get_plugins();

		// copied from TGM

		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}

		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

			return true;
		}

		/* If we arrive here, we have the filesystem */
		?>

        <form method="post" class="aheto-required-plugins">

            <div class="headings-wrap">
                <h3 class="step-heading">
					<?php esc_html_e( 'Install required plugins', 'aheto' ); ?>
                </h3>
                <div class="aheto-required-plugins-buttons step active-buttons">
                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                       class="button-next custom-btn"
                       data-callback="install_plugins"><?php esc_html_e( 'Next step', 'aheto' ); ?></a>
                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                       class=" button-next custom-btn"><?php esc_html_e( 'Skip this step', 'aheto' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
                </div>
            </div>
            <hr>
            <div class="description-wrap">
                <p>
                    <i>
						<?php esc_html_e( 'Some of these you Must Have and some of them you\'ll Want to Have...', 'aheto' ); ?>
                    </i>
                </p>
            </div>

			<?php
			$plugins = $this->_get_plugins();
			if ( count( $plugins['all'] ) ) {
				?>
                <ul class="aheto-required-plugins--list">
					<?php foreach ( $plugins['all'] as $slug => $plugin ) { ?>
                        <li data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $plugin['name'] ); ?>
                            <span>
								<?php
								$keys = array();
								if ( isset( $plugins['install'][ $slug ] ) ) {
									$keys[] = 'Installation';
								}
								if ( isset( $plugins['update'][ $slug ] ) ) {
									$keys[] = 'Update';
								}
								if ( isset( $plugins['activate'][ $slug ] ) ) {
									$keys[] = 'Activation';
								}
								echo implode( ' and ', $keys ) . ' required';
								?>
							</span>
                            <div class="spinner"></div>
                        </li>
					<?php } ?>
                </ul>
				<?php
			} else {
				echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'aheto' ) . '</strong></p>';
			} ?>

            <p class="aheto-required-plugins-buttons step bottom-buttons">
                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                   class="button-next custom-btn"
                   data-callback="install_plugins"><?php esc_html_e( 'Next step', 'aheto' ); ?></a>
                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                   class=" button-next custom-btn"><?php esc_html_e( 'Skip this step', 'aheto' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
            </p>

        </form>
		<?php
	}

	/**
	 * Function installing-activating plugins by ajax
	 *
	 */
	public function ajax_plugins() {

		if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
			wp_send_json_error( array(
				'error'   => 1,
				'message' => esc_html__( 'No Slug Found', 'aheto' )
			) );
		}
		$json    = array();
		$plugins = $this->_get_plugins();
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating Plugin', 'aheto' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating Plugin', 'aheto' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( 'themes.php?page=tgmpa-install-plugins' ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => 'tgmpa-install-plugins',
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing Plugin', 'aheto' ),
				);
				break;
			}
		}

		if ( $json ) {
			$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json( $json );
		} else {
			wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'aheto' ) ) );
		}
		exit;

	}


	/**
	 * Page setup
	 */
	public function envato_setup_default_content() { ?>

        <form method="post" class="aheto-import-theme-data">

            <div class="headings-wrap">
                <h3 class="step-heading">
					<?php esc_html_e( 'Import Settings', 'aheto' ); ?>
                </h3>
                <div class="active-buttons aheto-required-plugins-buttons step">
                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                       class="custom-btn button-next"
                       data-callback="install_content"><?php esc_html_e( 'Continue', 'aheto' ); ?></a>
                    <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                       class="custom-btn button-next"><?php esc_html_e( 'Skip this step', 'aheto' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
                </div>
            </div>
            <hr>
            <div class="description-wrap">
                <p>
                    <i>
						<?php esc_html_e( 'Hi Folks,
	These are the next steps of importing the main settings of your theme. Please note by default we’ve deactivated importing: Menus, Pages, and Media (all the images) as that require a huge amount of time to import. Anyway, after this step, you will be redirected to the Template Kits, where you will be able to import any pages you need.
	But, in case you still want to wait and import everything please use turn on those settings.', 'aheto' ); ?>
                    </i>
                </p>
            </div>

            <div class="aheto-import-theme-data--wrap">
                <div class="summary-time"><h4><?php esc_html_e( 'It takes about: ' ); ?></h4><span>0</span></div>
                <div class="install-text">
					<?php esc_html_e( 'Please wait, installing Theme Demo Data ...', 'aheto' ); ?>
                </div>
                <div class="aheto-import-theme-data--list">
                    <div class="item lab full" data-type="full">
                        <div class="content">

							<?php

							$content = $this->_content_default_get( 'full' );
							if ( ! empty( $content ) ) {

								$count_media = 1;
								$count_menu  = 1;

								foreach ( $content as $slug => $default ) {
									$name = str_replace( '-', ' ', $default['title'] );

									$label = ( strstr( $slug, 'page_' ) ) ? ( ( $slug == "page_1" ) ? "All Pages" : esc_html( $name ) ) : esc_html( $name );
									$label = ( strstr( $slug, 'media_' ) ) ? ( ( $count_media === 1 ) ? "All Media" : esc_html( $name ) ) : $label;
									$label = ( strstr( $slug, 'media_' ) ) ? ( ( $count_media === 1 ) ? "All Media" : esc_html( $name ) ) : $label;
									$label = ( $default['install_callback'] === '_content_install_menus' ) ? ( ( $count_menu === 1 ) ? "All Menus" : esc_html( $name ) ) : $label;

									$style = ( strstr( $slug, 'page_' ) ) ? ( ( $slug == "page_1" ) ? "" : "display:none" ) : "";
									$style = ( strstr( $slug, 'media_' ) ) ? ( ( $count_media === 1 ) ? "" : "display:none" ) : $style;
									$style = ( $default['install_callback'] === '_content_install_menus' ) ? ( ( $count_menu === 1 ) ? "" : "display:none" ) : $style;

									$count_media = strstr( $slug, 'media_' ) ? ( $count_media + 1 ) : $count_media;
									$count_menu  = $default['install_callback'] === '_content_install_menus' ? ( $count_menu + 1 ) : $count_menu;

									$size = isset( $default['size'] ) && $default['size'] !== 'NaN' ? $default['size'] : 1;

									$seconds = ceil( $size / 4 );

									$minutes = $seconds / 60;

									$text_minutes = $minutes < 1 ? $seconds . ' secs' : round( $minutes ) . ' min';

									$type = strstr( $slug, 'media_' ) ? 'media' : 'default';
									$type = $default['install_callback'] === '_content_install_menus' ? 'menus' : $type;
									$type = strstr( $slug, 'page_' ) ? 'pages' : $type;

									$type_off         = $type === 'media' || $type === 'pages' || $type === 'menus' ? '' : 'checkes';
									$type_checked     = $type === 'media' || $type === 'pages' || $type === 'menus' ? '' : 'checked';
									$type_checked_off = $type === 'media' || $type === 'pages' || $type === 'menus' ? 'checked' : ''; ?>

                                    <div class="envato_default_content import-item-wrap <?php echo esc_attr( $type_off ); ?>"
                                         style="<?php echo $style; ?>"
                                         data-content="<?php echo esc_attr( $default['name'] ); ?>"
                                         data-file_url="<?php echo esc_attr( $default['url'] ); ?>"
                                         data-type="<?php echo esc_attr( $type ); ?>">
                                        <div><span><i class="dashicons dashicons-clock"></i><b class="import-time"
                                                                                               data-time="<?php echo esc_attr( $seconds ); ?>"><?php echo esc_html( $text_minutes ); ?></b></span><?php echo esc_html( $label ); ?>
                                        </div>
                                        <ul class="radio-buttons">
                                            <li class="radio-button">
                                                <input type="radio"
                                                       name="default_content_<?php echo esc_attr( $default['name'] ); ?>"
                                                       class="envato_default_content "
                                                       id="default_content_<?php echo esc_attr( $default['name'] ); ?>off"
													<?php echo esc_attr( $type_checked_off ); ?>
                                                       data-time='0'
                                                       value="off">
                                                <label for="default_content_<?php echo esc_attr( $default['name'] ); ?>off">
													<?php echo esc_html_e( 'Off' ); ?>
                                                </label>
                                            </li>
                                            <li class="radio-button">
                                                <input type="radio"
                                                       name="default_content_<?php echo esc_attr( $default['name'] ); ?>"
                                                       class="envato_default_content"
                                                       id="default_content_<?php echo esc_attr( $default['name'] ); ?>"
													<?php echo esc_attr( $type_checked ); ?> value="on"
                                                       data-time="<?php echo esc_attr( $seconds ); ?>">
                                                <label for="default_content_<?php echo esc_attr( $default['name'] ); ?>">
													<?php echo esc_html_e( 'On' ); ?>
                                                </label>
                                            </li>
                                        </ul>

                                    </div>
								<?php }

							} else {
								echo esc_html_e( 'There are no elements for this type yet.', 'aheto' );
							} ?>
                        </div>
                    </div>
                </div>

            </div>

            <p class="bottom-buttons aheto-required-plugins-buttons step">
                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                   class="custom-btn button-next"
                   data-callback="install_content"><?php esc_html_e( 'Continue', 'aheto' ); ?></a>
                <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                   class="custom-btn button-next"><?php esc_html_e( 'Skip this step', 'aheto' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
            </p>
        </form>
		<?php
	}

	/**
	 * Function getting import data for part
	 *
	 * @return array
	 */
	private function _content_default_get( $type ) {

		$content = array();

		/** Array from theme!! */
		$content = apply_filters( 'export_data', array() );

		/**   */

		/** Array in plugin */
		/*
		$part  = 'part';
		$full  = 'full';
		$content[$part] = array(
			'posts'  => array(
				'name'             => 'posts',
				'title'            => 'Posts part',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/part/posts.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  posts part.', 'aheto' ),
				'installing'       => esc_html__( 'Installing  posts part.', 'aheto' ),
				'success'          => esc_html__( 'Success  posts part.', 'aheto' ),
				'directory'        => $part,
			),
			'portfolios' =>  array(
				'name'             => 'portfolios',
				'title'            => 'portfolios part',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/part/portfolios.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Portfolios part.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Portfolios part.', 'aheto' ),
				'success'          => esc_html__( 'Success  Portfolios part.', 'aheto' ),
				'directory'        => $part,
			),
			'headers'  => array(
				'name'             => 'headers',
				'title'            => 'Headers part',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/part/headers.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Headers part.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Headers part.', 'aheto' ),
				'success'          => esc_html__( 'Success  Headers part.', 'aheto' ),
				'directory'        => $part,
			),
			'footers'  => array(
				'name'             => 'footers',
				'title'            => 'Footers part',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/part/footers.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Footers part.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Footers part.', 'aheto' ),
				'success'          => esc_html__( 'Success  Footers part.', 'aheto' ),
				'directory'        => $part,
			),
			'pages'  => array(
				'name'             => 'pages',
				'title'            => 'Main settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/options.json",
				'install_callback' => '_content_install_settings',
				'pending'          => esc_html__( 'Pending Pages settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Pages settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Pages settings.', 'aheto' ),
				'directory'        => $part,
			),
			'customize'  => array(
				'name'             => 'customize',
				'title'            => 'Customize settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/customize.json",
				'install_callback' => '_content_install_customize',
				'pending'          => esc_html__( 'Pending Customize settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Customize settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Customize settings.', 'aheto' ),
				'directory'        => $part,
			),
			'menus'  => array(
				'name'             => 'menus',
				'title'            => 'Menus settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/menus.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending Menus settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Menus settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Menus settings.', 'aheto' ),
				'directory'        => $part,
			),
			 'aheto_settings'  => array(
				'name'             => 'aheto_settings',
				'title'            => 'Aheto settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/aheto-settings.txt",
				'install_callback' => '_content_install_aheto_settings',
				'pending'          => esc_html__( 'Pending ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'success'          => esc_html__( 'Success ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'directory'        => $part,
			),
			'widgets'  => array(
				'name'             => 'widgets',
				'title'            => 'Widgets settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/widgets.json",
				'install_callback' => '_content_install_widgets',
				'pending'          => esc_html__( 'Pending Widgets settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Widgets settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Widgets settings.', 'aheto' ),
				'directory'        => $part,
			),
		);
		$content[$full] = array(
			'posts'  => array(
				'name'             => 'posts',
				'title'            => 'Posts full',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/full/posts.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  posts full.', 'aheto' ),
				'installing'       => esc_html__( 'Installing  posts full.', 'aheto' ),
				'success'          => esc_html__( 'Success  posts full.', 'aheto' ),
				'directory'        => $full,
			),
			'portfolios' =>  array(
				'name'             => 'portfolios',
				'title'            => 'portfolios full',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/full/portfolios.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Portfolios full.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Portfolios full.', 'aheto' ),
				'success'          => esc_html__( 'Success  Portfolios full.', 'aheto' ),
				'directory'        => $full,
			),
			'headers'  => array(
				'name'             => 'headers',
				'title'            => 'Headers full',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/full/headers.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Headers full.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Headers full.', 'aheto' ),
				'success'          => esc_html__( 'Success  Headers full.', 'aheto' ),
				'directory'        => $full,
			),
			'footers'  => array(
				'name'             => 'footers',
				'title'            => 'Footers full',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/full/footers.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending  Footers full.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Footers full.', 'aheto' ),
				'success'          => esc_html__( 'Success  Footers full.', 'aheto' ),
				'directory'        => $full,
			),
			'pages'  => array(
				'name'             => 'pages',
				'title'            => 'Main settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/options.json",
				'install_callback' => '_content_install_settings',
				'pending'          => esc_html__( 'Pending Pages settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Pages settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Pages settings.', 'aheto' ),
				'directory'        => $full,
			),
			'customize'  => array(
				'name'             => 'customize',
				'title'            => 'Customize settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/customize.json",
				'install_callback' => '_content_install_customize',
				'pending'          => esc_html__( 'Pending Customize settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Customize settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Customize settings.', 'aheto' ),
				'directory'        => $full,
			),
			'menus'  => array(
				'name'             => 'menus',
				'title'            => 'Menus settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/menus.xml",
				'install_callback' => '_content_install_xml',
				'pending'          => esc_html__( 'Pending Menus settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Menus settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Menus settings.', 'aheto' ),
				'directory'        => $full,
			),
			'aheto_settings'  => array(
				'name'             => 'aheto_settings',
				'title'            => 'Aheto settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/aheto-settings.txt",
				'install_callback' => '_content_install_aheto_settings',
				'pending'          => esc_html__( 'Pending ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'success'          => esc_html__( 'Success ' . aheto()->plugin_name() .  . ' settings.', 'aheto' ),
				'directory'        => $full,
			),
			'widgets'  => array(
				'name'             => 'widgets',
				'title'            => 'Widgets settings',
				'url'              => "http://test-aheto.loc/wp-content/plugins/aheto/includes/admin/import-files/widgets.json",
				'install_callback' => '_content_install_widgets',
				'pending'          => esc_html__( 'Pending Widgets settings.', 'aheto' ),
				'installing'       => esc_html__( 'Installing Widgets settings.', 'aheto' ),
				'success'          => esc_html__( 'Success Widgets settings.', 'aheto' ),
				'directory'        => $full,
			),
		);
		*/

		/**  */

		if ( ! isset( $content[ $type ] ) ) {
			$content[ $type ] = array();
		}

		return $content[ $type ];

	}

	public function aheto_plugin_dashboard_pages_unset( $plugin_dashboard_pages ) {

		$show_wizard = false;
		$show_wizard = apply_filters( "aheto_wizard", $show_wizard );

		if ( ! $show_wizard ) {
			unset( $plugin_dashboard_pages['setup'] );
		}

		return $plugin_dashboard_pages;
	}

	/**
	 * Function installing the content by ajax
	 *
	 */
	public function ajax_content() {


		$content = $this->_content_default_get( 'full' );

		if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['content'] ) && isset( $content[ $_POST['content'] ] ) ) {
			wp_send_json_error( array(
				'error'   => 1,
				'message' => esc_html__( 'No content Found', 'aheto' )
			) );
		}

		$json         = false;
		$this_content = $content[ $_POST['content'] ];
		$file_url     = $_POST['file_url'];


		if ( isset( $_POST['proceed'] ) ) {
			// install the content!

			if ( ! empty( $this_content['install_callback'] ) ) {
				if ( $result = $this->{$this_content['install_callback']}( $file_url ) ) {
					$json = array(
						'done'    => 1,
						'message' => $this_content['success'],
						'debug'   => $result,
					);
				}
			}

		} else {

			$json = array(
				'url'      => admin_url( 'admin-ajax.php' ),
				'file_url' => $this_content['url'],
				'action'   => 'envato_setup_content',
				'type'     => isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '',
				'proceed'  => 'true',
				'content'  => sanitize_text_field( $_POST['content'] ),
				'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
				'message'  => 'message installing',
			);

		}


		if ( ! empty( $json ) ) {
			$json['hash'] = md5( serialize( $json ) );
			add_option( 'aheto_import_finished', 'true' );
			wp_send_json( $json );
		} else {
			if ( $this_content['content'] = ! 'widgets' ) {
				wp_send_json( array( 'error' => 1, 'message' => esc_html__( 'Error', 'aheto' ) ) );
			}
		}

		exit;

	}

	/**
	 * Function parsing xml exporting files
	 *
	 * @param null $file_path
	 *
	 * @return bool|false|string
	 */
	private function _content_install_xml( $file_path = null ) {

		$file_url = $file_path;
		$file_url = $_POST['file_url'];

		return $this->_import_wordpress_xml_file( $file_url );

	}

	/**
	 * Import wordpress xml file
	 *
	 * @param $xml_file_path
	 *
	 * @return bool|false|string
	 */
	private function _import_wordpress_xml_file( $xml_file_path ) {
		global $wpdb;

		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		// Load Importer API
		require_once ABSPATH . 'wp-admin/includes/import.php';

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if ( file_exists( $class_wp_importer ) ) {
				require $class_wp_importer;
			}
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			$class_wp_importer = __DIR__ . "/importer/wordpress-importer.php";
			if ( file_exists( $class_wp_importer ) ) {
				require_once __DIR__ . '/importer/wordpress-importer.php';
			}
		}

		if ( class_exists( 'WP_Import' ) ) {

			$wp_import                    = new \WP_Import();
			$wp_import->fetch_attachments = true;
			ob_start();
			$wp_import->import( $xml_file_path );
			$message = ob_get_clean();

			return $message;
		}

		return false;
	}

	/**
	 * Function installing setting
	 *
	 * @return bool
	 */
	private function _content_install_settings() {

		$custom_options = $this->_get_json( $_POST['file_url'] );

		// we also want to update the widget area manager options.
		foreach ( $custom_options as $option => $value ) {
			update_option( $option, $value );
		}

		return true;
	}

	// !NEW function for import pages

	/**
	 * Function installing setting
	 *
	 * @return bool
	 */
	private function _content_install_pages() {

		$content = $this->_get_json( $_POST['file_url'] );

		$importer = new Importer();
		$content  = $importer->import_template_page_via_json( $content, 'page' );

		return true;
	}

	/**
	 * Function importing menus
	 *
	 * @return bool
	 */
	public function _content_install_menus() {
		$curntMenuPos = 0;
		$content      = json_decode( $this->urlGetContents( $_POST['file_url'] ) );
//		$content   = $this->_get_json( $_POST['file_url'] );
		$count    = count( $content );
		$oldIds   = array();
		$newIds   = array();
		$menuname = ucfirst( str_replace( '_', ' ', $_POST['content'] ) );
		$menuId   = 0;
		for ( $curntMenuPos = 0; $curntMenuPos <= $count; $curntMenuPos ++ ) {
			if ( is_array( $content ) && ! empty( $content ) && isset( $content[ $curntMenuPos ]->post ) ) {
				$nav_count        = count( $content );
				$parent_arr       = $temp_arr1 = $temp_arr = array();
				$custom_post_meta = array();
				$post             = $post_metas = '';
				if ( isset( $content[ $curntMenuPos ]->post ) ) {
					$post = $content[ $curntMenuPos ]->post;
				}
				if ( isset( $content[ $curntMenuPos ]->post_metas ) ) {
					$post_metas = $content[ $curntMenuPos ]->post_metas;
				}
				$old_pid                             = $post->ID;
				$post->ID                            = '';
				$custom_post_meta['menu-item-title'] = $post->post_title;
				$post                                = (array) $post;

				if ( $menuId == 0 and ! is_nav_menu( $menuname ) ) {
					$menuId = wp_create_nav_menu( $menuname );
				}
				$post_id = wp_insert_post( $post, true );
				array_push( $oldIds, $old_pid );
				array_push( $newIds, $post_id );
				if ( is_numeric( $post_id ) && $post_id !== 0 ) {
					if ( is_object( $post_metas ) && ! empty( $post_metas ) ) {
						foreach ( $post_metas as $key => $val ) {
							$pos = stripos( $key, '_' );
							if ( $pos === 0 && $key != '_ubermenu_custom_item_type' && $key != '_ubermenu_settings' ) {
								$custom_key = substr( $key, 1 );
							} else {
								$custom_key = $key;
							}
							if ( $key != '_ubermenu_custom_item_type' && $key != '_ubermenu_settings' ) {
								$custom_key = str_replace( '_', '-', $custom_key );
							}
							if ( isset( $val[0] ) ) {
								if ( $custom_key == 'menu-item-classes' ) {
									if ( is_serialized( $val[0] ) && ! empty( unserialize( $val[0] )[0] ) ) {
										$custom_post_meta[ $custom_key ] = $val[0];
									}
								} elseif ( $custom_key == 'menu-item-menu-item-parent' ) {
									if ( $val[0] != ' ' ) {
										$old_post_ids = $oldIds;
										$new_post_ids = $newIds;
										if ( $val[0] != 0 ) {
											$new_var               = array_search( $val[0], $old_post_ids );
											$temp_arr1[ $post_id ] = $new_post_ids[ $new_var ];
											if ( isset( $temp_arr1[ $post_id ] ) ) {
												$custom_post_meta['menu-item-parent-id'] = $temp_arr1[ $post_id ];
											}
										}
									} else {
										$custom_post_meta['menu-item-parent-id'] = '';
									}
								} elseif ( $custom_key == '_ubermenu_custom_item_type' ) {
									update_post_meta( $post_id, '_ubermenu_custom_item_type', $val[0] );
								} elseif ( $custom_key == '_ubermenu_settings' ) {
									update_post_meta( $post_id, '_ubermenu_settings', unserialize( $val[0] ) );
								} else {
									$custom_post_meta[ $custom_key ] = $val[0];
								}
							}
						}
					}
					$menu_update_status = wp_update_nav_menu_item( $menuId, $post_id, $custom_post_meta );
				}
			}
		}

		return true;
	}

	/**
	 * Function getting content from json file for import menu
	 *
	 * @param $url
	 *
	 * @return bool|false|string
	 */
	private function urlGetContents( $url ) {
		if ( function_exists( 'file_get_contents' ) ) {
			$url_get_contents_data = file_get_contents( $url );
			if ( empty( $url_get_contents_data ) ) {
				$url_get_contents_data = file_get_contents( str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $url ) );
			}
		} elseif ( function_exists( 'fopen' ) && function_exists( 'stream_get_contents' ) ) {
			$handle                = fopen( $url, "r" );
			$url_get_contents_data = stream_get_contents( $handle );
		} elseif ( function_exists( 'curl_exec' ) ) {
			$conn = curl_init( $url );
			curl_setopt( $conn, CURLOPT_SSL_VERIFYPEER, true );
			curl_setopt( $conn, CURLOPT_FRESH_CONNECT, true );
			curl_setopt( $conn, CURLOPT_RETURNTRANSFER, 1 );
			$url_get_contents_data = ( curl_exec( $conn ) );
			curl_close( $conn );
		} else {
			$url_get_contents_data = false;
		}


		return $url_get_contents_data;
	}

	/**
	 * Function installing aheto settings
	 *
	 * @return bool
	 */
	private function _content_install_aheto_settings() {
		$file_url = $_POST['file_url'];

		// Parse Options.
		$wp_filesystem = Helper::init_filesystem();
		$settings      = $wp_filesystem->get_contents( $file_url );
		$settings      = json_decode( $settings, true );

		$down = false;
		foreach ( $settings as $key => $options ) {
			if ( ! empty( $options ) ) {
				$down = true;
				update_option( $key, $options );
			}
		}

		if ( isset( $settings['aheto_generated_skins'] ) ) {
			foreach ( $settings['aheto_generated_skins'] as $skin => $label ) {
				new Dynamic_CSS( $skin, $settings[ 'aheto_skin_' . $skin ] );
			}
		}

		if ( $down ) {
			Helper::add_notification( esc_html__( 'Settings successfully imported.', 'aheto' ), 'success' );
		}

		wp_cache_flush();

		return true;
	}

	/**
	 * Function importing customize functions
	 *
	 * @return bool
	 */
	private function _content_install_customize() {

		$customize_options = $this->_get_json( $_POST['file_url'] );

		$menus    = get_terms( 'nav_menu' );
		$menu_ids = array();


		foreach ( $menus as $menu ) {
			if ( $menu->slug == 'top-menu' ) {
				$menu_ids['primary-menu'] = $menu->term_id;
			}
		}

		// adjust the widget settings to match our menu ID's which we discovered above.
		if ( is_array( $customize_options ) && isset( $customize_options['nav_menu_locations'] ) ) {
			foreach ( $customize_options['nav_menu_locations'] as $key => $val ) {
				if ( $key == 'primary-menu' && $val != $menu_ids['primary-menu'] ) {
					$customize_options['nav_menu_locations'][ $key ] = $menu_ids['primary-menu'];
				}
			}
		}

		if ( ! empty( $customize_options ) ) {
			foreach ( $customize_options as $option => $value ) {
				set_theme_mod( $option, $value );
			}
		}

		return true;
	}

	/**
	 * Function parsing json files
	 *
	 * @param $file
	 *
	 * @return array|mixed|object
	 */
	private function _get_json( $file ) {

		WP_Filesystem();
		global $wp_filesystem;

		return json_decode( $wp_filesystem->get_contents( $file ), true );
	}

	/** new import with plugin */

	public function wie_process_import_file() {

		global $wie_import_results;

		// Get file contents and decode.
		$data = implode( '', file( $_POST['file_url'] ) );
		$data = json_decode( $data );

		$wie_import_results = $this->wie_import_data( $data );
		wp_send_json( 'Done', 200 );

	}

	/**
	 * Helper function for import widgets
	 *
	 * @param $data
	 *
	 * @return bool
	 */
	public function wie_import_data( $data ) {
		global $wp_registered_sidebars;

		do_action( 'wie_before_import' );
		$data = apply_filters( 'wie_import_data', $data );

		// Get all available widgets site supports.
		$available_widgets = $this->wie_available_widgets();

		// Get all existing widget instances.
		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
		}

		// Begin results.
		$results = array();

		// Loop import data's sidebars.
		foreach ( $data as $sidebar_id => $widgets ) {

			// Skip inactive widgets (should not be in export file).
			if ( 'wp_inactive_widgets' === $sidebar_id ) {
				continue;
			}

			// Check if sidebar is available on this site.
			// Otherwise add widgets to inactive, and say so.
			if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
				$sidebar_available    = true;
				$use_sidebar_id       = $sidebar_id;
				$sidebar_message_type = 'success';
				$sidebar_message      = '';
			} else {
				$sidebar_available    = false;
				$use_sidebar_id       = 'wp_inactive_widgets'; // Add to inactive if sidebar does not exist in theme.
				$sidebar_message_type = 'error';
				$sidebar_message      = esc_html__( 'Widget area does not exist in theme (using Inactive)', 'widget-importer-exporter' );
			}

			// Result for sidebar
			// Sidebar name if theme supports it; otherwise ID.
			$results[ $sidebar_id ]['name']         = ! empty( $wp_registered_sidebars[ $sidebar_id ]['name'] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : $sidebar_id;
			$results[ $sidebar_id ]['message_type'] = $sidebar_message_type;
			$results[ $sidebar_id ]['message']      = $sidebar_message;
			$results[ $sidebar_id ]['widgets']      = array();

			// Loop widgets.
			foreach ( $widgets as $widget_instance_id => $widget ) {

				$fail = false;

				// Get id_base (remove -# from end) and instance ID number.
				$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

				// Does site support this widget?
				if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
					$fail                = true;
					$widget_message_type = 'error';
					$widget_message      = esc_html__( 'Site does not support widget', 'widget-importer-exporter' ); // Explain why widget not imported.
				}

				$widget = apply_filters( 'wie_widget_settings', $widget );

				$widget = json_decode( wp_json_encode( $widget ), true );

				$widget = apply_filters( 'wie_widget_settings_array', $widget );

				// Does widget with identical settings already exist in same sidebar?
				if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {

					// Get existing widgets in this sidebar.
					$sidebars_widgets = get_option( 'sidebars_widgets' );
					$sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // Check Inactive if that's where will go.

					// Loop widgets with ID base.
					$single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
					foreach ( $single_widget_instances as $check_id => $check_widget ) {

						// Is widget in same sidebar and has identical settings?
						if ( in_array( "$id_base-$check_id", $sidebar_widgets, true ) && (array) $widget === $check_widget ) {

							$fail                = true;
							$widget_message_type = 'warning';

							// Explain why widget not imported.
							$widget_message = esc_html__( 'Widget already exists', 'widget-importer-exporter' );

							break;

						}

					}

				}

				// No failure.
				if ( ! $fail ) {

					// Add widget instance
					$single_widget_instances   = get_option( 'widget_' . $id_base ); // All instances for that widget ID base, get fresh every time.
					$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array(
						'_multiwidget' => 1, // Start fresh if have to.
					);
					$single_widget_instances[] = $widget; // Add it.

					// Get the key it was given.
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );


					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number                             = 1;
						$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity.
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget.
					update_option( 'widget_' . $id_base, $single_widget_instances );

					// Assign widget instance to sidebar.
					// Which sidebars have which widgets, get fresh every time.
					$sidebars_widgets = get_option( 'sidebars_widgets' );


					if ( ! $sidebars_widgets ) {
						$sidebars_widgets = array();
					}

					// Use ID number from new widget instance.
					$new_instance_id = $id_base . '-' . $new_instance_id_number;

					// Add new instance to sidebar.
					$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id;

					// Save the amended data.
					update_option( 'sidebars_widgets', $sidebars_widgets );

					// After widget import action.
					$after_widget_import = array(
						'sidebar'           => $use_sidebar_id,
						'sidebar_old'       => $sidebar_id,
						'widget'            => $widget,
						'widget_type'       => $id_base,
						'widget_id'         => $new_instance_id,
						'widget_id_old'     => $widget_instance_id,
						'widget_id_num'     => $new_instance_id_number,
						'widget_id_num_old' => $instance_id_number,
					);
					do_action( 'wie_after_widget_import', $after_widget_import );

					// Success message.
					if ( $sidebar_available ) {
						$widget_message_type = 'success';
						$widget_message      = esc_html__( 'Imported', 'widget-importer-exporter' );
					} else {
						$widget_message_type = 'warning';
						$widget_message      = esc_html__( 'Imported to Inactive', 'widget-importer-exporter' );
					}

				}

				// Result for widget instance
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name']         = isset( $available_widgets[ $id_base ]['name'] ) ? $available_widgets[ $id_base ]['name'] : $id_base; // Widget name or ID if name not available (not supported by site).
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title']        = ! empty( $widget['title'] ) ? $widget['title'] : esc_html__( 'No Title', 'widget-importer-exporter' ); // Show "No Title" if widget instance is untitled.
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message_type'] = $widget_message_type;
				$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message']      = $widget_message;

			}

		}

		// Hook after import.
		do_action( 'wie_after_import' );

		// Return results.
		return apply_filters( 'wie_import_results', $results );
	}

	/**
	 * Function getting avaliable widgets
	 *
	 * @return mixed
	 */
	public function wie_available_widgets() {

		global $wp_registered_widget_controls;

		$widget_controls = $wp_registered_widget_controls;

		$available_widgets = array();

		foreach ( $widget_controls as $widget ) {

			// No duplicates.
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) {
				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];
			}

		}

		return apply_filters( 'wie_available_widgets', $available_widgets );

	}

}
