<?php
/**
 * The Aheto
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Settings;
use Aheto\Post_Types;
use Aheto\Json_Center;
use Aheto\Traits\Hooker;
use Aheto\Admin\Admin;
use Aheto\Admin\Mega_Menu;
use Aheto\Builder_Loader;
use Aheto\Frontend\Frontend;
use Aheto\Notification_Center;
use Aheto\Template_Kit\API;
use Aheto\Dynamic_CSS;

defined( 'ABSPATH' ) || exit;

/**
 * Main Aheto Class.
 */
class Aheto {

	use Hooker;

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '0.9.0';

	/**
	 * Plugin database version.
	 *
	 * @var string
	 */
	public $db_version = '1';

	/**
	 * The single instance of the class.
	 *
	 * @var Aheto
	 */
	protected static $_instance = null;

	/**
	 * Possible error message.
	 *
	 * @var null|WP_Error
	 */
	protected $error = null;

	/**
	 * Halt plugin loading.
	 *
	 * @var boolean
	 */
	private $is_critical = false;

	/**
	 * Minimum WordPress version required by the plugin.
	 *
	 * @var string
	 */
	public $wordpress_version = '3.8';

	/**
	 * Minimum PHP version required by the plugin.
	 *
	 * @var string
	 */
	public $php_version = '5.6';

	/**
	 * Factory.
	 *
	 * @var array
	 */
	private $container = [];

	/**
	 * Plugin url.
	 *
	 * @var string
	 */
	private $plugin_url = null;

