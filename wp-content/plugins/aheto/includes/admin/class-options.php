<?php
/**
 * The option-page functionality.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto/Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use CMB2_hookup;
use Aheto\Helper;
use Aheto\Traits\CMB2;
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Options class.
 */
class Options {

	use CMB2;
	use Hooker;

	/**
	 * Page title.
	 *
	 * @var string
	 */
	public $title = 'Settings';

	/**
	 * Menu title.
	 *
	 * @var string
	 */
	public $menu_title = 'Settings';

	/**
	 * Hold tabs for page.
	 *
	 * @var array
	 */
	public $tabs = [];

	/**
	 * Menu Position.
	 *
	 * @var int
	 */
	public $position = 10;

	/**
	 * The capability required for this menu to be displayed to the user.
	 *
	 * @var string
	 */
	public $capability = 'manage_options';

	/**
	 * CMB2 option page id.
	 *
	 * @var string
	 */
	private $cmb_id = null;

	/**
	 * CMB2 instance.
	 *
	 * @var CMB2
	 */
	private $cmb2 = null;

	/**
	 * The Constructor
	 *
	 * @param array $config Option configuration array.
	 */
	public function __construct( $config ) {

		$this->config( $config );
		$this->cmb_id = $this->key . '_options';
		aheto()->settings->add_option( $this->key, isset( $this->prefix ) ? $this->prefix : '' );

		$this->action( 'admin_post_' . $this->key, 'reset_options', 2 );
		$this->action( 'cmb2_admin_init', 'register_cmb2', $this->position );
		$this->action( 'cmb2_init_hookup_' . $this->cmb_id, 'set_defaults', 11 );

		if ( ! $this->is_current_page() ) {
			return;
		}

		$this->action( 'admin_enqueue_scripts', 'enqueue' );
		$this->action( 'admin_body_class', 'body_class' );
	}

