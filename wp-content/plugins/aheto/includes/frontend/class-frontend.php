<?php
/**
 * The Frontend
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Frontend;

//use Aheto\Admin\Css_Generator;
use Aheto\Helper;
use Aheto\Sanitize;
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Frontend class.
 */
class Frontend {

	use Hooker;

	/**
	 * Current builder.
	 *
	 * @var string
	 */
	public $builder;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		aheto()->settings->add_option( 'aheto-general-settings', 'general' );

		$this->includes();
		$this->action( 'wp_head', 'add_custom_html_to_head', 10 );
		$this->action( 'wp_head', 'add_inline_css', 99 );
		$this->action( 'wp_head', 'add_custom_javascript', 9999 );
		$this->action( 'template_redirect', 'setup_layout' );
		$this->action( 'template_include', 'template_include' );
		$this->action( 'wp_enqueue_scripts', 'elementor_post_css_file' );
		$this->filter( 'body_class', 'add_body_class' );
		$this->filter( 'wp_nav_menu_args', 'add_megamenu_walker', 110 );
	}

	/**
	 * Includes functions files.
	 */
	private function includes() {
		$dir = aheto()->plugin_dir() . 'includes/';

		include_once $dir . 'aheto-core-functions.php';
		include_once $dir . 'aheto-template-functions.php';
		include_once $dir . 'aheto-template-hooks.php';

		new Script_Manager;
	}

	/**
	 * Modify the walker.
	 *
	 * @param array $args Array of wp_nav_menu() arguments.
	 *
	 * @return array
	 */
	public function add_megamenu_walker( $args ) {

		if ( isset( $args['container_class'] ) && \strpos( $args['container_class'], 'menu-home-page-container' ) !== false ) {
			$args['walker'] = new \Aheto\Megamenu_Nav_Walker;
		}

		return $args;
	}

	/**
	 * Setup layout based on settings.
	 */
	public function setup_layout() {

		if ( is_404() || is_search() || is_category() || is_tag() || is_archive() ) {
			$post_id = '';
		} else if ( is_home() ) {
			$post_id = get_queried_object_id();
		} else if ( function_exists( "is_woocommerce" ) ) {
			$post_id = get_post() === NULL ? NULL : get_post()->ID;
			$post_id = is_shop() ? wc_get_page_id( 'shop' ) : $post_id;
		} else {
			$post_id = get_post()->ID;
		}


		$this->header_id = aheto_get_header_id( $post_id );
		$this->footer_id = aheto_get_footer_id( $post_id );
		$this->skins_id  = aheto_get_skins_id( $post_id );
		$this->builder   = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';

	}

	/**
	 * Include template conditionaly.
	 *
	 * @param string $template The path of the template to include.
	 *
	 * @return string
	 */
	public function template_include( $template ) {
		$layout      = Helper::get_settings( 'general.single_template', 'theme' );
		$layout      = is_array( $layout ) ? $layout['search_select'] : $layout;
		$list_layout = Helper::get_settings( 'general.blog_template', 'theme' );
		$list_layout = is_array( $list_layout ) ? $list_layout['search_select'] : $list_layout;
		$redirect_page_id = Helper::get_settings( 'general.404_redirect' );
		$redirect_page_slug = Helper::get_settings( 'general.404_redirect_slug' );

		if ( is_singular( 'post' ) && 'theme' !== $layout ) {
			add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

			return aheto()->plugin_dir() . 'templates/blog/' . $layout . '.php';
		}

		if ( ( is_home() || is_search() || is_category() || is_archive() || is_tag() ) && 'theme' !== $list_layout ) {

			return aheto()->plugin_dir() . 'templates/blog/list/index.php';
		}

		if ( is_404() && !empty($redirect_page_id) && $redirect_page_slug ) {

			return aheto()->plugin_dir() . 'templates/404.php';
		}

		return $template;
	}

	public function add_custom_html_to_head() {
		$custom_html = aheto()->settings->get( 'general.custom_html' );

		if ( $custom_html ) {
			echo $custom_html;
		}
	}


	/**
	 * Add body classes according to layout.
	 *
	 * @param array $classes An array of body classes.
	 *
	 * @return array
	 */
	public function add_body_class( $classes ) {
		$layout = Helper::get_settings( 'general.single_template', 'theme' );

		if ( is_singular( 'post' ) && 'theme' !== $layout ) {
			$classes[] = 'blog--single';
			$classes[] = 'fullwidth' === $layout ? 'blog--single__full' : 'blog--single__sidebar';
		}

		return $classes;
	}


	/**
	 * Enqueue styles and scripts.
	 */
	public function elementor_post_css_file() {
		if ( ! class_exists( '\\Elementor\\Core\\Files\\CSS\\Post' ) || 'elementor' !== $this->builder ) {
			return;
		}

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}

		if ( $this->header_id ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $this->header_id );
			$css_file->enqueue();
		}

		if ( $this->footer_id ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $this->footer_id );
			$css_file->enqueue();
		}
	}

	/**
	 * Add inline CSS.
	 */
	public function add_inline_css() {
		$this->get_post_custom_css();
		if ( 'visual-composer' === $this->builder ) {
			$this->get_vc_custom_css( $this->header_id );
			$this->get_vc_custom_css( $this->footer_id );
		}

		// No Header and Footer.
		$output = '<style type="text/css">';
		if ( empty( $this->header_id ) ) {
			$output .= '.aheto-header { display:none !important }';
		}
		if ( empty( $this->footer_id ) ) {
			$output .= '.aheto-footer { display:none !important }';
		}

		if ( $custom_css = $this->add_custom_css() ) {
			$output .= ' ' . $custom_css;
		}

		$output .= '</style>';

		echo $output;
	}

	public function add_custom_css() {
		return aheto()->settings->get( 'general.custom_css' );
	}

	/**
	 * Get custom css for VC.
	 *
	 * @param integer $post_id Post id.
	 */
	public function get_vc_custom_css( $post_id ) {
		$output = '';
		if ( ! $post_id ) {
			return;
		}

		$post_custom_css = get_post_meta( $post_id, '_wpb_post_custom_css', true );
		if ( ! empty( $post_custom_css ) ) {
			$post_custom_css = strip_tags( $post_custom_css );

			$output .= '<style type="text/css" data-type="vc_custom-css">';
			$output .= $post_custom_css;
			$output .= '</style>';
		}

		$shortcodes_custom_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );

			$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			$output .= $shortcodes_custom_css;
			$output .= '</style>';
		}

		echo $output;
	}

	/**
	 * Get custom css for header and footer.
	 */
	public function get_post_custom_css() {
		$css    = [];
		$output = '';

		// Header Custom CSS.
		if ( $this->header_id ) {
		}

		// Footer Custom CSS.
		if ( $this->footer_id ) {
			$metas = Helper::get_post_metas( $this->footer_id, [
				'text_color',
				'link_color',
				'padding',
				'background',
			], 'aheto_footer_' );

			aheto_add_props( $css['global']['body .aheto-footer'], Sanitize::spacing( $metas['padding'] ) );
			if ( isset( Sanitize::background( $metas['background'] )["background-color"] ) && Sanitize::background( $metas['background'] )["background-color"] != '#' ) {
				aheto_add_props( $css['global']['body .aheto-footer'], Sanitize::background( $metas['background'] ) );
			}

			$css['global']['body .aheto-footer, body .aheto-footer p']['color'] = Sanitize::color( $metas['text_color'] );
			$css['global']['body .aheto-footer a']['color']                     = Sanitize::color( $metas['link_color'] );
		}

		$output .= Helper::dynamic_css_parser( $css );

		if ( ! empty( $output ) ) {
			echo '<style type="text/css">' . $output . '</style>';
		}
	}

	public function add_custom_javascript() {
		$output = '';
		$custom = aheto()->settings->get( 'general.custom_js' );
		if ( $custom ) {
			$output .= '<script>';
			$output .= ' ' . $custom;
			$output .= '</script>';
		}

		echo $output;
	}

	/**
	 * Get builder content for activated builder
	 *
	 * @param  int $post_id Post id to get content for.
	 *
	 * @return string
	 */
	public function get_builder_content_for_display( $post_id ) {
		if ( post_password_required( $post_id ) ) {
			return '';
		}

		$content = '';
		if ( 'visual-composer' === $this->builder ) {
			$content = get_post_field( 'post_content', $post_id, 'raw' );
			$content = do_shortcode( $content );
		} elseif ( 'elementor' === $this->builder ) {
			$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
		}

		wp_reset_query();

		return $content;
	}

}
