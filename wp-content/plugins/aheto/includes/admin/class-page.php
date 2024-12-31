<?php
/**
 * The admin-page functionality.
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
 * Page class.
 */
class Page {

	use Hooker;

	/**
	 * Unique ID used for menu_slug.
	 *
	 * @var string
	 */
	public $id = null;

	/**
	 * The text to be displayed in the title tags of the page.
	 *
	 * @var string
	 */
	public $title = null;

	/**
	 * The slug name for the parent menu.
	 *
	 * @var string
	 */
	public $parent = null;

	/**
	 * The The on-screen name text for the menu.
	 *
	 * @var string
	 */
	public $menu_title = null;

	/**
	 * The capability required for this menu to be displayed to the user.
	 *
	 * @var string
	 */
	public $capability = 'manage_options';

	/**
	 * The icon for this menu.
	 *
	 * @var string
	 */
	public $icon = AHETO_URL . '/assets/admin/img/logos/small-logo.png';

	/**
	 * The position in the menu order this menu should appear.
	 *
	 * @var int
	 */
	public $position = -1;

	/**
	 * The function/file that displays the page content for the menu page.
	 *
	 * @var string|function
	 */
	public $render = null;

	/**
	 * The function that run on page POST to save data.
	 *
	 * @var fucntion
	 */
	public $onsave = null;

	/**
	 * Hold contextual help tabs.
	 *
	 * @var array
	 */
	public $help = null;

	/**
	 * Hold scripts and styles.
	 *
	 * @var array
	 */
	public $assets = null;

	/**
	 * The Constructor
	 *
	 * @param string $id     Admin page unique id.
	 * @param string $title  Title of the admin page.
	 * @param array  $config Optional. Override page settings.
	 */
	public function __construct( $id, $title, $config = [] ) {

		// Early bail!
		if ( ! $id ) {
			wp_die( esc_html__( '$id variable required', 'aheto' ), esc_html__( 'Variable Required', 'aheto' ) );
		}

		if ( ! $title ) {
			wp_die( esc_html__( '$title variable required', 'aheto' ), esc_html__( 'Variable Required', 'aheto' ) );
		}

		$this->id    = $id;
		$this->title = $title;
		$this->config( $config );

		if ( ! $this->menu_title ) {
			$this->menu_title = $title;
		}

		$this->action( 'init', 'init' );
	}

	/**
	 * Init admin page when WordPress Initialises
	 */
	public function init() {

		$priority = $this->parent ? intval( $this->position ) : -1;
		$this->action( 'admin_menu', 'register_menu', $priority );

		// If not the page is not this page stop here.
		if ( ! $this->is_current_page() ) {
			return;
		}

		if ( ! is_null( $this->onsave ) && is_callable( $this->onsave ) ) {
			$this->action( 'admin_init', 'save' );
		}

		if ( ! empty( $this->assets ) ) {
			$this->action( 'admin_enqueue_scripts', 'enqueue' );
		}

		if ( ! empty( $this->help ) ) {
			$this->add_filter( 'contextual_help', 'contextual_help' );
		}

		$this->action( 'admin_body_class', 'body_class' );
	}

	/**
	 * Register Admin Menu
	 */
	public function register_menu() {

		if ( ! $this->parent ) {
			add_menu_page( $this->title, $this->menu_title, $this->capability, $this->id, [ $this, 'display' ], aheto()->plugin_icon(), $this->position );
			return;
		}

		add_submenu_page( $this->parent, $this->title, $this->menu_title, $this->capability, $this->id, [ $this, 'display' ] );
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue() {

		if ( isset( $this->assets['styles'] ) && ! empty( $this->assets['styles'] ) ) {
			foreach ( $this->assets['styles'] as $handle => $src ) {
				wp_enqueue_style( $handle, $src, null, null );
			}
		}

		if ( isset( $this->assets['scripts'] ) && ! empty( $this->assets['scripts'] ) ) {
			foreach ( $this->assets['scripts'] as $handle => $src ) {
				wp_enqueue_script( $handle, $src, null, null, true );
			}
		}
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
	 * Save anything you want using onsave function
	 */
	public function save() {
		call_user_func( $this->onsave, $this );
	}

	/**
	 * Contextual Help
	 */
	public function contextual_help() {
		$screen = get_current_screen();

		foreach ( $this->help as $tab_id => $tab ) {
			ob_start();
			$tab['id'] = $tab_id;

			// If it is a function.
			if ( isset( $tab['content'] ) && is_callable( $tab['content'] ) ) {
				call_user_func( $tab['content'] );
			}

			// If it is a file.
			if ( isset( $tab['view'] ) && $tab['view'] ) {
				require $tab['view'];
			}

			$tab['content'] = ob_get_clean();
			$screen->add_help_tab( $tab );
		}
	}

	/**
	 * Render admin page content using render function you passed in config
	 */
	public function display() {
		if ( is_null( $this->render ) ) {
			return;
		}

		if ( is_callable( $this->render ) ) {
			call_user_func( $this->onrender, $this );
			return;
		}

		if ( is_string( $this->render ) && file_exists($this->render) ) {
			include_once $this->render;
			return;
		}
	}

	/**
	 * Is the page is currrent page
	 *
	 * @return boolean
	 */
	protected function is_current_page() {

		$page = isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ? filter_input( INPUT_GET, 'page' ) : false;
		return $page === $this->id;
	}

	/**
	 * Inject config into class
	 *
	 * @param array $config Array of configuration to add into class as variables.
	 */
	protected function config( $config = [] ) {
		if ( ! empty( $config ) ) {
			foreach ( $config as $key => $value ) {
				$this->$key = $value;
			}
		}
	}
}