	/**
	 * Create option object and add settings
	 */
	function register_cmb2() {


		$cmb = new_cmb2_box([
			'id'           => $this->cmb_id,
			'title'        => $this->title,
			'object_types' => [ 'options-page' ],

			'parent_slug'  => 'aheto',
			'menu_icon'  => $this->menu_icon,
			'cmb_styles'   => false,
			'option_key'   => $this->key,
			'menu_title'   => $this->menu_title,
			'capability'   => $this->capability,
			'display_cb'   => [ $this, 'display' ],
		]);

		$tabs = $this->get_tabs();
		$cmb->add_field([
			'id'         => 'setting-panel-container-' . $this->cmb_id,
			'type'       => 'tab_container_open',
			'tabs'       => $tabs,
			'save_field' => false,
		]);

		foreach ( $tabs as $id => $tab ) {

			if ( isset( $tab['type'] ) && 'seprator' === $tab['type'] ) {
				continue;
			}

			if ( ! isset( $tab['file'] ) || empty( $tab['file'] ) ) {
				continue;
			}

			$cmb->add_field([
				'name'       => esc_html__( 'Panel', 'aheto' ),
				'id'         => 'setting-panel-' . $id,
				'type'       => 'tab_open',
				'save_field' => false,
			]);

			include $tab['file'];

			/**
			 * Add setting into specific tab of panel.
			 *
			 * The dynamic part of the hook name. $id, is the tab id.
			 *
			 * @param CMB2 $cmb CMB2 object.
			 */
			$this->do_action( 'option_settings_' . $id, $cmb );

			$cmb->add_field([
				'id'         => 'setting-panel-' . $id . '-close',
				'type'       => 'tab_close',
				'save_field' => false,
			]);
		}

		$cmb->add_field([
			'id'         => 'setting-panel-container-close-' . $this->cmb_id,
			'type'       => 'tab_container_close',
			'save_field' => false,
		]);

		$this->cmb2_pre_init( $cmb );
		$this->cmb2 = $cmb;
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue() {
		$screen = get_current_screen();

		if ( ! Helper::str_contains( $this->key, $screen->id ) ) {
			return;
		}

		$color_picker_strings = array(
			'clear'            => __( 'Clear', 'aheto' ),
			'clearAriaLabel'   => __( 'Clear color', 'aheto' ),
			'defaultString'    => __( 'Default', 'aheto' ),
			'defaultAriaLabel' => __( 'Select default color', 'aheto' ),
			'pick'             => __( 'Select Color', 'aheto' ),
			'defaultLabel'     => __( 'Color value', 'aheto' ),
		);
		

		CMB2_hookup::enqueue_cmb_css();
		wp_enqueue_style( 'option-panel', aheto()->plugin_url() . 'assets/admin/css/option-panel.css', [ 'aheto-common', 'aheto-cmb2' ], aheto()->version );
        //wp_enqueue_style( 'font-awesome-5', 	aheto()->plugin_url() . 'assets/fonts/font-awesome-5/all.min.css', [ 'aheto-common', 'aheto-cmb2' ], aheto()->version );

		wp_enqueue_style( 'font-awesome-5', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css', [ 'aheto-common', 'aheto-cmb2' ], aheto()->version );


		wp_enqueue_script( 'jquery-migrate', '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js', '', aheto()->version , true );
		wp_enqueue_script( 'wp-color-picker-alpha', aheto()->plugin_url() . 'assets/admin/js/wp-color-picker-alpha.min.js', [ 'wp-color-picker' ], '2.1.3', true );
		wp_enqueue_script( 'aheto-option-panel', aheto()->plugin_url() . 'assets/admin/js/option-panel.js', [ 'aheto-common', 'jquery-migrate' ], aheto()->version, true );
		wp_enqueue_script( 'aheto-conditionals', aheto()->plugin_url() . 'assets/admin/js/cmb2-conditionals.js', [ 'aheto-common' ], aheto()->version, true );

		wp_localize_script( 'wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );

	}

	/**
	 * Add classes to <body> of WordPress admin
	 *
	 * @param  string|array $classes  Optional. One or more classes to add to the class list.
	 * @return string
	 */
	public function body_class( $classes = '' ) {
		return $classes . 'aheto-page';
	}

	/**
	 * Display Setting on a page
	 *
	 * @param CMB2_Options_Hookup $cmb2 CMB2_Options_Hookup Instace.
	 */
	public function display( $cmb2 ) {
		?>

        <div class="wrap" style="max-width: 1220px">
            <span class="wp-header-end"></span>
        </div>

		<div class="wrap aheto-wrap aheto-wrap-settings main-wrap">

			<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

			<div class="aheto-option-content">

				<div class="aheto-option-body">

					<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $this->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
						<input type="hidden" name="action" value="<?php echo esc_attr( $this->key ); ?>">
						<?php $cmb2->options_page_metabox(); ?>
					</form>

				</div>

			</div>

		</div>
		<?php
	}

	/**
	 * Get setting tabs
	 *
	 * @return array
	 */
	public function get_tabs() {

		$filter = str_replace( '-', '_', str_replace( 'aheto-', '', $this->key ) );
		/**
		 * Allow developers to add new tabs into option panel.
		 *
		 * The dynamic part of hook is, page name without 'aheto-' prefix.
		 *
		 * @param array $tabs
		 */
		return $this->do_filter( "admin_{$filter}_tabs", $this->tabs );
	}

	/**
	 * Reset Options
	 */
	public function reset_options() {

		$url = wp_get_referer();
		if ( ! $url ) {
			$url = admin_url();
		}

		if ( isset( $_POST['reset-cmb'], $_POST['action'] ) && $this->key === $_POST['action'] ) {
			delete_option( $this->key );
			wp_safe_redirect( esc_url_raw( $url ), \WP_Http::SEE_OTHER );
			exit;
		}
	}

	/**
	 * Set the default values if not set.
	 *
	 * @param CMB2 $cmb The CMB2 object to hookup.
	 */
	public function set_defaults( $cmb ) {

		$save_defaults = empty( get_option( $this->key ) );

		if ( false === $save_defaults ) {
			return;
		}
		foreach ( $cmb->prop( 'fields' ) as $id => $field_args ) {
			$type  = $field_args['type'];
			$field = $cmb->get_field( $id );
			if ( isset( $field_args['default'] ) || isset( $field_args['default_cb'] ) ) {
				$defaults[ $id ] = $field->get_default();
			}
		}

		// Save Defaults if any.
		if ( ! empty( $defaults ) ) {
			add_option( $this->key, $defaults );
		}
	}
}