	/**
	 * Plugin path.
	 *
	 * @var string
	 */
	private $plugin_dir = null;

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden.', 'aheto' ), $this->version );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing instances of this class is forbidden.', 'aheto' ), $this->version );
	}

	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 * @param string $prop Key to get.
	 *
	 * @return mixed
	 */
	public function __get( $prop ) {

		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		return $this->$prop;
	}

	/**
	 * Magic setter to bypass referencing plugin.
	 *
	 * @param mixed $prop Key to set.
	 * @param mixed $value Value to set.
	 */
	public function __set( $prop, $value ) {

		if ( property_exists( $this, $prop ) ) {
			$this->$prop = $value;
		}

		$this->container[ $prop ] = $value;
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param mixed $prop Property to check.
	 *
	 * @return mixed
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 * Main Aheto instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return Aheto
	 * @see aheto()
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) && ! ( self::$_instance instanceof Aheto ) ) {
			self::$_instance = new Aheto();
			self::$_instance->setup();

		}

		return self::$_instance;
	}

	/**
	 * Aheto constructor.
	 */
	private function __construct() {
	}

	/**
	 * Setup the plugin.
	 *
	 * Sets up all the appropriate hooks and actions within our plugin.
	 */
	private function setup() {

		if ( $this->check_requirements() ) {
			return;
		}

		$this->hooks();

		// Loaded action.
		$this->do_action( 'loaded' );
	}

	/**
	 * Hook into actions and filters.
	 */
	private function hooks() {
		register_activation_hook( AHETO_FILE, [ 'Aheto\\Installer', 'install' ] );
		register_deactivation_hook( AHETO_FILE, 'flush_rewrite_rules' );

		$this->action( 'init', 'instantiate', 0 );
		$this->action( 'init', 'load_plugin_textdomain' );
		$this->action( 'init', 'default_skin' );
		$this->action( 'admin_menu', 'remove_aheto_cpt_menus' );

		$this->action( 'admin_init', 'allFontsFromSkin', 10 );

		$this->action( 'wp_ajax_likes_ajax', 'likes_function_callback', 10 );
		$this->action( 'wp_ajax_nopriv_likes_ajax', 'likes_function_callback', 10 );

		$this->action( 'wp_ajax_nopriv_aheto_page_list', 'navigation_page_list_ajax', 10 );
		$this->action( 'wp_ajax_aheto_page_list', 'navigation_page_list_ajax', 10 );

		$this->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
		$this->filter( 'plugin_action_links_' . plugin_basename( AHETO_FILE ), 'plugin_action_links' );

		add_shortcode( 'pages_api_shortcode', array( $this, 'pages_api_shortcode_func' ) );
		add_shortcode( 'pages_api_search_shortcode', array( $this, 'pages_api_search_shortcode_func' ) );
		add_shortcode( 'categories_api_shortcode', array( $this, 'cats_api_shortcode_func' ) );

	}

	/**
	 * Function callback for shortcode for getting API pages by parameters
	 *
	 * @return mixed
	 */

	public function pages_api_search_shortcode_func() {
		// [pages_api_search_shortcode]
		wp_enqueue_script( 'aheto-search-filter' );

		$content = '<div class="aheto-api-pages__search-wrap">';
		$content .= '<input id="aheto-api-input" type="text" placeholder="' . esc_attr__( 'Search...', 'aheto' ) . '">';
		$content .= '<button class="ion-android-search aheto-api-pages__btn"></button>';
		$content .= '</div>';

		return $content;

	}


	/**
	 * Function callback for shortcode for getting API pages by parameters
	 *
	 * @return mixed
	 */
	public function pages_api_shortcode_func( $atts, $content = "" ) {

		// [pages_api_shortcode type='blocks'],
		// [pages_api_shortcode type='pages' cat='events'],
		// [pages_api_shortcode type='pages']
		// [pages_api_shortcode type='pages' home='home']
		// [pages_api_shortcode type='pages' home='home' cat='events']

		$template_kit = API::get();

		$type      = ! empty( $atts['type'] ) ? $atts['type'] : false;
		$only_home = ( empty( $atts['home'] ) || ( $type == 'block' ) ) ? false : true;
		$cat       = ( ( empty( $atts['cat'] ) || ( $type == 'blocks' ) ) ) ? false : $atts['cat'];

		$upload_dir = wp_upload_dir();
		$upload_dir = $upload_dir['basedir'];
		$file_name  = "aheto-demo/api-$type.json";
		$file_url   = $upload_dir . DIRECTORY_SEPARATOR . $file_name;

		$file_exist = file_exists( $file_url );

		if ( ! $file_exist ) {

			$templates = $template_kit->get_templates( false, $cat, $type );

			$json = array();
			if ( ! empty( $templates ) ) {
				foreach ( $templates as $template ) {
					if ( $only_home ) {
						if ( strstr( $template['title'], 'Home' ) ) {
							$json[] = array(
								'preview_url' => $template['preview_url'],
								'title'       => $template['title'],
								'thumbnail'   => $template['thumbnail'],
								'shortcode_order'   => $template['shortcode_order'],
							);
						}
					} else {
						$json[] = array(
							'preview_url' => $template['preview_url'],
							'title'       => $template['title'],
							'thumbnail'   => $template['thumbnail'],
							'shortcode_order'   => $template['shortcode_order'],
						);
					}
				}

				$templates = $json;
				$json      = json_encode( $json );

				file_put_contents( $file_url, $json );
				chmod( $file_url, 0777 );
			}
		} else {
			$json      = file_get_contents( $file_url );
			$templates = json_decode( $json, true );
		}

		$content = '<div class="aheto-api-pages__container">';

		$content .= '<div id="aheto-api-pages" class="aheto-api-pages__wrap">';
		if ( ! empty( $templates ) ) {
			$html_api_code = $this->set_api_pages_cats_html( $templates, $type );
			$content       .= $html_api_code;
		}
		$content .= '</div></div>';

		return $content;
	}


	public function record_sort( $records, $field, $reverse = false ) {
		$hash = array();

		$index = 1000;


		foreach ( $records as $record ) {

			if(!isset($record[ $field ] ) || empty($record[ $field ] )){
				$record[ $field ] =  $index;
				$index++;
			}
			$hash[ $record[ $field ] ] = $record;
		}

		( $reverse ) ? krsort( $hash ) : ksort( $hash );

		$records = array();

		foreach ( $hash as $record ) {
			$records [] = $record;
		}

		return $records;
	}


	/**
	 * Function callback for shortcode for getting API categories
	 *
	 * @return mixed
	 */
	public function cats_api_shortcode_func( $atts, $content = "" ) {

		// [categories_api_shortcode]
		$template_kit = API::get();

		$upload_dir = wp_upload_dir();
		$upload_dir = $upload_dir['basedir'];
		$file_name  = "aheto-demo/api-categories.json";
		$file_url   = $upload_dir . DIRECTORY_SEPARATOR . $file_name;

		$file_exist = file_exists( $file_url );

		if ( ! $file_exist ) {

			$templates = $template_kit->get_themes_grouped();

			$json = array();

			if ( ! empty( $templates ) ) {
				foreach ( $templates as $template ) {
					$link   = ! empty( $template['demo_url'] ) ? $template['demo_url'] : '';
					$json[] = array(
						'preview_url' => $link,
						'title'       => $template['name'],
						'thumbnail'   => $template['aheto-category-screenshot'],
					);
				}

				$templates = $json;
				$json      = json_encode( $json );

				file_put_contents( $file_url, $json );
				chmod( $file_url, 0777 );
			}

		} else {
			$json      = file_get_contents( $file_url );
			$templates = json_decode( $json, true );
		}


		$content = '<div class="aheto-api-pages__container">';

		$content .= '<div id="aheto-api-pages" class="aheto-api-pages__wrap">';

		if ( ! empty( $templates ) ) {
			$html_api_code = $this->set_api_pages_cats_html( $templates, 'cats' );
			$content       .= $html_api_code;
		}

		$content .= '</div></div>';

		return $content;
	}

	/**
	 * Function setting html layout from input array
	 *
	 * @param $json
	 *
	 * @return string
	 */
	private function set_api_pages_cats_html( $json, $type ) {
		wp_enqueue_style( 'aheto-api-pages-demo', aheto()->plugin_url() . 'assets/frontend/css/api-pages-demo.css', null, '1.0.5' );
		wp_enqueue_script( 'aheto-lazy' );
		wp_enqueue_script( 'aheto-main' );

		$blocks_cat = [
			'All',
			'Awards',
			'Banner',
			'Blog',
			'Call To Action',
			'Career',
			'Clients',
			'Contact',
			'Content',
			'Ecommerce',
			'Faq',
			'Features',
			'Portfolio',
			'Price',
			'Progress Bar',
			'Team',
			'Testimonial',
			'Coming Soon'
		];
		$content    = '';

		if ( $type === 'blocks' ) {

			$content .= '<div class="aheto-api-pages-cats">';
			$content .= '<h6><select class="aheto-api-pages-cats__select">';

			foreach ( $blocks_cat as $item ) {
				$content .= '<option>' . $item . '</option>';
			}

			$content .= '</select></h6>';
			$content .= '</div>';
		}

		$content .= '<div class="aheto-api-pages-wrap ' . esc_attr( $type ) . '">';

		$json = $this->record_sort($json, "shortcode_order");

		foreach ( $json as $template ) {

			$content .= '
					<a href="' . esc_url( $template['preview_url'] ) . '" class="aheto-api-pages__item ' . esc_attr( $type ) . '" target="_blank">

						<span class="aheto-api-pages__img ' . esc_attr( $type ) . '">
							<img data-lazy-src="' . esc_url( $template['thumbnail'] ) . '">
						</span>

						<h6 class="aheto-api-pages__content ' . esc_attr( $type ) . '">
							' . esc_html( $template['title'] ) . '
						</h5>

					</a>
				';
		}

		$content .= '</div>';

		return $content;
	}

	/**
	 * Default skin
	 */
	public function default_skin() {
		$aheto_skins = Helper::skins();

		if ( ( is_array( $aheto_skins ) && count( $aheto_skins ) === 0 ) || empty( $aheto_skins ) ) {

			$file_url = aheto()->plugin_url() . 'includes/admin/default-skin.json';

			// Parse Options.
			$wp_filesystem = Helper::init_filesystem();
			$settings      = $wp_filesystem->get_contents( $file_url );
			$settings      = json_decode( $settings, true );

			$name      = is_array($settings) ? $settings['name'] : esc_html__('Aheto Default', 'aheto');
			$generated = get_option( 'aheto_generated_skins' ) ? get_option( 'aheto_generated_skins' ) : array();

			foreach ( (array) $settings as $key => $options ) {
				if ( ( $key != 'name' ) && ( $key != 'aheto_generated_skins' ) ) {
					$key = str_replace( 'aheto_skin_', '', $key );

					if ( ! array_key_exists( $key, $generated ) ) {
						$generated[ $key ] = $name;
						new Dynamic_CSS( $key, $settings[ 'aheto_skin_' . $key ] );
						update_option( 'aheto_skin_' . $key, $options );
						update_option( 'aheto_generated_skins', $generated );
					}
				}
			}

			wp_cache_flush();

		}
	}


	public function allFontsFromSkin() {

		$allFonts = '';

		foreach ( Helper::skins() as $id => $name ) {
			$settings    = get_option( 'aheto_skin_' . $id );
			$font        = isset( $settings["headings"]["font-family"] ) ? $settings["headings"]["font-family"] : '';
			$fontHeading = isset( $settings["heading1"]["font-family"] ) ? $settings["heading1"]["font-family"] : '';
			$fontText    = isset( $settings["text_font"]["font-family"] ) ? $settings["text_font"]["font-family"] : '';

			$allFonts .= ! empty( $font ) && strpos( $allFonts, $font ) === false ? $font . ',' : '';
			$allFonts .= ! empty( $fontHeading ) && strpos( $allFonts, $fontHeading ) === false ? $fontHeading . ',' : '';
			$allFonts .= ! empty( $fontText ) && strpos( $allFonts, $fontText ) === false ? $fontText . ',' : '';

		}

		$allFonts = substr( $allFonts, 0, - 1 );

		setcookie( "AhetoSkinsFonts", $allFonts, 0, '/' );
	}


	public function remove_aheto_cpt_menus() {

		$header_path = Helper::get_settings( 'general.theme_header' );
		$footer_path = Helper::get_settings( 'general.theme_footer' );

		if ( isset( $header_path ) && $header_path ) {

			remove_menu_page( 'edit.php?post_type=aheto-header' );
		}

		if ( isset( $footer_path ) && $footer_path ) {

			remove_menu_page( 'edit.php?post_type=aheto-footer' );
		}

	}

	/**
	 * Instantiate classes.
	 *
	 * @return void
	 */
	public function instantiate() {
		$this->json         = new Json_Center;
		$this->settings     = new Settings;
		$this->notification = new Notification_Center;

		// Just Init.
		new Post_Types;
		new Builder_Loader;
		new Page_Templates;
		new Mega_Menu;

		$this->settings->add_option( 'aheto-general-settings', 'general' );

		$this->init_css_generator();

		// Admin Only.
		if ( is_admin() ) {
			$this->admin = new Admin;
		}

		// Frontend Only.
		if ( ! is_admin() || 'elementor' === Helper::param_get( 'action' ) || 'elementor_ajax' === Helper::param_post( 'action' ) ) {
			$this->frontend = new Frontend;
		}
	}

	/**
	 * Init css generator
	 */
	private function init_css_generator() {
		$hash = [
			'elementor'       => '\\Aheto\\CSS\\Generator\\Elementor',
			'visual-composer' => '\\Aheto\\CSS\\Generator\\Visual_Composer',
		];

		$builder = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		if ( isset( $hash[ $builder ] ) ) {
			$this->container['css_generator'] = new $hash[ $builder ];
		}
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *     - WP_LANG_DIR/aheto/aheto-LOCALE.mo
	 *     - WP_LANG_DIR/plugins/aheto-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'aheto' );

		unload_textdomain( 'aheto' );
		$aheto_folder_name = trailingslashit( dirname( plugin_basename( AHETO_FILE ) ) );

		load_textdomain( 'aheto', WP_LANG_DIR . '/' . $aheto_folder_name . 'aheto-' . $locale . '.mo' );

		load_plugin_textdomain( 'aheto', false, $this->plugin_dir() . '/languages/' );
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$more = [ '<a href="' . Helper::get_admin_url( 'general-settings' ) . '">' . esc_html__( 'Settings', 'aheto' ) . '</a>' ];

		if ( Helper::is_setup_wizard() ) {
			$more[] = '<a href="' . Helper::get_admin_url( 'setup' ) . '">' . esc_html__( 'Setup Wizard', 'aheto' ) . '</a>';
		}

		return array_merge( $links, $more );
	}

	/**
	 * Function callback for likes Ajax
	 *
	 */
	public function likes_function_callback() {

		$user = wp_get_current_user();
		$post = $_POST['id_p'];

		$array = get_post_meta( $post, 'aheto_post_likes', true );
		if ( empty( $array ) ) {
			$array = array();
		}

		if ( $array[ $user->ID ] && ( $array[ $user->ID ] == 1 ) ) {
			unset( $array[ $user->ID ] );
		} else {
			$array[ $user->ID ] = 1;
		}

		update_post_meta( $post, 'aheto_post_likes', $array );

		wp_send_json( [ 'success' => 'true', 'message' => 'Done', 'result_count' => count( $array ) ], 200 );
	}


	public function navigation_page_list_ajax() {
		// Make your response and echo it.

		$page_array     = explode( '+++', $_POST['page_list'] );
		$page_thumbnail = [];

		foreach ( $page_array as $page_url ) {

			$page_id = url_to_postid( $page_url );

			$image_url = ! empty( $page_id ) ? get_the_post_thumbnail_url( $page_id, 'large' ) : '';

			$page_thumbnail[] = ! empty( $image_url ) && $image_url ? $image_url : '';
		}


		wp_send_json( $page_thumbnail, 200 );

		// Don't forget to stop execution afterward.
		wp_die();
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param mixed $links Plugin Row Meta.
	 * @param mixed $file Plugin Base file.
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {

		if ( plugin_basename( AHETO_FILE ) !== $file ) {
			return $links;
		}

		return array_merge( $links, [
			'<a href="' . Helper::get_admin_url( 'about' ) . '">' . esc_html__( 'Getting Started', 'aheto' ) . '</a>',
			'<a href="' . esc_url( '#doc_url' ) . '">' . esc_html__( 'Documentation', 'aheto' ) . '</a>',
		] );
	}

	/**
	 * Check that the WordPress and PHP setup meets the plugin requirements.
	 *
	 * @return boolean
	 */
	private function check_requirements() {

		$this->is_wp_enough();
		$this->is_php_enough();

		return $this->is_critical;
	}

	/**
	 * Check if WordPress version is enough to run this plugin.
	 */
	public function is_wp_enough() {

		if ( version_compare( get_bloginfo( 'version' ), $this->wordpress_version, '<' ) ) {
			$this->add_error(
			/* translators: WordPress Version */
				sprintf( aheto()->plugin_name() . esc_html__( ' requires WordPress version %s or above. Please update WordPress to run this plugin.', 'aheto' ), $this->wordpress_version )
			);
			$this->is_critical = true;
		}
	}

	/**
	 * Check if PHP version is enough to run this plugin.
	 */
	public function is_php_enough() {

		if ( version_compare( phpversion(), $this->php_version, '<' ) ) {
			$this->add_error(
			/* translators: PHP Version */
				sprintf( aheto()->plugin_name() . esc_html__( ' requires PHP version %s or above. Please update PHP to run this plugin.', 'aheto' ), $this->php_version )
			);
			$this->is_critical = true;
		}
	}

	/**
	 * Get the plugin dir.
	 *
	 * @return string
	 */
	public function plugin_dir() {

		if ( is_null( $this->plugin_dir ) ) {
			$this->plugin_dir = untrailingslashit( plugin_dir_path( AHETO_FILE ) ) . '/';
		}

		return $this->plugin_dir;
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {

		if ( is_null( $this->plugin_url ) ) {
			$this->plugin_url = untrailingslashit( plugin_dir_url( AHETO_FILE ) ) . '/';
		}

		return $this->plugin_url;
	}

	/**
	 * Get the plugin name.
	 *
	 * @return string
	 */
	public function plugin_name() {

		$plugin_name = 'Aheto';

		return apply_filters( "aheto_plugin_name", $plugin_name );
	}

	/**
	 * Get the plugin icon.
	 *
	 * @return string
	 */


	public function plugin_icon() {

		$plugin_icon = AHETO_URL . '/assets/admin/img/logos/small-logo.png';

		return apply_filters( "aheto_plugin_icon", $plugin_icon );
	}


	/**
	 * Get the plugin desktop logo.
	 *
	 * @return string
	 */


	public function plugin_dashboard_desktop_logo() {

		$plugin_dashboard_desktop_logo = aheto()->assets() . 'admin/img/logos/desc-logo.png';

		return apply_filters( "aheto_plugin_dashboard_desktop_logo", $plugin_dashboard_desktop_logo );
	}


	/**
	 * Get the plugin desktop logo.
	 *
	 * @return string
	 */


	public function plugin_dashboard_mobile_logo() {

		$plugin_dashboard_mobile_logo = aheto()->assets() . 'admin/img/logos/desc-logo.png';

		return apply_filters( "aheto_plugin_dashboard_mobile_logo", $plugin_dashboard_mobile_logo );
	}

	/**
	 * Get the plugin skin create.
	 *
	 * @return string
	 */


	public function plugin_dashboard_skin_create() {

		$plugin_dashboard_skin_create = aheto()->assets() . 'admin/img/sidebar-icon/create-skin.png';

		return apply_filters( "plugin_dashboard_skin_create", $plugin_dashboard_skin_create );
	}

	public function plugin_dashboard_img() {

		$plugin_dashboard_skin_create = aheto()->assets() . 'admin/img/dashboard-info.png';

		return apply_filters( "plugin_dashboard_skin_create", $plugin_dashboard_skin_create );
	}


	/**
	 * Set the plugin dashboard pages.
	 *
	 * @return string
	 */


	public function plugin_dashboard_pages() {

		$plugin_dashboard_pages = [
			'setup'            => [
				aheto()->plugin_name() . esc_html__( ' Setup', 'aheto' ),
				'<svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
<path class="active" fill-rule="evenodd" clip-rule="evenodd" d="M5.3125 1.79552C5.3125 0.402143 6.82474 -0.457545 8.0187 0.257073L31.121 14.0843C32.3293 14.8076 32.2775 16.5796 31.0292 17.2248L27.1823 19.2131L20.4705 22.6822V22.6822C20.402 22.7217 20.3198 22.6382 20.3555 22.5677C20.8001 21.6895 20.795 20.6192 20.2804 19.7239L18.6358 16.8626C17.9285 15.6319 16.4541 15.0733 15.1133 15.529V15.529C14.7658 15.6471 14.3932 15.4294 14.3216 15.0695V15.0695C14.0441 13.6754 12.8254 12.6724 11.4106 12.6724H8.12139C7.05583 12.6724 6.10164 13.2413 5.57686 14.1177C5.51629 14.2188 5.3125 14.1762 5.3125 14.0583V14.0583V1.79552ZM5.3125 29.7195L5.3125 18.1088L6.15045 18.3935C6.3643 18.2519 6.58599 18.123 6.81421 18.0077L7.31505 15.4923C7.3919 15.1062 7.72943 14.8283 8.12139 14.8283H11.4106C11.8026 14.8283 12.1401 15.1062 12.2169 15.4923L12.7177 18.0077C12.9459 18.123 13.1677 18.2519 13.3816 18.3935L15.8014 17.5711C16.1727 17.4449 16.5811 17.5996 16.7771 17.9406L18.4217 20.8019C18.6176 21.1429 18.5468 21.5754 18.2524 21.8353L16.3333 23.5295C16.3407 23.6578 16.3444 23.7863 16.3444 23.9142C16.3444 24.042 16.3407 24.1704 16.3333 24.2988L16.8628 24.7663L6.94826 30.4938L6.81421 29.8206C6.58599 29.7053 6.36424 29.5764 6.15039 29.4348L5.3125 29.7195ZM6.47679 23.9142C6.47679 22.0924 7.95233 20.6102 9.766 20.6102C11.5797 20.6102 13.0552 22.0924 13.0552 23.9142C13.0552 25.736 11.5797 27.2181 9.766 27.2181C7.95233 27.2181 6.47679 25.736 6.47679 23.9142Z" fill="white"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M16.3333 24.2988L18.2525 25.993C18.547 26.2529 18.6178 26.6855 18.4217 27.0264L16.7771 29.8877C16.5812 30.2288 16.1728 30.3832 15.8015 30.2572L13.3815 29.4348C13.1677 29.5764 12.946 29.7053 12.7178 29.8206L12.2169 32.336C12.1401 32.7221 11.8026 33 11.4106 33H8.12143C7.72946 33 7.39194 32.7221 7.31508 32.336L6.81424 29.8206C6.58603 29.7053 6.36428 29.5764 6.15043 29.4348L3.7305 30.2571C3.35926 30.3833 2.9509 30.2287 2.75487 29.8877L1.11026 27.0264C0.914282 26.6855 0.985109 26.2529 1.27955 25.993L3.19869 24.2989C3.19129 24.1707 3.18762 24.0422 3.18762 23.9142C3.18762 23.7861 3.19129 23.6577 3.19864 23.5295L1.27949 21.8353C0.985054 21.5754 0.914227 21.1429 1.11021 20.8019L2.75481 17.9406C2.95085 17.5996 3.35931 17.445 3.73045 17.5711L6.15048 18.3935C6.36433 18.2519 6.58603 18.123 6.81424 18.0077L7.31508 15.4923C7.39194 15.1062 7.72946 14.8283 8.12143 14.8283H11.4106C11.8026 14.8283 12.1401 15.1062 12.2169 15.4923L12.7178 18.0077C12.946 18.123 13.1677 18.2519 13.3816 18.3935L15.8015 17.5711C16.1727 17.4449 16.5811 17.5996 16.7771 17.9406L18.4217 20.8019C18.6177 21.1429 18.5468 21.5754 18.2524 21.8353L16.3333 23.5295C16.3407 23.6578 16.3444 23.7863 16.3444 23.9142C16.3444 24.042 16.3407 24.1704 16.3333 24.2988ZM6.47683 23.9142C6.47683 22.0924 7.95236 20.6102 9.76603 20.6102C11.5797 20.6102 13.0552 22.0924 13.0552 23.9142C13.0552 25.736 11.5797 27.2181 9.76603 27.2181C7.95236 27.2181 6.47683 25.736 6.47683 23.9142Z" fill="#5C6085"/>
</svg>
'
			],
			'setting-up'       => [
				esc_html__( 'Dashboard', 'aheto' ),
				'<svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M32 16.6154H26.3999C25.3467 16.6154 24.3867 17.2523 23.96 18.2491L20.5466 26.1831C20.3467 26.6676 19.8799 27 19.3333 27C18.7334 27 18.2266 26.5847 18.0532 26.0168L12.6133 7.21396C12.4399 6.64605 11.9333 6.23077 11.3333 6.23077C10.7334 6.23077 10.2266 6.64605 10.0532 7.21396L7.90674 14.6493C7.56006 15.8122 6.53345 16.6154 5.34668 16.6154H0C0 7.44924 7.17334 0 16 0C24.8267 0 32 7.44924 32 16.6154Z" fill="#686B92"/>
<path class="active" d="M32 16.3846C32 25.5508 24.8267 33 16 33C7.17334 33 0 25.5508 0 16.3846H5.34668C6.53345 16.3846 7.56006 15.5814 7.90674 14.4185L10.0532 6.98319C10.2266 6.41528 10.7334 6 11.3333 6C11.9333 6 12.4399 6.41528 12.6133 6.98319L18.0532 25.786C18.2266 26.3539 18.7334 26.7692 19.3333 26.7692C19.8799 26.7692 20.3467 26.4369 20.5466 25.9524L23.96 18.0184C24.3867 17.0215 25.3467 16.3846 26.3999 16.3846H32Z" fill="#ffffff"/>
</svg>
'
			],
			'general-settings' => [
				esc_html__( 'Settings', 'aheto' ),
				'<svg width="36" height="32" viewBox="0 0 36 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle class="active" cx="17.9394" cy="16" r="4.36364" fill="#D0D4EB"/>
<path d="M35.7343 13.8615C35.6219 13.008 35.1054 12.2509 34.3331 11.808C33.5708 11.3703 32.6401 11.2913 31.8089 11.5938C31.0918 11.8282 30.3073 11.4917 30.0144 10.8241C29.6491 10.0459 29.2027 9.30494 28.682 8.61214C28.2148 8.03654 28.303 7.21213 28.8824 6.73861C29.5651 6.20197 29.9512 5.3951 29.9292 4.55087C29.912 3.68958 29.4808 2.88378 28.7597 2.36602C27.573 1.50198 26.278 0.782936 24.9046 0.225409C24.0719 -0.113765 23.1221 -0.06798 22.3295 0.349646C21.5537 0.755223 21.0169 1.47956 20.8745 2.31314C20.7347 3.03252 20.0254 3.51836 19.267 3.41413C18.3846 3.32631 17.495 3.32631 16.6126 3.41413C15.854 3.51909 15.1442 3.03292 15.0051 2.31314C14.8627 1.47956 14.3259 0.755156 13.5501 0.349646C12.7576 -0.0681808 11.8076 -0.113966 10.975 0.225409C9.59678 0.779455 8.29662 1.49623 7.1049 2.35886C6.38438 2.87629 5.95307 3.68148 5.93547 4.54231C5.91564 5.3884 6.30439 6.19621 6.98973 6.73285C7.56936 7.20644 7.65699 8.03138 7.1886 8.60638C6.66778 9.29912 6.2214 10.0402 5.85619 10.8183C5.5573 11.4877 4.76493 11.8197 4.04678 11.5766C3.21971 11.2792 2.29548 11.3603 1.539 11.7965C0.765967 12.2431 0.251315 13.0047 0.143786 13.8614C-0.0479288 15.2836 -0.0479288 16.7233 0.143786 18.1454C0.256152 18.999 0.772696 19.756 1.54495 20.1989C2.30691 20.6377 3.23814 20.7167 4.06921 20.4131C4.78638 20.1773 5.57195 20.5142 5.8637 21.1828C6.22883 21.961 6.67521 22.7021 7.1961 23.3948C7.66329 23.9704 7.57511 24.7948 6.99569 25.2683C6.31295 25.805 5.92685 26.6118 5.94893 27.456C5.96611 28.3173 6.39734 29.1231 7.11836 29.6409C8.30966 30.5033 9.60932 31.22 10.9869 31.7744C11.8196 32.1135 12.7694 32.0677 13.562 31.6501C14.3379 31.2445 14.8747 30.5202 15.017 29.6866C15.1582 28.9681 15.8666 28.4829 16.6246 28.5856C17.5069 28.6734 18.3965 28.6734 19.2789 28.5856C20.0369 28.4829 20.7453 28.9681 20.8864 29.6866C21.0289 30.5202 21.5657 31.2446 22.3414 31.6501C22.7754 31.8793 23.2632 31.9997 23.7591 32C24.1568 31.9995 24.5504 31.9228 24.9165 31.7744C26.2942 31.2202 27.5939 30.5035 28.7851 29.6409C29.5056 29.1235 29.9369 28.3183 29.9545 27.4575C29.9744 26.6114 29.5856 25.8036 28.9003 25.2669C28.3211 24.7939 28.2329 23.9699 28.6999 23.3948C29.2213 22.7022 29.6682 21.9611 30.0337 21.1828C30.3283 20.5169 31.1113 20.181 31.8282 20.4131H31.8447C32.6716 20.7116 33.5964 20.6305 34.3525 20.1932C35.1158 19.7474 35.6245 18.9935 35.7342 18.1454C35.9269 16.7195 35.927 15.2759 35.7342 13.85V13.8615H35.7343ZM17.9391 23.1436C13.8097 23.1436 10.4621 19.9469 10.4621 16.0035C10.4621 12.0601 13.8096 8.86342 17.9391 8.86342C22.0686 8.86342 25.4161 12.0601 25.4161 16.0035C25.4111 19.9449 22.0665 23.1388 17.9391 23.1436Z" fill="#686B92"/>
</svg>'
			],
			'theme-options'    => [
				esc_html__( 'Theme Options', 'aheto' ),
				'<svg width="27" height="31" viewBox="0 0 27 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M19.6875 17H7.31252C3.27391 17 0 20.134 0 24C0 27.866 3.27391 31 7.31252 31H19.6875C23.7261 31 27 27.866 27 24C27 20.134 23.7261 17 19.6875 17Z" fill="#686B92"/>
<path class="active" d="M7.5 29C10.5376 29 13 26.7614 13 24C13 21.2386 10.5376 19 7.5 19C4.46243 19 2 21.2386 2 24C2 26.7614 4.46243 29 7.5 29Z" fill="white"/>
<path d="M19.6875 0H7.31252C3.27391 0 0 3.3579 0 7.5C0 11.6421 3.27391 15 7.31252 15H19.6875C23.7261 15 27 11.6421 27 7.5C27 3.3579 23.7261 0 19.6875 0Z" fill="#676A91"/>
<path class="active" d="M20 12C22.7614 12 25 9.76142 25 7C25 4.23858 22.7614 2 20 2C17.2386 2 15 4.23858 15 7C15 9.76142 17.2386 12 20 12Z" fill="white"/>
</svg>'
			],
			'skin-generator'   => [
				esc_html__( 'Design', 'aheto' ),
				'<svg width="41" height="42" viewBox="0 0 41 42" fill="none" xmlns="http://www.w3.org/2000/svg">
<g filter="url(#filter0_d)">
<path d="M36.1103 5.18175L23.9888 17L20 13.0041L31.7973 0.875266C32.999 -0.286239 34.901 -0.292527 36.1103 0.861168C37.2959 2.05749 37.2973 3.98676 36.1103 5.18175Z" fill="#686B92"/>
<path d="M24 17.0064L22.9809 17.9974L17.036 23.8017C16.9016 23.9277 16.7247 23.9984 16.5405 23.9999C16.3528 24.0024 16.1728 23.9253 16.0451 23.7876L13.2142 20.9562C12.9367 20.6898 12.9277 20.2488 13.194 19.9714C13.196 19.9693 13.198 19.9673 13.2 19.9652L19.0034 14.0193L19.9941 13L24 17.0064Z" fill="#D0D4EB"/>
<path d="M11.9931 20.0002C9.28139 19.9777 7.05608 22.2098 7.0002 25.0084C6.99553 25.2096 7.07339 25.4035 7.2146 25.5424C7.35587 25.68 7.54628 25.7509 7.74019 25.738C9.20767 25.6323 9.56308 26.2677 10.1371 27.3284C10.786 29.0095 12.3968 30.0805 14.1481 29.9953H14.1509C14.3252 29.9954 14.4932 29.9276 14.6211 29.8054C15.9827 28.644 16.839 26.9697 17 25.1541C16.9931 22.305 14.7532 19.9994 11.9931 20.0002Z" fill="#686B92"/>
<path class="active" d="M13.9521 29.9635C13.8531 29.6793 13.6092 29.4904 13.3356 29.4861C12.1185 29.5722 10.9996 28.7424 10.601 27.4583C10.053 25.8176 8.56444 24.812 7.00545 25.0294C6.73316 25.0508 6.49951 25.2537 6.41446 25.5427C6.38871 25.6635 6.37341 25.7868 6.36881 25.9109C6.23849 27.5702 5.70856 29.1595 4.83495 30.5112C4.20366 31.683 3.7054 32.6063 4.20233 33.38C4.57058 33.8479 5.12783 34.0737 5.67979 33.9786C7.00092 33.8939 8.3116 33.6674 9.59363 33.3022C11.1677 32.8902 12.6159 32.0212 13.7909 30.7835C13.9901 30.5727 14.054 30.2479 13.9521 29.9635Z" fill="white"/>
</g>
<defs>
<filter id="filter0_d" x="0" y="0" width="41" height="42" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
<feFlood flood-opacity="0" result="BackgroundImageFix"/>
<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
<feOffset dy="4"/>
<feGaussianBlur stdDeviation="2"/>
<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
</filter>
</defs>
</svg>
'
			],
			'templates'        => [
				esc_html__( 'Template Kits', 'aheto' ),
				'<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M27.4478 0H3.55216C1.59267 0 0 1.59267 0 3.55216V27.4478C0 29.4073 1.59267 31 3.55216 31H27.4478C29.4073 31 31 29.4073 31 27.4478V3.55216C31 1.59267 29.4073 0 27.4478 0Z" fill="#686B92"/>
<path class="active" d="M14.2084 24.8647C14.2084 26.1111 13.1945 27.125 11.9478 27.125H6.13534C4.88892 27.125 3.875 26.1111 3.875 24.8647V16.4688C3.875 15.2224 4.88892 14.2084 6.13534 14.2084H11.9478C13.1945 14.2084 14.2084 15.2224 14.2084 16.4688V24.8647Z" fill="#FAFAFA"/>
<path class="active" d="M14.2084 9.36466C14.2084 10.6111 13.1945 11.625 11.9478 11.625H6.13534C4.88892 11.625 3.875 10.6111 3.875 9.36466V6.13534C3.875 4.88892 4.88892 3.875 6.13534 3.875H11.9478C13.1945 3.875 14.2084 4.88892 14.2084 6.13534V9.36466Z" fill="#FAFAFA"/>
<path d="M27.1252 24.8647C27.1252 26.1111 26.1112 27.125 24.8648 27.125H19.0523C17.8057 27.125 16.7917 26.1111 16.7917 24.8647V21.6353C16.7917 20.3889 17.8057 19.375 19.0523 19.375H24.8648C26.1112 19.375 27.1252 20.3889 27.1252 21.6353V24.8647Z" fill="#040849"/>
<path class="active" d="M27.1252 14.5312C27.1252 15.7777 26.1112 16.7916 24.8648 16.7916H19.0523C17.8057 16.7916 16.7917 15.7777 16.7917 14.5312V6.13534C16.7917 4.88892 17.8057 3.875 19.0523 3.875H24.8648C26.1112 3.875 27.1252 4.88892 27.1252 6.13534V14.5312Z" fill="#FAFAFA"/>
</svg>
'
			],
			'import-export'    => [
				esc_html__( 'Import &amp; Export', 'aheto' ),
				'<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M23.95 30.0056H5.04999C2.81711 30.0056 1 28.1885 1 25.9556V7.0556C1 4.82272 2.81711 3.00562 5.04999 3.00562H15.85C16.5951 3.00562 17.2 3.61049 17.2 4.35553C17.2 5.10081 16.5951 5.70569 15.85 5.70569H5.04999C4.30619 5.70569 3.70007 6.3118 3.70007 7.0556V25.9556C3.70007 26.6994 4.30619 27.3055 5.04999 27.3055H23.95C24.6938 27.3055 25.2999 26.6994 25.2999 25.9556V15.1556C25.2999 14.4103 25.9048 13.8057 26.6498 13.8057C27.3951 13.8057 28 14.4103 28 15.1556V25.9556C28 28.1885 26.1829 30.0056 23.95 30.0056Z" fill="#686B92" stroke="#686B92"/>
<mask id="path-2-outside-1" maskUnits="userSpaceOnUse" x="7.86316" y="0" width="24" height="24" fill="black">
<rect fill="white" x="7.86316" width="24" height="24"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2496 19.7503C11.5067 20.0071 11.8441 20.1365 12.1815 20.1365C12.519 20.1365 12.8566 20.0071 13.1134 19.7503L22.7268 10.137L25.7495 13.1597C26.0012 13.4114 26.3386 13.5459 26.6814 13.5459C26.8515 13.5459 27.0227 13.5128 27.1863 13.4457C27.6779 13.2413 27.9994 12.7602 27.9994 12.2278V4.35584C28.0093 4.0064 27.8806 3.65384 27.6133 3.38666C27.3465 3.11973 26.9945 2.991 26.6455 3.00049H18.7724C18.2399 3.00049 17.7587 3.32222 17.5545 3.81388C17.35 4.30699 17.4635 4.8737 17.8405 5.25071L20.8629 8.27316L11.2496 17.8863C10.7343 18.4018 10.7343 19.2348 11.2496 19.7503Z"/>
</mask>
<path class="active" fill-rule="evenodd" clip-rule="evenodd" d="M11.2496 19.7503C11.5067 20.0071 11.8441 20.1365 12.1815 20.1365C12.519 20.1365 12.8566 20.0071 13.1134 19.7503L22.7268 10.137L25.7495 13.1597C26.0012 13.4114 26.3386 13.5459 26.6814 13.5459C26.8515 13.5459 27.0227 13.5128 27.1863 13.4457C27.6779 13.2413 27.9994 12.7602 27.9994 12.2278V4.35584C28.0093 4.0064 27.8806 3.65384 27.6133 3.38666C27.3465 3.11973 26.9945 2.991 26.6455 3.00049H18.7724C18.2399 3.00049 17.7587 3.32222 17.5545 3.81388C17.35 4.30699 17.4635 4.8737 17.8405 5.25071L20.8629 8.27316L11.2496 17.8863C10.7343 18.4018 10.7343 19.2348 11.2496 19.7503Z" fill="#FAFAFA"/>
<path class="alter" d="M11.2496 19.7503L9.12782 21.8712L9.12931 21.8726L11.2496 19.7503ZM13.1134 19.7503L10.9921 17.629L10.9921 17.629L13.1134 19.7503ZM22.7268 10.137L24.8481 8.01568L22.7268 5.89436L20.6055 8.01568L22.7268 10.137ZM25.7495 13.1597L23.6281 15.281L23.6281 15.281L25.7495 13.1597ZM27.1863 13.4457L28.3244 16.2214L28.3313 16.2186L28.3381 16.2158L27.1863 13.4457ZM27.9994 4.35584L25.0006 4.27108L24.9994 4.31345V4.35584H27.9994ZM27.6133 3.38666L25.4915 5.50749L25.4925 5.50848L27.6133 3.38666ZM26.6455 3.00049V6.00049H26.6862L26.727 5.99938L26.6455 3.00049ZM17.5545 3.81388L14.7839 2.66322L14.7832 2.66495L17.5545 3.81388ZM17.8405 5.25071L19.9618 3.12939L19.9618 3.12939L17.8405 5.25071ZM20.8629 8.27316L22.9842 10.3945L25.1056 8.27318L22.9843 6.15184L20.8629 8.27316ZM11.2496 17.8863L9.12834 15.765L9.12782 15.7655L11.2496 17.8863ZM12.1815 17.1365C12.6102 17.1365 13.0443 17.3026 13.37 17.628L9.12931 21.8726C9.96912 22.7117 11.078 23.1365 12.1815 23.1365V17.1365ZM10.9921 17.629C11.319 17.3021 11.7537 17.1365 12.1815 17.1365V23.1365C13.2842 23.1365 14.3942 22.7122 15.2348 21.8716L10.9921 17.629ZM20.6055 8.01568L10.9921 17.629L15.2348 21.8717L24.8481 12.2583L20.6055 8.01568ZM20.6055 12.2583L23.6281 15.281L27.8708 11.0384L24.8481 8.01568L20.6055 12.2583ZM23.6281 15.281C24.4531 16.1059 25.5581 16.5459 26.6814 16.5459V10.5459C27.1192 10.5459 27.5493 10.7169 27.8708 11.0384L23.6281 15.281ZM26.6814 16.5459C27.2419 16.5459 27.7997 16.4366 28.3244 16.2214L26.0482 10.67C26.2456 10.589 26.4611 10.5459 26.6814 10.5459V16.5459ZM28.3381 16.2158C29.9468 15.5469 30.9994 13.9743 30.9994 12.2278H24.9994C24.9994 11.5462 25.4091 10.9357 26.0345 10.6756L28.3381 16.2158ZM30.9994 12.2278V4.35584H24.9994V12.2278H30.9994ZM25.4925 5.50848C25.1539 5.17009 24.9881 4.71481 25.0006 4.27108L30.9982 4.44059C31.0305 3.29798 30.6073 2.13759 29.7341 1.26485L25.4925 5.50848ZM26.727 5.99938C26.284 6.01142 25.8295 5.84568 25.4915 5.50749L29.7351 1.26584C28.8635 0.393772 27.7049 -0.0294154 26.564 0.00159574L26.727 5.99938ZM26.6455 0.000488281H18.7724V6.00049H26.6455V0.000488281ZM18.7724 0.000488281C17.0258 0.000488281 15.4524 1.05359 14.7839 2.66322L20.325 4.96454C20.0649 5.59085 19.4541 6.00049 18.7724 6.00049V0.000488281ZM14.7832 2.66495C14.1128 4.28193 14.486 6.13884 15.7192 7.37203L19.9618 3.12939C20.441 3.60857 20.5873 4.33204 20.3257 4.96281L14.7832 2.66495ZM15.7192 7.37203L18.7416 10.3945L22.9843 6.15184L19.9618 3.12939L15.7192 7.37203ZM13.3709 20.0076L22.9842 10.3945L18.7416 6.15182L9.12834 15.765L13.3709 20.0076ZM13.3715 17.6295C14.0271 18.2854 14.0271 19.3512 13.3715 20.0071L9.12782 15.7655C7.44161 17.4525 7.4416 20.1841 9.12782 21.8712L13.3715 17.6295Z" fill="#040849" mask="url(#path-2-outside-1)"/>
</svg>
'
			],
		];


		return apply_filters( "aheto_plugin_dashboard_pages", $plugin_dashboard_pages );
	}


	/**
	 * Get assets url.
	 *
	 * @return string
	 */
	public function assets() {
		return $this->plugin_url() . 'assets/';
	}


}
